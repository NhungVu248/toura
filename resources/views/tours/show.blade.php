<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="grid grid-cols-3 gap-6">
            
            <div class="col-span-2">

                {{-- MULTIPLE IMAGES --}}
                @if(isset($tour->images) && $tour->images->count())
                    
                    {{-- Ảnh chính --}}
                    <div class="mb-4">
                        <img id="mainImage"
                             src="{{ asset('storage/' . ($tour->images->first()->path)) }}" 
                             alt="{{ $tour->title }}"
                             class="w-full h-96 object-cover rounded-lg shadow-sm">
                    </div>

                    {{-- Thumbnail gallery --}}
                    <div class="grid grid-cols-5 gap-2 mb-6">
                        @foreach($tour->images as $img)
                            <button type="button"
                                    class="focus:outline-none"
                                    onclick="changeImage('{{ asset('storage/' . $img->path) }}', {{ $loop->index }})"
                                    aria-label="Xem ảnh {{ $loop->iteration }}">
                                <img src="{{ asset('storage/' . $img->path) }}"
                                     alt="Thumbnail {{ $loop->iteration }} - {{ $tour->title }}"
                                     class="h-20 object-cover border rounded cursor-pointer w-full">
                            </button>
                        @endforeach
                    </div>

                @elseif ($tour->thumbnail)

                    {{-- Fallback thumbnail cũ --}}
                    <img src="{{ asset('storage/' . $tour->thumbnail) }}" 
                         alt="{{ $tour->title }}"
                         class="w-full h-96 object-cover mb-4 rounded-lg shadow-sm">

                @else
                    {{-- No image --}}
                    <div class="w-full h-96 bg-gray-100 flex items-center justify-center mb-4 rounded-lg">
                        <span class="text-gray-400">No image available</span>
                    </div>
                @endif

                {{-- TITLE & META --}}
                <h1 class="text-3xl font-bold mb-2">
                    {{ $tour->title }}
                </h1>

                <p class="text-gray-600 mb-4">
                    {{ $tour->destination }} — {{ $tour->duration }} ngày
                </p>

                {{-- DESCRIPTION --}}
                <div class="mb-6 leading-relaxed text-gray-800">
                    {!! nl2br(e($tour->description)) !!}
                </div>

                {{-- ================= RATING SUMMARY ================= --}}
                <div class="flex items-center gap-3 mt-6 mb-4">
                    <div class="flex items-center gap-2">
                        {{-- Star display using rounded average --}}
                        <div class="flex">
                            @php $rounded = round($tour->rating_avg ?? 0); @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $rounded)
                                    <span class="text-yellow-500 text-xl leading-none">★</span>
                                @else
                                    <span class="text-gray-300 text-xl leading-none">★</span>
                                @endif
                            @endfor
                        </div>
                        <div class="text-yellow-500 font-bold text-xl">
                            {{ number_format($tour->rating_avg ?? 0, 1) }}
                        </div>
                    </div>

                    <div class="text-gray-500">
                        ({{ $tour->rating_count ?? 0 }} đánh giá)
                    </div>
                </div>

                {{-- ================= FORM REVIEW ================= --}}
                @auth
                <div class="border p-4 rounded mb-6 bg-white">
                    <h3 class="font-semibold mb-3">Viết đánh giá</h3>

                    @if(session('success'))
                        <div class="text-green-600 mb-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="text-red-600 mb-2">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('tours.reviews.store', $tour->id) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="block mb-1 font-medium">Đánh giá</label>
                            <select name="rating"
                                    class="border rounded w-full px-3 py-2"
                                    required>
                                <option value="">-- Chọn số sao --</option>
                                <option value="5">5 - Tuyệt vời</option>
                                <option value="4">4 - Tốt</option>
                                <option value="3">3 - Trung bình</option>
                                <option value="2">2 - Kém</option>
                                <option value="1">1 - Rất kém</option>
                            </select>
                            @error('rating')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="block mb-1 font-medium">Nhận xét</label>
                            <textarea name="comment"
                                    rows="3"
                                    class="border rounded w-full px-3 py-2"
                                    placeholder="Chia sẻ trải nghiệm của bạn...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Gửi đánh giá
                        </button>
                    </form>
                </div>
                @endauth

                @guest
                <div class="border p-4 rounded mb-6 text-gray-600">
                    Bạn cần <a href="{{ route('login') }}" class="text-blue-600 underline">đăng nhập</a> để viết đánh giá.
                </div>
                @endguest


                {{-- ================= LIST REVIEWS (OPTIMIZED) ================= --}}
                <div class="mt-6">
                    <h3 class="text-xl font-semibold mb-4">
                        Đánh giá từ khách hàng
                    </h3>

                    @if($reviews->count() > 0)

                        @foreach($reviews as $review)
                            <div class="border-b py-4">

                                <div class="flex items-center justify-between">

                                    <div class="flex items-center gap-3">

                                        {{-- Avatar --}}
                                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center text-sm font-bold">
                                            {{ strtoupper(substr(optional($review->user)->name ?? 'K', 0, 1)) }}
                                        </div>

                                        <div>
                                            <div class="font-semibold">
                                                {{ optional($review->user)->name ?? 'Khách' }}
                                            </div>

                                            <div class="text-gray-500 text-sm">
                                                {{ $review->created_at->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Rating Stars --}}
                                    <div class="text-yellow-500">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <span class="text-yellow-500">★</span>
                                            @else
                                                <span class="text-gray-300">★</span>
                                            @endif
                                        @endfor
                                    </div>

                                </div>

                                @if($review->comment)
                                    <div class="mt-3 text-gray-700">
                                        {{ $review->comment }}
                                    </div>
                                @endif

                            </div>
                        @endforeach

                        {{-- Pagination --}}
                        <div class="mt-6">
                            {{ $reviews->links() }}
                        </div>

                    @else
                        <div class="text-gray-500 italic">
                            Chưa có đánh giá nào cho tour này.
                        </div>
                    @endif
                </div>

                {{-- RELATED TOURS --}}
                <h3 class="text-xl font-semibold mt-6">Gợi ý cho bạn</h3>

                <div class="grid grid-cols-4 gap-4 mt-3">
                    @foreach ($related as $r)
                        <a href="{{ route('tours.show', $r->slug) }}" 
                           class="block border p-2 hover:shadow rounded">
                           
                            @if ($r->thumbnail)
                                <img src="{{ asset('storage/' . $r->thumbnail) }}" 
                                     alt="{{ $r->title }}"
                                     class="w-full h-28 object-cover rounded">
                            @else
                                {{-- nếu bạn sử dụng tour images model, có thể thay bằng primary image --}}
                                @if(optional($r->images)->first())
                                    <img src="{{ asset('storage/' . $r->images->first()->path) }}" 
                                         alt="{{ $r->title }}"
                                         class="w-full h-28 object-cover rounded">
                                @endif
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

            {{-- RIGHT SIDEBAR --}}
            <div class="col-span-1">
                <div class="border p-4 rounded shadow-sm bg-white">

                    <p class="font-bold text-lg mb-4">
                        {{ number_format($tour->price_adult, 0, ',', '.') }} VND / adult
                    </p>

                    @if($tour->upcomingSchedules->count())

                        <form action="{{ route('booking.store') }}" method="POST">
                            @csrf

                            {{-- Chọn ngày khởi hành --}}
                            <label class="block mb-1 font-medium">Ngày khởi hành</label>

                            <select name="schedule_id"
                                    class="w-full mb-3 border rounded px-2 py-2"
                                    required>
                                <option value="">-- Chọn ngày đi --</option>

                                @foreach($tour->upcomingSchedules as $schedule)
                                    <option value="{{ $schedule->id }}">
                                        {{ $schedule->departure_date->format('d/m/Y') }}
                                        (Còn {{ $schedule->seats_available }} chỗ)
                                    </option>
                                @endforeach
                            </select>

                            {{-- Số lượng --}}
                            <label class="block mb-1 font-medium">Số lượng</label>
                            <input type="number"
                                name="quantity"
                                min="1"
                                value="1"
                                class="w-full mb-3 border rounded px-2 py-2"
                                required>

                            <button type="submit"
                                    class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                                Đặt ngay
                            </button>
                        </form>

                    @else

                        <div class="text-red-500 font-semibold">
                            Hiện chưa có lịch khởi hành khả dụng
                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>

    {{-- JS: Change main image when click thumbnail --}}
    <script>
        function changeImage(src, index = 0) {
            const main = document.getElementById('mainImage');
            if (!main) return;
            main.src = src;
        }
    </script>
</x-app-layout>