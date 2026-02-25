{{-- resources/views/admin/users/edit.blade.php --}}
@extends('admin.layouts.master')

@section('content')

<h3 class="mb-4">Chỉnh sửa người dùng</h3>

<div class="card shadow-sm">
    <div class="card-body">

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tên</label>
                <input type="text"
                       name="name"
                       class="form-control"
                       value="{{ old('name', $user->name) }}"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email"
                       class="form-control"
                       value="{{ $user->email }}"
                       disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>
                        User
                    </option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.users.index') }}"
                   class="btn btn-secondary">
                    Quay lại
                </a>

                <button class="btn btn-primary">
                    Cập nhật
                </button>
            </div>

        </form>

    </div>
</div>

@endsection