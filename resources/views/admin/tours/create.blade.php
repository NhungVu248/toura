@extends('admin.layouts.master')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold mb-6">Tạo Tour mới</h2>

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

        {{-- Thumbnail chính --}}
        <div class="mt-6">
            <label class="block font-medium mb-1">Thumbnail (Ảnh đại diện)</label>
            <input type="file" name="thumbnail"
                   class="w-full border rounded px-3 py-2"
                   accept="image/*">
        </div>

        {{-- Multiple Images --}}
        <div class="mt-6">
            <label class="block font-medium mb-1">Gallery Images (Có thể chọn nhiều ảnh)</label>
            <input type="file" name="images[]"
                   multiple
                   class="w-full border rounded px-3 py-2"
                   accept="image/*">

            <p class="text-sm text-gray-500 mt-1">
                Ảnh đầu tiên sẽ được đặt làm ảnh chính trong gallery.
            </p>

            @error('images.*')
                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
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

        <div class="mt-8">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Lưu Tour
            </button>
        </div>

    </form>
</div>
@endsection