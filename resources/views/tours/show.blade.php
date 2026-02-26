<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="grid grid-cols-3 gap-6">
            
            <div class="col-span-2">
                @if ($tour->thumbnail)
                    <img src="{{ asset('storage/' . $tour->thumbnail) }}" 
                         class="w-full h-96 object-cover mb-4">
                @endif

                <h1 class="text-3xl font-bold mb-2">
                    {{ $tour->title }}
                </h1>

                <p class="text-gray-600 mb-4">
                    {{ $tour->destination }} — {{ $tour->duration }} ngày
                </p>

                <div class="mb-6">
                    {!! nl2br(e($tour->description)) !!}
                </div>

                <h3 class="text-xl font-semibold mt-6">Gợi ý cho bạn</h3>

                <div class="grid grid-cols-4 gap-4 mt-3">
                    @foreach ($related as $r)
                        <a href="{{ route('tours.show', $r->slug) }}" 
                           class="block border p-2 hover:shadow">
                           
                            @if ($r->thumbnail)
                                <img src="{{ asset('storage/' . $r->thumbnail) }}" 
                                     class="w-full h-28 object-cover">
                            @endif

                            <div class="mt-1 font-medium">
                                {{ $r->title }}
                            </div>

                            <div class="text-sm text-gray-600">
                                {{ number_format($r->price_adult, 0, ',', '.') }} VND
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-span-1">
                <div class="border p-4 rounded shadow-sm">
                    <p class="font-bold text-lg mb-4">
                        {{ number_format($tour->price_adult, 0, ',', '.') }} VND / adult
                    </p>

                    <form action="#" method="POST" class="mt-4">
                        @csrf

                        <label class="block mb-1">Ngày đi</label>
                        <input type="date" name="date" 
                               class="w-full mb-3 border rounded px-2 py-1">

                        <label class="block mb-1">Số lượng</label>
                        <input type="number" name="qty" min="1" value="1" 
                               class="w-full mb-3 border rounded px-2 py-1">

                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                            Đặt ngay
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>