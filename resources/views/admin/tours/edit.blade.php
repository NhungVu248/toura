@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Chỉnh sửa Tour</h4>

        <a href="{{ route('admin.tours.index') }}"
           class="btn btn-secondary">
            <i class="fa fa-arrow-left me-2"></i> Quay lại
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.tours.update', $tour->id) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text"
                               name="title"
                               class="form-control"
                               value="{{ old('title', $tour->title) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Điểm đến</label>
                        <input type="text"
                               name="destination"
                               class="form-control"
                               value="{{ old('destination', $tour->destination) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nơi khởi hành</label>
                        <input type="text"
                               name="departure_location"
                               class="form-control"
                               value="{{ old('departure_location', $tour->departure_location) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Thời gian (ngày)</label>
                        <input type="number"
                               name="duration"
                               class="form-control"
                               value="{{ old('duration', $tour->duration) }}"
                               min="1"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá người lớn</label>
                        <input type="text"
                               name="price_adult"
                               class="form-control"
                               value="{{ old('price_adult', $tour->price_adult) }}"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Giá trẻ em</label>
                        <input type="text"
                               name="price_child"
                               class="form-control"
                               value="{{ old('price_child', $tour->price_child) }}">
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Mô tả ngắn</label>
                        <textarea name="short_description"
                                  class="form-control"
                                  rows="2"
                                  required>{{ old('short_description', $tour->short_description) }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Mô tả chi tiết</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="4"
                                  required>{{ old('description', $tour->description) }}</textarea>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="active"
                                {{ $tour->status === 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive"
                                {{ $tour->status === 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 d-flex align-items-end">
                        <div class="form-check">
                            <input type="checkbox"
                                   name="is_featured"
                                   value="1"
                                   class="form-check-input"
                                   {{ $tour->is_featured ? 'checked' : '' }}>
                            <label class="form-check-label">
                                Đánh dấu nổi bật
                            </label>
                        </div>
                    </div>

                    {{-- Thumbnail chính --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ảnh mới (Thumbnail)</label>
                        <input type="file"
                               name="thumbnail"
                               class="form-control"
                               accept="image/*">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Thumbnail hiện tại</label>
                        <div>
                            @if($tour->thumbnail)
                                <img src="{{ asset('storage/' . $tour->thumbnail) }}"
                                     style="width:150px; height:100px; object-fit:cover;"
                                     class="rounded border">
                            @else
                                <p class="text-muted">Chưa có ảnh</p>
                            @endif
                        </div>
                    </div>

                    {{-- Upload nhiều ảnh --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Ảnh phụ (có thể chọn nhiều)</label>
                        <input type="file"
                               name="images[]"
                               class="form-control"
                               multiple
                               accept="image/*">
                    </div>

                    {{-- Gallery hiện tại --}}
                    @if($tour->images && $tour->images->count())
                        <div class="col-12 mb-3">
                            <label class="form-label">Ảnh phụ hiện tại</label>
                            <div class="row">
                                @foreach($tour->images as $img)
                                    <div class="col-md-2 mb-3 text-center">
                                        <img src="{{ asset('storage/' . $img->path) }}"
                                             class="img-fluid rounded border"
                                             style="height:100px; object-fit:cover;">
                                        @if($img->is_primary)
                                            <small class="text-success d-block mt-1">
                                                Ảnh chính
                                            </small>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
                <hr class="my-4">

                <h5 class="mb-3">Lịch khởi hành</h5>

                <div id="schedule-container">

                    @foreach($tour->schedules as $index => $schedule)
                        <div class="row mb-3 border p-3 rounded">

                            <input type="hidden"
                                name="schedules[{{ $index }}][id]"
                                value="{{ $schedule->id }}">

                            <div class="col-md-3">
                                <label>Ngày</label>
                                <input type="date"
                                    name="schedules[{{ $index }}][departure_date]"
                                    value="{{ $schedule->departure_date }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label>Giờ</label>
                                <input type="time"
                                    name="schedules[{{ $index }}][departure_time]"
                                    value="{{ $schedule->departure_time }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label>Tổng chỗ</label>
                                <input type="number"
                                    name="schedules[{{ $index }}][seats_total]"
                                    value="{{ $schedule->seats_total }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label>Giá riêng</label>
                                <input type="text"
                                    name="schedules[{{ $index }}][price_override]"
                                    value="{{ $schedule->price_override }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label>Trạng thái</label>
                                <select name="schedules[{{ $index }}][status]"
                                        class="form-select">
                                    <option value="open" {{ $schedule->status=='open'?'selected':'' }}>Open</option>
                                    <option value="sold_out" {{ $schedule->status=='sold_out'?'selected':'' }}>Sold Out</option>
                                    <option value="cancelled" {{ $schedule->status=='cancelled'?'selected':'' }}>Cancelled</option>
                                </select>
                            </div>

                        </div>
                    @endforeach

                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save me-2"></i> Cập nhật Tour
                </button>

            </form>

        </div>
    </div>

</div>

@endsection