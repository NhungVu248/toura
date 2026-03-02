<x-app-layout>
    <div class="relative">
        {{-- HERO GALLERY --}}
<div class="container mx-auto px-6 mt-6">
    @php
        $gallery = $tour->images;
    @endphp

    @if($gallery && $gallery->count())
        <div class="grid grid-cols-4 grid-rows-2 gap-2 h-[420px] rounded-2xl overflow-hidden">

            {{-- ẢNH LỚN --}}
            <div class="col-span-2 row-span-2 relative cursor-pointer"
                 onclick="openGallery(0)">
                <img src="{{ asset('storage/' . $gallery[0]->path) }}"
                     class="w-full h-full object-cover">
            </div>

            {{-- ẢNH NHỎ --}}
            @foreach($gallery->slice(1,4) as $index => $img)
                <div class="relative cursor-pointer"
                     onclick="openGallery({{ $index+1 }})">
                    <img src="{{ asset('storage/' . $img->path) }}"
                         class="w-full h-full object-cover">
                </div>
            @endforeach

            {{-- ẢNH CUỐI + OVERLAY --}}
            @if($gallery->count() > 5)
                <div class="relative cursor-pointer"
                     onclick="openGallery(0)">
                    <img src="{{ asset('storage/' . $gallery[5]->path) }}"
                         class="w-full h-full object-cover">

                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center text-white font-semibold text-lg">
                        + Xem tất cả hình ảnh
                    </div>
                </div>
            @endif

        </div>
    @endif
</div>

        <div class="container mx-auto p-6 -mt-14">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden p-6">
                {{-- TITLE ROW --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold">{{ $tour->title }}</h1>
                        <div class="flex items-center gap-3 text-gray-600 mt-2">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 1118 0z"/></svg>
                                <span>{{ $tour->destination }}</span>
                            </div>

                            <div class="flex items-center gap-2 text-yellow-500">
                                @php $rounded = round($tour->rating_avg ?? 0); @endphp
                                <span class="font-semibold ml-1">{{ number_format($tour->rating_avg ?? 0, 1) }}</span>
                                <span class="text-gray-400">({{ $tour->rating_count ?? 0 }} đánh giá)</span>
                            </div>
                        </div>
                    </div>

                    {{-- QUICK INFO BUBBLES --}}
                    @php
                    // Duration (đã là string trong DB)
                    $durationText = $tour->duration ?? '—';

                    // Schedule
                    $firstSchedule = $tour->upcomingSchedules->first();
                    $seats_info = $firstSchedule
                        ? ($firstSchedule->seats_available . ' / ' . $firstSchedule->seats_total . ' chỗ')
                        : '—';

                    /*
                    |--------------------------------------------------------------------------
                    | Highlights
                    |--------------------------------------------------------------------------
                    */
                    $highlights = [];
                    if (!empty($tour->highlights)) {
                        $decoded = json_decode($tour->highlights, true);
                        if (is_array($decoded)) {
                            $highlights = $decoded;
                        } else {
                            $highlights = explode("\n", $tour->highlights);
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Included Services
                    |--------------------------------------------------------------------------
                    */
                    $included = [];
                    if (!empty($tour->included_services)) {
                        $decoded = json_decode($tour->included_services, true);
                        if (is_array($decoded)) {
                            $included = $decoded;
                        } else {
                            $included = explode("\n", $tour->included_services);
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Itinerary
                    |--------------------------------------------------------------------------
                    */
                    $itinerary = [];
                    if (!empty($tour->itinerary)) {
                        $decoded = json_decode($tour->itinerary, true);
                        if (is_array($decoded)) {
                            $itinerary = $decoded;
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Booking Conditions
                    |--------------------------------------------------------------------------
                    */
                    $bookingConditions = [];
                    if (!empty($tour->booking_conditions)) {
                        $decoded = json_decode($tour->booking_conditions, true);
                        if (is_array($decoded)) {
                            $bookingConditions = $decoded;
                        } else {
                            $bookingConditions = explode("\n", $tour->booking_conditions);
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Cancellation Policy
                    |--------------------------------------------------------------------------
                    */
                    $policy = $tour->cancellation_policy ?? null;
                @endphp

                    <div class="flex gap-4 items-center">
                        <div class="bg-gradient-to-r from-pink-50 to-yellow-50 px-4 py-3 rounded-lg flex items-center gap-3">
                            <div class="p-2 bg-white rounded-full">
                                <svg class="w-5 h-5 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/></svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Thời gian</div>
                                <div class="font-semibold">{{ $durationText }}</div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-pink-50 to-yellow-50 px-4 py-3 rounded-lg flex items-center gap-3">
                            <div class="p-2 bg-white rounded-full">
                                <svg class="w-5 h-5 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="7" r="4"/><path d="M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/></svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Số chỗ còn</div>
                                <div class="font-semibold">{{ $seats_info }}</div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-pink-50 to-yellow-50 px-4 py-3 rounded-lg flex items-center gap-3">
                            <div class="p-2 bg-white rounded-full">
                                <svg class="w-5 h-5 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Khởi hành</div>
                                <div class="font-semibold">{{ $firstSchedule ? $firstSchedule->departure_date->format('d/m/Y') : 'Chưa có' }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABS --}}
                <div class="mt-6">
                    <div class="flex gap-3 bg-gray-100 rounded-full p-1">
                        <button class="tab-btn px-6 py-2 rounded-full text-sm bg-white" data-tab="overview">Tổng quan</button>
                        <button class="tab-btn px-6 py-2 rounded-full text-sm" data-tab="itinerary">Lịch trình</button>
                        <button class="tab-btn px-6 py-2 rounded-full text-sm" data-tab="reviews">Đánh giá</button>
                        <button class="tab-btn px-6 py-2 rounded-full text-sm" data-tab="policy">Chính sách</button>
                    </div>
                </div>

                {{-- CONTENT PANELS --}}
                <div class="mt-6 space-y-6">
                    {{-- OVERVIEW --}}
                    <div class="tab-panel" id="overview">
                        <h3 class="text-xl font-semibold mb-3">Mô tả chi tiết</h3>
                        <div class="text-gray-700 leading-relaxed mb-4">
                            {!! nl2br(e($tour->description)) !!}
                        </div>

                        <h4 class="text-lg font-semibold mb-3">Điểm nổi bật</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                            @foreach($highlights as $h)
                                <div class="p-3 rounded-lg bg-green-50 flex items-center gap-3">
                                    <svg class="w-4 h-4 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5"/></svg>
                                    <span class="text-gray-700">{{ $h }}</span>
                                </div>
                            @endforeach
                        </div>

                        <h4 class="text-lg font-semibold mb-3">Dịch vụ bao gồm</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
                            @foreach($included as $inc)
                                <div class="flex items-start gap-3">
                                    <svg class="w-5 h-5 text-green-500 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5"/></svg>
                                    <div>{{ $inc }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ITINERARY --}}
                    <div class="tab-panel hidden" id="itinerary">
                        <h3 class="text-xl font-semibold mb-4">Lịch trình chi tiết</h3>

                        <div class="space-y-6">
                            @foreach($itinerary as $day)
                            <div class="flex gap-6">
                                <div class="w-2 bg-pink-500 rounded-l"></div>
                                <div class="flex-1">
                                    <div class="inline-block bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-3 py-1 rounded-full text-sm mb-2">
                                        {{ $day['day'] ?? '' }}
                                    </div>
                                    <h4 class="text-lg font-semibold mb-2">
                                        {{ $day['title'] ?? '' }}
                                    </h4>

                                    @if(!empty($day['activities']))
                                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                                            @foreach($day['activities'] as $act)
                                                <li>{{ $act }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>

                    {{-- REVIEWS --}}
                    <div class="tab-panel hidden" id="reviews">
                        <h3 class="text-xl font-semibold mb-4">Đánh giá từ khách hàng</h3>

                        {{-- FORM REVIEW: thêm vào tab reviews --}}
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

                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Gửi đánh giá</button>
                                </form>
                            </div>
                        @endauth

                        @guest
                            <div class="border p-4 rounded mb-6 text-gray-600">
                                Bạn cần <a href="{{ route('login') }}" class="text-blue-600 underline">đăng nhập</a> để viết đánh giá.
                            </div>
                        @endguest

                        {{-- Rating summary + list --}}
                        <div class="bg-gray-50 p-6 rounded-lg mb-6">
                            <div class="flex items-center gap-6">
                                <div class="text-4xl font-bold text-pink-500">{{ number_format($tour->rating_avg ?? 0, 1) }}</div>
                                <div class="flex-1">
                                    <div class="flex gap-4 items-center">
                                        @for($i=5;$i>=1;$i--)
                                            <div class="w-1/5">
                                                <div class="text-sm">{{ $i }} sao</div>
                                                <div class="h-2 bg-gray-200 rounded mt-1 overflow-hidden">
                                                    @php
                                                    $totalReviews = max($tour->rating_count, 1);
                                                    $starCount = $tour->approvedReviews()
                                                                    ->where('rating', $i)
                                                                    ->count();
                                                    $percent = ($starCount / $totalReviews) * 100;
                                                    @endphp

                                                <div class="h-full bg-yellow-400" 
                                                    style="width: {{ $percent }}%">
                                                </div>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach($reviews as $review)
                            <div class="border rounded-lg p-4 mb-4 bg-white">
                                <div class="flex justify-between items-start gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-pink-500 to-yellow-500 text-white flex items-center justify-center">
                                            {{ strtoupper(substr(optional($review->user)->name ?? 'K',0,1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold">{{ optional($review->user)->name ?? 'Khách' }}</div>
                                            <div class="text-xs text-gray-400">{{ $review->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="text-yellow-500">
                                        @for($i=1;$i<=5;$i++)
                                            <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                                        @endfor
                                    </div>
                                </div>

                                @if($review->comment)
                                    <div class="mt-3 text-gray-700">{{ $review->comment }}</div>
                                @endif
                            </div>
                        @endforeach

                        <div class="mt-4">
                            {{ $reviews->links() }}
                        </div>
                    </div>

                    {{-- POLICY --}}
                    <div class="tab-panel hidden" id="policy">
                        <div class="p-4 border rounded-lg bg-yellow-50">
                            <h4 class="font-semibold mb-2">Chính sách hủy tour</h4>

                            @if($policy)
                                {{-- nếu policy là text dài --}}
                                {!! nl2br(e($policy)) !!}
                            @else
                                <ul class="list-disc list-inside text-gray-700">
                                    <li><strong>Hủy trước 7 ngày:</strong> Hoàn lại 80% tổng giá trị tour</li>
                                    <li><strong>Hủy trước 3-7 ngày:</strong> Hoàn lại 50% tổng giá trị tour</li>
                                    <li><strong>Hủy trong vòng 3 ngày:</strong> Không hoàn lại</li>
                                </ul>
                            @endif

                            <p class="text-xs text-gray-500 mt-2">* Ngày được tính từ ngày khởi hành tour, không tính ngày nghỉ lễ, Tết</p>
                        </div>

                        <div class="mt-4">
                            <h4 class="font-semibold mb-2">Điều kiện đặt tour</h4>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-gray-700">
                                @foreach($bookingConditions as $cond)
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-green-500 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5"/></svg>
                                        {{ $cond }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="mt-6">
                            <h4 class="font-semibold mb-3">Phương thức thanh toán</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div class="p-4 border rounded">Chuyển khoản ngân hàng</div>
                                <div class="p-4 border rounded">Thanh toán thẻ</div>
                                <div class="p-4 border rounded">Ví điện tử</div>
                                <div class="p-4 border rounded">Tiền mặt</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RELATED --}}
                <div class="mt-6">
                    <h4 class="text-lg font-semibold mb-3">Tour tương tự</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($related as $r)
                            <a href="{{ route('tours.show', $r->slug) }}" class="block border rounded-lg overflow-hidden hover:shadow">
                                @if($r->thumbnail)
                                    <img src="{{ asset('storage/' . $r->thumbnail) }}" class="w-full h-36 object-cover">
                                @elseif(optional($r->images)->first())
                                    <img src="{{ asset('storage/' . $r->images->first()->path) }}" class="w-full h-36 object-cover">
                                @endif
                                <div class="p-3">
                                    <div class="font-medium">{{ $r->title }}</div>
                                    <div class="text-sm text-gray-500 mt-1">★ {{ number_format($r->rating_avg ?? 0,1) }}</div>
                                    <div class="text-pink-500 mt-2 font-semibold">{{ number_format($r->price_adult,0,',','.') }} đ</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- STICKY BOOKING BAR --}}
        <div class="fixed bottom-4 left-0 right-0 flex justify-center pointer-events-none">
            <div class="max-w-6xl w-full px-6 pointer-events-auto">
                <div class="bg-white rounded-2xl shadow-lg flex items-center justify-between p-4">
                    <div>
                        <div class="text-pink-500 font-bold text-2xl">
                            {{ number_format($tour->price_adult, 0, ',', '.') }} đ
                        </div>
                        <div class="text-xs text-gray-500">Giá / khách</div>
                    </div>

                    <div class="flex items-center gap-3">
                        <button class="px-4 py-2 border rounded-md bg-white text-gray-700">Lưu tour</button>
                        <button class="px-4 py-2 border rounded-md bg-white text-gray-700">Chia sẻ</button>

                        @if($tour->upcomingSchedules->count())
                            <a href="#" class="px-5 py-2 rounded-md bg-gradient-to-r from-pink-500 to-yellow-500 text-white">Đặt tour ngay</a>
                        @else
                            <button disabled class="px-5 py-2 rounded-md bg-gray-300 text-white cursor-not-allowed">Đặt tour (sắp ra mắt)</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Small JS: tabs + gallery --}}
    <script>
    (function(){
        // Tabs
        const btns = document.querySelectorAll('.tab-btn');
        const panels = document.querySelectorAll('.tab-panel');
        function activate(tab) {
            btns.forEach(b => { b.classList.remove('bg-white'); b.classList.remove('shadow'); });
            panels.forEach(p => p.classList.add('hidden'));
            document.querySelector('.tab-btn[data-tab="'+tab+'"]').classList.add('bg-white','shadow');
            document.getElementById(tab).classList.remove('hidden');
        }
        btns.forEach(b => {
            b.addEventListener('click', () => { activate(b.dataset.tab); });
        });
        if(btns.length) activate('overview');
    })();

    // ===== GALLERY =====
    let images = [
        @foreach($tour->images as $img)
            "{{ asset('storage/' . $img->path) }}",
        @endforeach
    ];

    let currentIndex = 0;

    function openGallery(index) {
        currentIndex = index;
        document.getElementById('galleryImage').src = images[index];
        document.getElementById('galleryModal').classList.remove('hidden');
        document.getElementById('galleryModal').classList.add('flex');
    }

    function closeGallery() {
        document.getElementById('galleryModal').classList.add('hidden');
    }

    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        document.getElementById('galleryImage').src = images[currentIndex];
    }

    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        document.getElementById('galleryImage').src = images[currentIndex];
    }
</script>
</x-app-layout>