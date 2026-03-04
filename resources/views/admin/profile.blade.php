@extends('admin.layouts.master')

@section('content')

<h3 class="mb-4">Hồ sơ cá nhân</h3>
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<div class="row">
    {{-- Cột Trái: Ảnh đại diện & Tên --}}
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                {{-- Dùng UI-Avatars để tự động tạo ảnh dựa trên tên Admin --}}
                @php
                    $admin = auth('admin')->user();
                    $avatarUrl = $admin->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($admin->name) . '&background=0D8ABC&color=fff&size=150';
                @endphp
                
                <img src="{{ $avatarUrl }}" alt="Admin Avatar" class="rounded-circle mb-3 shadow-sm" width="150" height="150" style="object-fit: cover;">
                
                <h4 class="mb-1">{{ $admin->name }}</h4>
                <p class="text-muted mb-3">Quản trị viên (Admin)</p>
            </div>
        </div>
    </div>

    {{-- Cột Phải: Thông tin chi tiết & Các nút hành động --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="card-title mb-4 border-bottom pb-2">Thông tin chi tiết</h5>
                
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Họ và tên</div>
                    <div class="col-sm-9 fw-bold">{{ $admin->name }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-sm-3 text-muted">Email đăng nhập</div>
                    <div class="col-sm-9 fw-bold">{{ $admin->email }}</div>
                </div>

                <hr>

                {{-- Nút bấm hành động --}}
                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('admin.profile.edit') }}" class="btn btn-outline-primary fw-semibold">
                        Sửa hồ sơ
                    </a>

                    {{-- Nút Đổi mật khẩu --}}
                    <a href="{{ route('admin.password.change.form') ?? '#' }}" class="btn btn-warning text-dark fw-semibold">
                        Đổi mật khẩu
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection