<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    
    public function showChangePasswordForm()
    {
        return view('admin.change-password');
    }

    // Xử lý lưu mật khẩu mới
    public function updatePassword(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            // Rule 'current_password:admin' sẽ tự động kiểm tra xem pass cũ có đúng với pass của guard admin đang đăng nhập hay không
            'current_password' => ['required', 'current_password:admin'], 
            'password' => ['required', 'min:6', 'confirmed'],
        ], [
            'current_password.current_password' => 'Mật khẩu hiện tại không chính xác.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
        ]);

        //Lấy thông tin Admin đang đăng nhập và cập nhật
        $admin = auth('admin')->user();
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Đã thay đổi mật khẩu thành công!');
    }
    public function editProfile()
    {
        $admin = auth('admin')->user();
        return view('admin.edit-profile', compact('admin'));
    }
    // Xử lý lưu thông tin hồ sơ
    public function updateProfile(Request $request)
    {
        /** @var \App\Models\Admin $admin */
        $admin = auth('admin')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.unique' => 'Email này đã được tài khoản khác sử dụng.',
        ]);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save(); 

        return redirect()->route('admin.profile')->with('success', 'Đã cập nhật thông tin hồ sơ thành công!');
    }
}