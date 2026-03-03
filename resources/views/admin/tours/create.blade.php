@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Tạo Tour mới</h4>

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
                  action="{{ route('admin.tours.store') }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- TIÊU ĐỀ --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text" name="title"
                               class="form-control"
                               value="{{ old('title') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Điểm đến</label>
                        <input type="text" name="destination"
                               class="form-control"
                               value="{{ old('destination') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nơi khởi hành</label>
                        <input type="text" name="departure_location"
                               class="form-control"
                               value="{{ old('departure_location') }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Địa chỉ chi tiết</label>
                        <input type="text" name="location_address"
                               class="form-control"
                               value="{{ old('location_address') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Thời gian</label>
                        <input type="text" name="duration"
                               class="form-control"
                               value="{{ old('duration') }}"
                               placeholder="Ví dụ: 3 ngày 2 đêm"
                               required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sức chứa</label>
                        <input type="number" name="capacity"
                               class="form-control"
                               value="{{ old('capacity',30) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Giá người lớn</label>
                        <input type="text" name="price_adult"
                               class="form-control"
                               value="{{ old('price_adult') }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Giá gốc</label>
                        <input type="text" name="price_original"
                               class="form-control"
                               value="{{ old('price_original') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Giá trẻ em</label>
                        <input type="text" name="price_child"
                               class="form-control"
                               value="{{ old('price_child') }}">
                    </div>

                    {{-- MÔ TẢ --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Mô tả ngắn</label>
                        <textarea name="short_description"
                                  class="form-control"
                                  rows="2"
                                  required>{{ old('short_description') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Mô tả chi tiết</label>
                        <textarea name="description"
                                  class="form-control"
                                  rows="4"
                                  required>{{ old('description') }}</textarea>
                    </div>

                    {{-- HIGHLIGHTS --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Highlights</label>
                        <textarea name="highlights"
                                  class="form-control"
                                  rows="3">{{ old('highlights') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Dịch vụ bao gồm</label>
                        <textarea name="included_services"
                                  class="form-control"
                                  rows="3">{{ old('included_services') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Lịch trình</label>
                        <textarea name="itinerary"
                                  class="form-control"
                                  rows="4">{{ old('itinerary') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Chính sách hủy</label>
                        <textarea name="cancellation_policy"
                                  class="form-control"
                                  rows="3">{{ old('cancellation_policy') }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Điều kiện đặt tour</label>
                        <textarea name="booking_conditions"
                                  class="form-control"
                                  rows="3">{{ old('booking_conditions') }}</textarea>
                    </div>

                    {{-- ẢNH --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Thumbnail</label>
                        <input type="file"
                               name="thumbnail"
                               class="form-control"
                               accept="image/*">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ảnh phụ</label>
                        <input type="file"
                               name="images[]"
                               multiple
                               class="form-control"
                               accept="image/*">
                    </div>

                </div>

                <hr class="my-4">

                {{-- LỊCH KHỞI HÀNH --}}
                <h5 class="mb-3">Lịch khởi hành</h5>

                <div id="schedule-container"></div>

                <button type="button"
                        onclick="addSchedule()"
                        class="btn btn-outline-secondary mb-4">
                    + Thêm lịch
                </button>

                <hr>

                {{-- STATUS --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3 d-flex align-items-end">
                        <div class="form-check">
                            <input type="checkbox"
                                   name="is_featured"
                                   value="1"
                                   class="form-check-input">
                            <label class="form-check-label">
                                Đánh dấu nổi bật
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="btn btn-success">
                    <i class="fa fa-save me-2"></i> Lưu Tour
                </button>

            </form>

        </div>
    </div>

</div>

<script>
let scheduleIndex = 0;

function addSchedule() {

    const container = document.getElementById('schedule-container');

    const html = `
    <div class="row mb-3 border p-3 rounded">
        <div class="col-md-3">
            <input type="date"
                   name="schedules[${scheduleIndex}][departure_date]"
                   class="form-control">
        </div>

        <div class="col-md-2">
            <input type="time"
                   name="schedules[${scheduleIndex}][departure_time]"
                   class="form-control">
        </div>

        <div class="col-md-2">
            <input type="number"
                   name="schedules[${scheduleIndex}][seats_total]"
                   value="30"
                   class="form-control">
        </div>

        <div class="col-md-3">
            <input type="text"
                   name="schedules[${scheduleIndex}][price_override]"
                   placeholder="Giá riêng"
                   class="form-control">
        </div>

        <div class="col-md-2">
            <select name="schedules[${scheduleIndex}][status]"
                    class="form-select">
                <option value="open">Open</option>
                <option value="sold_out">Sold Out</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
    </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    scheduleIndex++;
}
</script>

@endsection