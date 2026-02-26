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

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ảnh mới (nếu muốn thay)</label>
                        <input type="file"
                               name="thumbnail"
                               class="form-control"
                               accept="image/*">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ảnh hiện tại</label>
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

                </div>

                <button type="submit" class="btn btn-success">
                    <i class="fa fa-save me-2"></i> Cập nhật Tour
                </button>

            </form>

        </div>
    </div>

</div>

@endsection