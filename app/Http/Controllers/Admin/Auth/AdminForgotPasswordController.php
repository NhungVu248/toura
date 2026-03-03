<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminForgotPasswordController extends Controller
{
    // Hiển thị form nhập email
    
    public function showLinkRequestForm()
    {
        return view('admin.auth.email'); 
    }

    // Kiểm tra email có tồn tại không
     
    public function sendResetLinkEmail(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate(['email' => 'required|email']);

        // Tìm Admin theo email
        $admin = Admin::where('email', $request->email)->first();

        if ($admin) {
            // Nếu đúng email, chuyển hướng thẳng sang trang đặt lại mật khẩu
            // Truyền email qua URL để trang sau biết đang đổi cho ai
            return redirect()->route('admin.password.reset.form', ['email' => $request->email])
                             ->with('success', 'Email hợp lệ, vui lòng nhập mật khẩu mới.');
        }

        // Nếu sai email, quay lại và báo lỗi
        return back()->withErrors(['email' => 'Email này không tồn tại trong hệ thống Admin!']);
    }

    //Hiển thị form nhập mật khẩu mới
     
    public function showResetForm(Request $request)
    {
        $email = $request->email;
        return view('admin.auth.reset', compact('email'));
    }

    /**
     * BƯỚC 4: Lưu mật khẩu mới vào Database
     */
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin) {
            $admin->password = Hash::make($request->password);
            $admin->save();

            return redirect()->route('admin.login')->with('status', 'Đã đổi mật khẩu thành công!');
        }

        return back()->withErrors(['email' => 'Có lỗi xảy ra, vui lòng thử lại sau.']);
    }
}