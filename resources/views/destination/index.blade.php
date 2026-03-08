<x-app-layout>

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

                    <select name="destination"
                            class="w-full border rounded-lg px-3 py-2">

                        <option value="">Tất cả</option>

                        @foreach($destinations as $d)
                            <option value="{{ $d }}"
                                {{ request('destination') == $d ? 'selected' : '' }}>
                                {{ $d }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- DOMAIN --}}
                <div>
                    <label class="text-sm text-gray-500">Loại tour</label>

                    <select name="domain"
                            class="w-full border rounded-lg px-3 py-2">

                        <option value="">Tất cả</option>

                        @foreach($domains as $dom)
                            <option value="{{ $dom }}"
                                {{ request('domain') == $dom ? 'selected' : '' }}>
                                {{ ucfirst($dom) }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- PRICE --}}
                <div>
                    <label class="text-sm text-gray-500">Giá</label>

                    <div class="flex gap-2">

                        <input type="number"
                               name="min_price"
                               value="{{ request('min_price') }}"
                               placeholder="Từ"
                               class="w-1/2 border rounded-lg px-3 py-2">

                        <input type="number"
                               name="max_price"
                               value="{{ request('max_price') }}"
                               placeholder="Đến"
                               class="w-1/2 border rounded-lg px-3 py-2">

                    </div>
                </div>

                {{-- SORT --}}
                <div>
                    <label class="text-sm text-gray-500">Sắp xếp</label>

                    <select name="sort"
                            class="w-full border rounded-lg px-3 py-2">

                        <option value="">Mặc định</option>

                        <option value="price_asc"
                            {{ request('sort')=='price_asc' ? 'selected' : '' }}>
                            Giá thấp nhất
                        </option>

                        <option value="price_desc"
                            {{ request('sort')=='price_desc' ? 'selected' : '' }}>
                            Giá cao nhất
                        </option>

                        <option value="featured"
                            {{ request('sort')=='featured' ? 'selected' : '' }}>
                            Nổi bật
                        </option>

                    </select>
                </div>

            </div>

            <div class="flex justify-between items-center mt-4">

                <button type="submit"
                        class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2 rounded-lg">
                    Tìm kiếm
                </button>

                <a href="{{ route('destination.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700">
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



    {{-- REVIEW SECTION --}}
    <section class="mt-20 bg-gray-50 p-10 rounded-xl">

        <h2 class="text-2xl font-semibold mb-8 text-center">
            Khách hàng nói gì về chúng tôi
        </h2>


        {{-- RATING AVG --}}
        <div class="text-center mb-10">

            <div class="text-4xl font-bold text-yellow-500">
                ⭐ {{ number_format($ratingAvg,1) }}/5
            </div>

            <p class="text-gray-500 mt-2">
                từ {{ $reviewCount }} khách hàng
            </p>

        </div>


        <div class="grid md:grid-cols-3 gap-6">

            @foreach($reviews as $review)

            <div class="bg-white p-6 rounded-lg shadow-sm">

                {{-- COMMENT --}}
                <p class="text-gray-600 mb-4 italic">
                    "{{ $review->comment }}"
                </p>


                <div class="flex items-center justify-between">

                    {{-- STARS --}}
                    <div class="text-yellow-500">

                        @for($i=1;$i<=5;$i++)

                            @if($i <= $review->rating)
                                ⭐
                            @else
                                ☆
                            @endif

                        @endfor

                    </div>


                    {{-- USER --}}
                    <div class="text-sm text-gray-500">

                        {{ $review->user->name ?? 'Khách hàng' }}

                    </div>

                </div>

            </div>

            @endforeach

        </div>

    </section>

</div>

</x-app-layout>