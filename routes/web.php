<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\TourController as AdminTourController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Admin\NewsletterController as AdminNewsletterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BlogController;

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::get('/activate/{token}', [ActivationController::class, 'activate'])->name('auth.activate');
Route::post('/activate/resend', [ActivationController::class, 'resend'])->name('auth.activate.resend');
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::get('/', [DashboardController::class,'index'])
    ->name('dashboard');

Route::get('/auth/google', [SocialAuthController::class, 'redirect'])
    ->name('google.redirect');
Route::get('/auth/google/callback', [SocialAuthController::class, 'callback'])
    ->name('google.callback');

Route::get('/dashboard', [DashboardController::class,'index'])
    ->name('dashboard');
Route::get('/gioi-thieu', function () {
    return view('about'); // Trỏ tới file resources/views/about.blade.php
})->name('about');
Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/tours/{tour:slug}', [TourController::class, 'show'])
    ->name('tours.show');
Route::post('/tours/{tour}/reviews', 
        [ReviewController::class, 'store']
         )->middleware('auth')->name('tours.reviews.store');
         Route::get('/tours/{tour}/book', [ClientBookingController::class, 'create'])->name('booking.create');
Route::post('/bookings', [ClientBookingController::class, 'store'])->name('booking.store');
Route::get('/bookings/{booking}', [ClientBookingController::class, 'show'])->name('booking.show'); // optional
 Route::get('/checkout/{booking}', [CheckoutController::class,'show'])->name('checkout.show');
    Route::post('/checkout/{booking}', [CheckoutController::class,'store'])->name('checkout.store');
Route::get('/checkout-success/{payment}', [CheckoutController::class,'success'])->name('checkout.success');
Route::get('/contact',[ContactController::class,'create'])->name('contact.create');

Route::post('/contact',[ContactController::class,'store'])->name('contact.store');

Route::get('/contact/thanks',[ContactController::class,'thanks'])->name('contact.thanks');
Route::get('/destination', [DestinationController::class, 'index'])->name('destination.index');
Route::post('/newsletter/subscribe',[NewsletterController::class,'subscribe'])
->name('newsletter.subscribe');
Route::get('/blogs',[BlogController::class,'index'])
    ->name('blogs.index');

Route::get('/blogs/{slug}',[BlogController::class,'show'])
    ->name('blogs.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/my-bookings',[\App\Http\Controllers\Client\BookingController::class,'myBookings'])
    ->name('booking.my');
});

Route::prefix('admin')->group(function () {

    // Nếu chưa login → vào login
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])
        ->name('admin.login');

    Route::post('/login', [AdminLoginController::class, 'login'])
        ->name('admin.login.submit');

    // Nếu chưa có tài khoản → đăng ký
    Route::get('/register', [AdminLoginController::class, 'showRegisterForm'])
        ->name('admin.register');

    Route::post('/register', [AdminLoginController::class, 'register'])
        ->name('admin.register.submit');
        
    Route::get('password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
    Route::post('password/email', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');

   // Trang nhập mật khẩu mới (Bỏ {token}, dùng email làm tham số xác định)
    Route::get('password/reset-confirm', [AdminForgotPasswordController::class, 'showResetForm'])->name('admin.password.reset.form');

    // Xử lý cập nhật mật khẩu mới vào Database
    Route::post('password/reset-update', [AdminForgotPasswordController::class, 'reset'])->name('admin.password.update');
    
    Route::middleware('auth:admin')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
        Route::get('/profile', function () {
            return view('admin.profile');
        })->name('admin.profile');
        Route::get('/edit', [\App\Http\Controllers\Admin\AdminProfileController::class, 'editProfile'])->name('admin.profile.edit');
        Route::put('/edit', [\App\Http\Controllers\Admin\AdminProfileController::class, 'updateProfile'])->name('admin.profile.update');
        
        Route::get('/change-password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'showChangePasswordForm'])->name('admin.password.change.form');
        Route::post('/change-password', [\App\Http\Controllers\Admin\AdminProfileController::class, 'updatePassword'])->name('admin.password.change.update');

        Route::post('/logout', [AdminLoginController::class, 'logout'])
            ->name('admin.logout');
        // User management
        Route::get('/users', [\App\Http\Controllers\Admin\UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('/users/{id}/edit', [\App\Http\Controllers\Admin\UserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{id}', [\App\Http\Controllers\Admin\UserManagementController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserManagementController::class, 'destroy'])->name('admin.users.destroy');
        Route::get('/users/{id}', 
            [UserManagementController::class, 'show']
        )->name('admin.users.show');
        // Tours
        Route::resource('tours', AdminTourController::class)
        ->parameters(['tours' => 'tour'])
        ->scoped([
            'tour' => 'id'
        ])
        ->names('admin.tours');
        Route::delete('/admin/tours/images/{id}', 
        [TourController::class, 'deleteImage'])
        ->name('admin.tours.images.delete');

        Route::get('/bookings', [AdminBookingController::class, 'index'])->name('admin.bookings.index');
        Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('admin.bookings.show');
        Route::post('/bookings/{booking}/confirm', [AdminBookingController::class, 'confirm'])->name('admin.bookings.confirm');
        Route::post('/bookings/{booking}/mark-paid', [AdminBookingController::class, 'markPaid'])->name('admin.bookings.markPaid');
        Route::delete('/bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('admin.bookings.destroy');
        Route::get('/payments', [PaymentController::class,'index'])->name('payments.index');
        Route::get('/payments/{id}', [PaymentController::class,'show'])->name('payments.show');
        Route::post('/payments/{id}/fail', [PaymentController::class,'fail'])->name('payments.fail');
        Route::post('/admin/payments/{payment}/confirm',[PaymentController::class,'confirm'])->name('admin.payments.confirm');        // Contact
        Route::get('/contacts',[AdminContactController::class,'index'])
            ->name('admin.contacts.index');

        Route::get('/contacts/{id}',[AdminContactController::class,'show'])
            ->name('admin.contacts.show');

        Route::post('/contacts/{id}/reply',[AdminContactController::class,'reply'])
            ->name('admin.contacts.reply');

        Route::delete('/contacts/{id}',[AdminContactController::class,'destroy'])
            ->name('admin.contacts.destroy');
            });
         Route::get('/newsletter',
                [AdminNewsletterController::class,'index']
            )->name('admin.newsletter.index');

    Route::delete('/newsletter/{id}',
        [AdminNewsletterController::class,'destroy']
    )->name('admin.newsletter.delete');
    Route::resource('blogs', \App\Http\Controllers\Admin\BlogController::class)
        ->names('admin.blogs');
});
require __DIR__.'/auth.php';
