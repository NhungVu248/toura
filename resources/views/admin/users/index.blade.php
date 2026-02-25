@extends('admin.layouts.master')

@section('content')

<h3 class="mb-4">Quản lý người dùng</h3>

<div class="card shadow-sm">
    <div class="card-body">

        <!-- SEARCH FORM -->
        <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
            <div class="row g-2">
                <div class="col-md-4">
                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Tìm theo tên hoặc email..."
                           value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        <i class="fa fa-search"></i> Tìm kiếm
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="{{ route('admin.users.index') }}"
                       class="btn btn-secondary w-100">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- TABLE -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="60">ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th width="120">Role</th>
                        <th width="140">Ngày tạo</th>
                        <th width="150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                    <tr>
                        <td>{{ $u->id }}</td>
                        <td>{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>

                        <td>
                            @if($u->role == 'admin')
                                <span class="badge bg-danger">Admin</span>
                            @else
                                <span class="badge bg-success">User</span>
                            @endif
                        </td>

                        <td>{{ $u->created_at->format('d/m/Y') }}</td>

                        <td>

    {{-- Nút XEM --}}
    <a href="{{ route('admin.users.show',$u->id) }}"
       class="btn btn-sm btn-info">
        <i class="fa fa-eye"></i>
    </a>

    {{-- Nút SỬA --}}
    <a href="{{ route('admin.users.edit',$u->id) }}"
       class="btn btn-sm btn-warning">
        <i class="fa fa-edit"></i>
    </a>

    {{-- Nút XÓA --}}
    <form action="{{ route('admin.users.destroy',$u->id) }}"
          method="POST"
          style="display:inline-block;"
          onsubmit="return confirm('Bạn chắc chắn muốn xóa user này?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger">
            <i class="fa fa-trash"></i>
        </button>
    </form>

</td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Không có dữ liệu
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-3">
            {{ $users->links() }}
        </div>

    </div>
</div>

@endsection