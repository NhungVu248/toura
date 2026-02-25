<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ActivationController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\UserManagementController;

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
Route::get('/', function () {
    return view('dashboard');
});

Route::get('/auth/google', [SocialAuthController::class, 'redirect'])
    ->name('google.redirect');
Route::get('/auth/google/callback', [SocialAuthController::class, 'callback'])
    ->name('google.callback');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
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

    Route::middleware('auth:admin')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

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
        Route::get('/tours', function () {
            return "Tours page (chưa làm)";
        })->name('admin.tours');

        Route::get('/page-add-tours', function () {
            return "Add tours page (chưa làm)";
        })->name('admin.page-add-tours');

        // Booking
        Route::get('/booking', function () {
            return "Booking page (chưa làm)";
        })->name('admin.booking');

        // Contact
        Route::get('/contact', function () {
            return "Contact page (chưa làm)";
        })->name('admin.contact');
    });
});
require __DIR__.'/auth.php';
