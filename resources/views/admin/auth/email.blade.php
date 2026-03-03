<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Xác Thực Tài Khoản Admin</title>

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
        
        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 10px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

<div class="col-md-4">
    <div class="card shadow-lg login-card">
        <div class="card-body p-4">

            <h4 class="text-center mb-4">Khôi Phục Mật Khẩu</h4>
            <p class="text-center text-muted small mb-4">
                Vui lòng nhập Email admin đã đăng ký. Hệ thống sẽ xác thực và cho phép bạn đặt lại mật khẩu ngay lập tức.
            </p>

            {{-- Hiển thị thông báo thành công --}}
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Hiển thị lỗi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.password.email') }}">
                @csrf

                <div class="mb-4">
                    <label class="form-label">Email quản trị</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="admin@example.com"
                           value="{{ old('email') }}"
                           required autofocus>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    Xác nhận Email
                </button>
            </form>

            <div class="text-center mt-2">
                <a href="{{ route('admin.login') }}" class="text-decoration-none text-secondary">
                    <small>← Quay lại đăng nhập</small>
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>