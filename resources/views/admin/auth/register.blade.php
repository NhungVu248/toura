<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Register</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #0d6efd, #1e293b);
            height: 100vh;
        }

        .register-card {
            border-radius: 15px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

<div class="col-md-4">
    <div class="card shadow-lg register-card">
        <div class="card-body p-4">

            <h4 class="text-center mb-4">Đăng ký Admin</h4>

            {{-- Hiển thị lỗi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.register.submit') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Họ tên</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name') }}"
                           required>
                </div>

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

                <div class="mb-3">
                    <label class="form-label">Xác nhận mật khẩu</label>
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           required>
                </div>

                <button type="submit" class="btn btn-success w-100 mb-3">
                    Đăng ký
                </button>
            </form>

            <div class="text-center">
                <span>Đã có tài khoản?</span>
                <a href="{{ route('admin.login') }}" class="text-decoration-none">
                    Quay lại đăng nhập
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>