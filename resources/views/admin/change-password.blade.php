@extends('admin.layouts.master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="m-0">Đổi mật khẩu</h3>
    <a href="{{ route('admin.profile') }}" class="btn btn-secondary btn-sm">
        ← Quay lại Hồ sơ
    </a>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                {{-- Báo lỗi tổng quan nếu có --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.password.change.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-muted">Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" class="form-control" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Mật khẩu mới</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted">Xác nhận mật khẩu mới</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-warning fw-bold">
                        Lưu mật khẩu mới
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection