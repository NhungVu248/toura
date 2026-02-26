<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Tất cả tour</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($tours as $tour)
                <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                    <a href="{{ route('tours.show', $tour->slug) }}">
                        @if ($tour->thumbnail)
                            <img 
                                src="{{ asset('storage/' . $tour->thumbnail) }}" 
                                alt="{{ $tour->title }}"
                                class="w-full h-48 object-cover"
                            >
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                No Image
                            </div>
                        @endif

                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-1">
                                {{ $tour->title }}
                            </h3>

                            <p class="text-sm text-gray-600">
                                {{ $tour->destination }} — {{ $tour->duration }} ngày
                            </p>

                            <p class="mt-2 text-primary font-bold text-lg">
                                {{ number_format($tour->price_adult, 0, ',', '.') }} VND
                            </p>
                        </div>
                    </a>
                </div>
            @empty
                <p>Chưa có tour nào.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $tours->links() }}
        </div>
    </div>
</x-app-layout>