@extends('admin.layouts.master')
@section('content')

<div class="p-6">

    <h2 class="text-2xl font-bold mb-6">
        Chi tiết người dùng
    </h2>

    <div class="bg-white shadow rounded-lg p-6 space-y-4">

        <div>
            <strong>ID:</strong> {{ $user->id }}
        </div>

        <div>
            <strong>Tên:</strong> {{ $user->name }}
        </div>

        <div>
            <strong>Email:</strong> {{ $user->email }}
        </div>

        <div>
            <strong>Role:</strong>
            <span class="px-2 py-1 rounded text-sm
                {{ $user->role == 'admin' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }}">
                {{ $user->role }}
            </span>
        </div>

        <div>
            <strong>Email verified:</strong>
            {{ $user->email_verified_at ? 'Đã xác thực' : 'Chưa xác thực' }}
        </div>

        <div>
            <strong>Ngày tạo:</strong>
            {{ $user->created_at->format('d/m/Y H:i') }}
        </div>

        <div>
            <strong>Cập nhật lần cuối:</strong>
            {{ $user->updated_at->format('d/m/Y H:i') }}
        </div>

    </div>

    <div class="mt-6">
        <a href="{{ route('admin.users.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ← Quay lại
        </a>
    </div>

</div>

@endsection