@props(['tour'])
<div class="bg-white shadow-sm rounded overflow-hidden hover:shadow-lg transition">
    <a href="{{ route('tours.show', $tour->slug) }}" class="block">
        {{-- Image --}}
        <div class="relative">
            @if($tour->thumbnail)
                <img src="{{ asset('storage/'.$tour->thumbnail) }}" alt="{{ $tour->title }}" class="w-full h-44 object-cover">
            @else
                <div class="w-full h-44 bg-gray-200 flex items-center justify-center text-gray-500">No image</div>
            @endif
            {{-- optional badge --}}
            @if($tour->is_featured)
                <div class="absolute top-3 left-3 bg-yellow-400 text-sm font-semibold px-2 py-1 rounded">Nổi bật</div>
            @endif
        </div>

        {{-- Content --}}
        <div class="p-4">
            <h3 class="text-lg font-semibold leading-tight text-gray-800 mb-1">{{ $tour->title }}</h3>
            <div class="text-sm text-gray-500 mb-2">{{ $tour->destination }} • {{ $tour->duration }} ngày</div>

            {{-- Price --}}
            <div class="flex items-center justify-between mt-4">
                <div>
                    @if($tour->price_original && $tour->price_original > $tour->price_adult)
                        <div class="text-sm text-gray-400 line-through">{{ number_format($tour->price_original,0,',','.') }} đ</div>
                    @endif
                    <div class="text-lg font-bold text-indigo-600">{{ number_format($tour->price_adult,0,',','.') }} đ</div>
                </div>

                <div>
                    <a href="{{ route('tours.show', $tour->slug) }}" class="inline-block bg-green-600 text-white px-3 py-2 rounded">Đặt tour</a>
                </div>
            </div>
        </div>
    </a>
</div>