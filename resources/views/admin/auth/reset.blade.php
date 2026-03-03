<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt Lại Mật Khẩu Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1e293b, #0d6efd);
            height: 100vh;
            margin: 0;
        }

        .login-card {
            border-radius: 15px;
            border: none;
        }
        
        .btn-success {
            padding: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

<div class="col-md-4">
    <div class="card shadow-lg login-card">
        <div class="card-body p-4">

            <h4 class="text-center mb-4">Tạo Mật Khẩu Mới</h4>
            <p class="text-center text-muted small mb-4">Vui lòng nhập mật khẩu mới cho tài khoản của bạn.</p>

            {{-- Hiển thị lỗi validate --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf

                {{-- Loại bỏ trường Token vì chúng ta không dùng Token mặc định nữa --}}

                <div class="mb-3">
                    <label class="form-label">Email tài khoản</label>
                    {{-- Email được lấy từ URL thông qua biến $email truyền từ Controller --}}
                    <input type="email"
                           name="email"
                           class="form-control bg-light"
                           value="{{ $email ?? request()->email }}"
                           required readonly>
                    <small class="text-muted">Bạn đang đổi mật khẩu cho email này.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mật khẩu mới</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Ít nhất 6 ký tự"
                           required autofocus>
                </div>

                <div class="mb-4">
                    <label class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Nhập lại mật khẩu mới"
                           required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Cập nhật mật khẩu
                </button>
            </form>

            <div class="text-center mt-3">
                <a href="{{ route('admin.password.request') }}" class="text-decoration-none text-secondary">
                    <small>Quay lại bước trước</small>
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>