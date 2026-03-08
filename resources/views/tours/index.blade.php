<x-app-layout>
            <section class="py-24 px-6 text-center bg-cover bg-center bg-no-repeat bg-black/50 bg-blend-overlay" 
                style="background-image: url('{{ asset('img/nen.png') }}');">
           <div class="max-w-4xl mx-auto">
        
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-6">
                Khám Phá Thế Giới Cùng Toura
            </h1>
        
            <p class="text-lg text-gray-100 mb-8 leading-relaxed">
                Tìm kiếm và đặt tour du lịch yêu thích của bạn
            </p>
        
            <a href="{{ route('tours.index') }}" class="inline-block px-8 py-4 bg-pink-500 text-white rounded-full font-bold text-lg shadow-lg hover:bg-pink-600 transition duration-300">
                Khám phá tour
            </a>
            </div>
        </section>
<div class="container mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold mb-8">Khám phá Tour</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($tours as $tour)

        <a href="{{ route('tours.show', $tour->slug) }}"
           class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group">

            {{-- IMAGE --}}
            <div class="relative h-56 overflow-hidden">
                @if ($tour->thumbnail)
                    <img src="{{ asset('storage/' . $tour->thumbnail) }}"
                         alt="{{ $tour->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        No Image
                    </div>
                @endif

                {{-- Featured badge --}}
                @if($tour->is_featured)
                    <div class="absolute top-4 left-4 bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-3 py-1 rounded-full text-xs">
                        Nổi bật
                    </div>
                @endif
            </div>

            {{-- CONTENT --}}
            <div class="p-5">

                {{-- Destination --}}
                <div class="text-sm text-gray-500 mb-1">
                    📍 {{ $tour->destination }}
                </div>

                {{-- Title --}}
                <h3 class="text-xl font-semibold mb-2 group-hover:text-pink-500 transition-colors line-clamp-2">
                    {{ $tour->title }}
                </h3>

                {{-- Duration --}}
                <div class="text-sm text-gray-600 mb-3">
                    ⏳ {{ $tour->duration }} ngày
                </div>

                {{-- Price --}}
                <div class="pt-4 border-t border-gray-200">
                    <p class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-yellow-500 bg-clip-text text-transparent">
                        {{ number_format($tour->price_adult, 0, ',', '.') }} đ
                    </p>
                </div>

            </div>
        </a>

        @empty
            <div class="col-span-3 text-center text-gray-500">
                Chưa có tour nào.
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $tours->links() }}
    </div>
</div>
</x-app-layout>