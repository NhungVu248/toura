@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Quản lý Tour</h4>

        <a href="{{ route('admin.tours.create') }}"
           class="btn btn-primary">
            <i class="fa fa-plus me-2"></i> Tạo Tour mới
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th width="120">Ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Điểm đến</th>
                            <th width="150">Giá (Adult)</th>
                            <th width="120">Trạng thái</th>
                            <th width="120">Nổi bật</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($tours as $tour)
                            <tr class="text-center">

                                {{-- Ảnh --}}
                                <td>
                                    @if ($tour->thumbnail)
                                        <img src="{{ asset('storage/' . $tour->thumbnail) }}"
                                             class="rounded"
                                             style="width:100px; height:70px; object-fit:cover;">
                                    @else
                                        <div class="bg-light text-muted py-3 small">
                                            No image
                                        </div>
                                    @endif
                                </td>

                                {{-- Tiêu đề --}}
                                <td class="text-start">
                                    <strong>{{ $tour->title }}</strong>
                                </td>

                                {{-- Điểm đến --}}
                                <td>{{ $tour->destination }}</td>

                                {{-- Giá --}}
                                <td>
                                    {{ number_format($tour->price_adult, 0, ',', '.') }} đ
                                </td>

                                {{-- Trạng thái --}}
                                <td>
                                    @if($tour->status === 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>

                                {{-- Nổi bật --}}
                                <td>
                                    @if($tour->is_featured)
                                        <span class="badge bg-primary">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td>
                                    <a href="{{ route('admin.tours.edit', $tour->id) }}"
                                       class="btn btn-sm btn-warning me-1">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.tours.destroy', $tour->id) }}"
                                          method="POST"
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Bạn chắc chứ?')"
                                                type="submit"
                                                class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Chưa có tour nào.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $tours->links() }}
    </div>

</div>

@endsection