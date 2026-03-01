@extends('admin.layouts.master')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-6">Tạo Tour mới</h2>
    <h2 class="text-2xl font-semibold mb-6">Tạo Tour mới</h2>

{{-- ===== DEBUG ERROR BLOCK ===== --}}
@if(session('error'))
    <div class="bg-red-600 text-white p-3 rounded mb-4">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <strong class="block mb-2">Có lỗi xảy ra:</strong>
        <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{-- ===== END DEBUG BLOCK ===== --}}
    <form method="POST" action="{{ route('admin.tours.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-2 gap-6">

            <div>
                <label class="block font-medium mb-1">Title</label>
                <input type="text" name="title"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('title') }}" required>
                @error('title')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="block font-medium mb-1">Destination</label>
                <input type="text" name="destination"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('destination') }}" required>
            </div>

            <div>
                <label class="block font-medium mb-1">Departure Location</label>
                <input type="text" name="departure_location"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('departure_location') }}" required>
            </div>

            <div>
                <label class="block font-medium mb-1">Duration (days)</label>
                <input type="number" name="duration"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('duration', 1) }}" min="1" required>
            </div>

            <div>
                <label class="block font-medium mb-1">Price adult</label>
                <input type="text" name="price_adult"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('price_adult') }}" required>
            </div>

            <div>
                <label class="block font-medium mb-1">Price child</label>
                <input type="text" name="price_child"
                       class="w-full border rounded px-3 py-2"
                       value="{{ old('price_child') }}">
            </div>

        </div>

        <div class="mt-6">
            <label class="block font-medium mb-1">Short description</label>
            <textarea name="short_description"
                      class="w-full border rounded px-3 py-2"
                      required>{{ old('short_description') }}</textarea>
        </div>

        <div class="mt-6">
            <label class="block font-medium mb-1">Description</label>
            <textarea name="description" rows="6"
                      class="w-full border rounded px-3 py-2"
                      required>{{ old('description') }}</textarea>
        </div>

        {{-- Thumbnail --}}
        <div class="mt-6">
            <label class="block font-medium mb-1">Thumbnail</label>
            <input type="file" name="thumbnail"
                   class="w-full border rounded px-3 py-2"
                   accept="image/*">
        </div>

        {{-- Gallery Images --}}
        <div class="mt-6">
            <label class="block font-medium mb-1">Gallery Images</label>
            <input type="file" name="images[]"
                   multiple
                   class="w-full border rounded px-3 py-2"
                   accept="image/*">
        </div>

        <div class="grid grid-cols-2 gap-6 mt-6">
            <div>
                <label class="block font-medium mb-1">Status</label>
                <select name="status"
                        class="w-full border rounded px-3 py-2">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>

            <div class="flex items-center mt-8">
                <input type="checkbox" name="is_featured" value="1"
                       class="mr-2"
                       {{ old('is_featured') ? 'checked' : '' }}>
                <label>Mark as featured</label>
            </div>
        </div>

        {{-- ================= LỊCH KHỞI HÀNH ================= --}}
        <div class="mt-10 border-t pt-6">
            <h3 class="text-xl font-semibold mb-4">Lịch khởi hành</h3>

            <div id="schedule-container">

                <div class="grid grid-cols-5 gap-4 mb-4">

                    <div>
                        <label class="block font-medium mb-1">Ngày</label>
                        <input type="date"
                               name="schedules[0][departure_date]"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Giờ</label>
                        <input type="time"
                               name="schedules[0][departure_time]"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Tổng chỗ</label>
                        <input type="number"
                               name="schedules[0][seats_total]"
                               value="30"
                               min="1"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Giá riêng</label>
                        <input type="text"
                               name="schedules[0][price_override]"
                               class="w-full border rounded px-3 py-2">
                    </div>

                    <div>
                        <label class="block font-medium mb-1">Trạng thái</label>
                        <select name="schedules[0][status]"
                                class="w-full border rounded px-3 py-2">
                            <option value="open">Open</option>
                            <option value="sold_out">Sold Out</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>

                </div>

            </div>

            <button type="button"
                    onclick="addSchedule()"
                    class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                + Thêm lịch khởi hành
            </button>
        </div>

        <div class="mt-8">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Lưu Tour
            </button>
        </div>

    </form>
</div>

<script>
let scheduleIndex = 1;

function addSchedule() {
    const container = document.getElementById('schedule-container');

    const html = `
    <div class="grid grid-cols-5 gap-4 mb-4">
        <div>
            <input type="date"
                   name="schedules[${scheduleIndex}][departure_date]"
                   class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <input type="time"
                   name="schedules[${scheduleIndex}][departure_time]"
                   class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <input type="number"
                   name="schedules[${scheduleIndex}][seats_total]"
                   value="30"
                   min="1"
                   class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <input type="text"
                   name="schedules[${scheduleIndex}][price_override]"
                   class="w-full border rounded px-3 py-2">
        </div>
        <div>
            <select name="schedules[${scheduleIndex}][status]"
                    class="w-full border rounded px-3 py-2">
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