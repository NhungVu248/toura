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
        <input type="text" name="title"
               class="form-control"
               value="{{ old('title', $tour->title) }}"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Điểm đến</label>
        <input type="text" name="destination"
               class="form-control"
               value="{{ old('destination', $tour->destination) }}"
               required>
                </div>
                    <div class="col-md-6 mb-3">
                    <label class="form-label">Loại tour</label>

                    <select name="domain" class="form-select">

                        <option value="">-- Chọn loại tour --</option>

                        <option value="beach"
                            {{ old('domain', $tour->domain) == 'beach' ? 'selected' : '' }}>
                            Beach / Biển
                        </option>

                        <option value="mountain"
                            {{ old('domain', $tour->domain) == 'mountain' ? 'selected' : '' }}>
                            Mountain / Núi
                        </option>

                        <option value="city"
                            {{ old('domain', $tour->domain) == 'city' ? 'selected' : '' }}>
                            City / Thành phố
                        </option>

                        <option value="island"
                            {{ old('domain', $tour->domain) == 'island' ? 'selected' : '' }}>
                            Island / Đảo
                        </option>

                        <option value="adventure"
                            {{ old('domain', $tour->domain) == 'adventure' ? 'selected' : '' }}>
                            Adventure / Khám phá
                        </option>

                    </select>

                </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Nơi khởi hành</label>
        <input type="text" name="departure_location"
               class="form-control"
               value="{{ old('departure_location', $tour->departure_location) }}"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Địa chỉ chi tiết</label>
        <input type="text" name="location_address"
               class="form-control"
               value="{{ old('location_address', $tour->location_address) }}">
    </div>

    {{-- Duration TEXT --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Thời gian</label>
        <input type="text"
               name="duration"
               class="form-control"
               value="{{ old('duration', $tour->duration) }}"
               required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Sức chứa</label>
        <input type="number"
               name="capacity"
               class="form-control"
               value="{{ old('capacity', $tour->capacity) }}">
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Giá người lớn</label>
        <input type="text"
               name="price_adult"
               class="form-control"
               value="{{ old('price_adult', $tour->price_adult) }}"
               required>
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Giá gốc</label>
        <input type="text"
               name="price_original"
               class="form-control"
               value="{{ old('price_original', $tour->price_original) }}">
    </div>

    <div class="col-md-4 mb-3">
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

    {{-- Highlights --}}
    <div class="col-12 mb-3">
        <label class="form-label">Highlights</label>
        <textarea name="highlights"
                  class="form-control"
                  rows="3">{{ old('highlights', $tour->highlights) }}</textarea>
    </div>

    {{-- Included Services --}}
    <div class="col-12 mb-3">
        <label class="form-label">Dịch vụ bao gồm</label>
        <textarea name="included_services"
                  class="form-control"
                  rows="3">{{ old('included_services', $tour->included_services) }}</textarea>
    </div>

    {{-- Itinerary --}}
    <div class="col-12 mb-3">
        <label class="form-label">Lịch trình</label>
        <textarea name="itinerary"
                  class="form-control"
                  rows="5">{{ old('itinerary', $tour->itinerary) }}</textarea>
    </div>

    {{-- Cancellation Policy --}}
    <div class="col-12 mb-3">
        <label class="form-label">Chính sách hủy</label>
        <textarea name="cancellation_policy"
                  class="form-control"
                  rows="3">{{ old('cancellation_policy', $tour->cancellation_policy) }}</textarea>
    </div>

    {{-- Booking Conditions --}}
    <div class="col-12 mb-3">
        <label class="form-label">Điều kiện đặt tour</label>
        <textarea name="booking_conditions"
                  class="form-control"
                  rows="3">{{ old('booking_conditions', $tour->booking_conditions) }}</textarea>
    </div>
    {{-- THUMBNAIL --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Thumbnail</label>

        @if($tour->thumbnail)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $tour->thumbnail) }}"
                    class="img-fluid rounded border"
                    style="max-height:150px;">
            </div>
        @endif

        <input type="file"
            name="thumbnail"
            class="form-control"
            accept="image/*">
    </div>

    {{-- GALLERY IMAGES --}}
    <div class="col-md-6 mb-3">
        <label class="form-label">Ảnh phụ</label>

        @if($tour->images->count())
            <div class="row mb-2">
                @foreach($tour->images as $img)
                    <div class="col-4 mb-2">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $img->path) }}"
                                class="img-fluid rounded border"
                                style="height:100px; object-fit:cover; width:100%;">

                            {{-- Nếu bạn có route xóa ảnh --}}
                            <a href="{{ route('admin.tours.images.delete', $img->id) }}"
   class="btn btn-sm btn-danger position-absolute top-0 end-0">
   ×
</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <input type="file"
            name="images[]"
            multiple
            class="form-control"
            accept="image/*">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Trạng thái</label>
        <select name="status" class="form-select">
            <option value="active" {{ $tour->status === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $tour->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
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