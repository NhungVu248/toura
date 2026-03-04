@extends('admin.layouts.master')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="m-0">Chỉnh sửa hồ sơ</h3>
    <a href="{{ route('admin.profile') }}" class="btn btn-secondary btn-sm">
        ← Quay lại Hồ sơ
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                {{-- Báo lỗi validate --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Khai báo method PUT để update dữ liệu --}}

                    <div class="mb-3">
                        <label class="form-label text-muted">Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted">Email đăng nhập <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
                    </div>

                    <button type="submit" class="btn btn-primary fw-bold">
                        Lưu thay đổi
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection