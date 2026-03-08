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

<div class="container mx-auto px-4 py-8">

    {{-- TITLE --}}
    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Điểm đến nổi bật</h2>

        <p class="text-sm text-gray-500">
            Kết quả cho:
            <strong>
                {{ request('destination') ?? 'Tất cả' }}
            </strong>
        </p>
    </div>


    {{-- FILTER BAR --}}
    <div class="bg-white border rounded-xl shadow-sm p-6 mb-6">

        <form method="GET" action="{{ route('destination.index') }}">

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                {{-- KEYWORD --}}
                <div>
                    <label class="text-sm text-gray-500">Từ khóa</label>

                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Tìm kiếm tour..."
                        class="w-full border rounded-lg px-3 py-2"
                    >
                </div>


                {{-- DESTINATION --}}
                <div>
                    <label class="text-sm text-gray-500">Điểm đến</label>

                    <select
                        name="destination"
                        class="w-full border rounded-lg px-3 py-2"
                    >

                        <option value="">Tất cả</option>

                        @foreach($destinations as $d)

                            <option
                                value="{{ $d }}"
                                {{ request('destination') == $d ? 'selected' : '' }}
                            >
                                {{ $d }}
                            </option>

                        @endforeach

                    </select>
                </div>


                {{-- DOMAIN --}}
                <div>
                    <label class="text-sm text-gray-500">Loại tour</label>

                    <select
                        name="domain"
                        class="w-full border rounded-lg px-3 py-2"
                    >

                        <option value="">Tất cả</option>

                        @foreach($domains as $dom)

                            <option
                                value="{{ $dom }}"
                                {{ request('domain') == $dom ? 'selected' : '' }}
                            >
                                {{ ucfirst($dom) }}
                            </option>

                        @endforeach

                    </select>
                </div>


                {{-- PRICE RANGE --}}
                <div>
                    <label class="text-sm text-gray-500">Giá</label>

                    <div class="flex gap-2">

                        <input
                            type="number"
                            name="min_price"
                            value="{{ request('min_price') }}"
                            placeholder="Từ"
                            class="w-1/2 border rounded-lg px-3 py-2"
                        >

                        <input
                            type="number"
                            name="max_price"
                            value="{{ request('max_price') }}"
                            placeholder="Đến"
                            class="w-1/2 border rounded-lg px-3 py-2"
                        >

                    </div>

                </div>


                {{-- SORT --}}
                <div>
                    <label class="text-sm text-gray-500">Sắp xếp</label>

                    <select
                        name="sort"
                        class="w-full border rounded-lg px-3 py-2"
                    >

                        <option value="">Mặc định</option>

                        <option
                            value="price_asc"
                            {{ request('sort')=='price_asc' ? 'selected' : '' }}
                        >
                            Giá thấp nhất
                        </option>

                        <option
                            value="price_desc"
                            {{ request('sort')=='price_desc' ? 'selected' : '' }}
                        >
                            Giá cao nhất
                        </option>

                        <option
                            value="featured"
                            {{ request('sort')=='featured' ? 'selected' : '' }}
                        >
                            Nổi bật
                        </option>

                    </select>

                </div>

            </div>


            {{-- ACTION --}}
            <div class="flex justify-between items-center mt-4">

                <button
                    type="submit"
                    class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2 rounded-lg"
                >
                    Tìm kiếm
                </button>

                <a
                    href="{{ route('destination.index') }}"
                    class="text-sm text-gray-500 hover:text-gray-700"
                >
                    Xóa bộ lọc
                </a>

            </div>

        </form>

    </div>



    {{-- RESULT COUNT --}}
    <div class="flex justify-between items-center mb-6">

        <div class="text-sm text-gray-600">

            Hiển thị
            {{ $tours->firstItem() ?? 0 }}
            -
            {{ $tours->lastItem() ?? 0 }}
            /
            {{ $tours->total() }} tour

        </div>

    </div>



    {{-- TOUR GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach($tours as $tour)

            @include('destination.partials.card', [
                'tour' => $tour
            ])

        @endforeach

    </div>



    {{-- PAGINATION --}}
    <div class="mt-8">

        {{ $tours->links() }}

    </div>


</div>

</x-app-layout>