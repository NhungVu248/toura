<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #1e293b, #0d6efd);
            height: 100vh;
        }

        .login-card {
            border-radius: 15px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

<div class="col-md-4">
    <div class="card shadow-lg login-card">
        <div class="card-body p-4">

            <h4 class="text-center mb-4">Đăng nhập Admin</h4>

            {{-- Hiển thị lỗi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Hiển thị thông báo thành công --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email') }}"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mật khẩu</label>
                    <input type="password"
                           name="password"
                           class="form-control"
                           required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">
                    Đăng nhập
                </button>
            </form>

            <div class="text-center">
                <span>Chưa có tài khoản?</span>
                <a href="{{ route('admin.register') }}" class="text-decoration-none">
                    Đăng ký
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>