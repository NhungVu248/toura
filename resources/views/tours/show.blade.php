<x-app-layout>
    <div class="relative">
        {{-- HERO IMAGE --}}
        <div class="w-full h-96 relative overflow-hidden">
            @if(isset($tour->images) && $tour->images->count())
                <img id="heroImage" src="{{ asset('storage/' . $tour->images->first()->path) }}"
                     alt="{{ $tour->title }}"
                     class="w-full h-full object-cover">
            @elseif($tour->thumbnail)
                <img id="heroImage" src="{{ asset('storage/' . $tour->thumbnail) }}" alt="{{ $tour->title }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gray-200"></div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
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
                    <div class="flex gap-4 items-center">
                        <div class="bg-gradient-to-r from-pink-50 to-yellow-50 px-4 py-3 rounded-lg flex items-center gap-3">
                            <div class="p-2 bg-white rounded-full">
                                <svg class="w-5 h-5 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/></svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Thời gian</div>
                                <div class="font-semibold">{{ $tour->duration }} ngày</div>
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-pink-50 to-yellow-50 px-4 py-3 rounded-lg flex items-center gap-3">
                            <div class="p-2 bg-white rounded-full">
                                <svg class="w-5 h-5 text-pink-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="7" r="4"/><path d="M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/></svg>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Số chỗ còn</div>
                                @php
                                    $firstSchedule = $tour->upcomingSchedules->first();
                                    $seats_info = $firstSchedule ? ($firstSchedule->seats_available . ' / ' . $firstSchedule->seats_total . ' chỗ') : '—';
                                @endphp
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
                            @php
                                $highlights = [
                                    'Cầu Vàng Bà Nà Hills',
                                    'Phố cổ Hội An về đêm',
                                    'Ngũ Hành Sơn',
                                    'Bãi biển Mỹ Khê',
                                    'Ẩm thực cao lầu, mì Quảng',
                                    'Khách sạn 4 sao'
                                ];
                            @endphp
                            @foreach($highlights as $h)
                                <div class="p-3 rounded-lg bg-green-50 flex items-center gap-3">
                                    <svg class="w-4 h-4 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5"/></svg>
                                    <span class="text-gray-700">{{ $h }}</span>
                                </div>
                            @endforeach
                        </div>

                        <h4 class="text-lg font-semibold mb-3">Dịch vụ bao gồm</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-6">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5"/></svg>
                                <div>Xe đưa đón theo chương trình</div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5"/></svg>
                                <div>Khách sạn tiêu chuẩn</div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5"/></svg>
                                <div>Bữa ăn theo chương trình</div>
                            </div>
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-500 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5"/></svg>
                                <div>Vé tham quan các điểm</div>
                            </div>
                        </div>
                    </div>

                    {{-- ITINERARY --}}
                    <div class="tab-panel hidden" id="itinerary">
                        <h3 class="text-xl font-semibold mb-4">Lịch trình chi tiết</h3>
                        @php
                            $itinerary = [
                                ['day'=>'Ngày 1','title'=>'Khởi hành và check-in','activities'=>[
                                    '06:00 - Xe và hướng dẫn viên đón quý khách tại điểm hẹn',
                                    '09:00 - Dừng chân nghỉ ngơi, dùng điểm tâm sáng',
                                    '12:00 - Đến nơi, làm thủ tục nhận phòng khách sạn',
                                    '14:00 - Tham quan điểm du lịch đầu tiên',
                                    '18:00 - Dùng bữa tối, tự do khám phá khu vực',
                                ]],
                                ['day'=>'Ngày 2','title'=>'Khám phá các điểm nổi bật','activities'=>[
                                    '07:00 - Ăn sáng buffet tại khách sạn',
                                    '08:30 - Khởi hành tham quan các điểm chính',
                                    '12:00 - Dùng bữa trưa với đặc sản địa phương',
                                    '14:00 - Tiếp tục hành trình khám phá',
                                    '19:00 - Bữa tối và nghỉ ngơi tại khách sạn',
                                ]],
                                ['day'=>'Ngày cuối','title'=>'Tự do và trở về','activities'=>[
                                    '07:00 - Ăn sáng và làm thủ tục trả phòng',
                                    '08:00 - Thời gian tự do mua sắm quà lưu niệm',
                                    '10:00 - Khởi hành về điểm đón ban đầu',
                                    '14:00 - Nghỉ chân, dùng bữa trưa',
                                    '18:00 - Về đến điểm đón, kết thúc chuyến đi',
                                ]],
                            ];
                        @endphp

                        <div class="space-y-6">
                            @foreach($itinerary as $day)
                                <div class="flex gap-6">
                                    <div class="w-2 bg-pink-500 rounded-l"></div>
                                    <div class="flex-1">
                                        <div class="inline-block bg-gradient-to-r from-pink-500 to-yellow-500 text-white px-3 py-1 rounded-full text-sm mb-2">{{ $day['day'] }}</div>
                                        <h4 class="text-lg font-semibold mb-2">{{ $day['title'] }}</h4>
                                        <ul class="list-disc list-inside text-gray-700 space-y-1">
                                            @foreach($day['activities'] as $act)
                                                <li>{{ $act }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- REVIEWS --}}
                    <div class="tab-panel hidden" id="reviews">
                        <h3 class="text-xl font-semibold mb-4">Đánh giá từ khách hàng</h3>

                        <div class="bg-gray-50 p-6 rounded-lg mb-6">
                            <div class="flex items-center gap-6">
                                <div class="text-4xl font-bold text-pink-500">{{ number_format($tour->rating_avg ?? 0, 1) }}</div>
                                <div class="flex-1">
                                    <div class="flex gap-4 items-center">
                                        @for($i=5;$i>=1;$i--)
                                            <div class="w-1/5">
                                                <div class="text-sm">{{ $i }} sao</div>
                                                <div class="h-2 bg-gray-200 rounded mt-1 overflow-hidden">
                                                    <div class="h-full bg-yellow-400" style="width: {{ $i==5? '70%':($i==4?'20%':'10%') }}"></div>
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
                            <ul class="list-disc list-inside text-gray-700">
                                <li><strong>Hủy trước 7 ngày:</strong> Hoàn lại 80% tổng giá trị tour</li>
                                <li><strong>Hủy trước 3-7 ngày:</strong> Hoàn lại 50% tổng giá trị tour</li>
                                <li><strong>Hủy trong vòng 3 ngày:</strong> Không hoàn lại</li>
                            </ul>
                            <p class="text-xs text-gray-500 mt-2">* Ngày được tính từ ngày khởi hành tour, không tính ngày nghỉ lễ, Tết</p>
                        </div>

                        <div class="mt-4">
                            <h4 class="font-semibold mb-2">Điều kiện đặt tour</h4>
                            <ul class="grid grid-cols-1 md:grid-cols-2 gap-2 text-gray-700">
                                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5"/></svg>Thanh toán trước 30% để giữ chỗ</li>
                                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5"/></svg>Trẻ em theo chính sách</li>
                                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5"/></svg>CMND/CCCD hoặc Hộ chiếu</li>
                                <li class="flex items-start gap-2"><svg class="w-4 h-4 text-green-500 mt-1" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M20 6L9 17l-5-5"/></svg>Công ty có quyền hủy khi không đủ group</li>
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
                b.addEventListener('click', (e) => { activate(b.dataset.tab); });
            });
            // default
            if(btns.length) activate('overview');

            // gallery thumbnails (if exist)
            const thumbs = document.querySelectorAll('[onclick^="changeImage"]');
            if(thumbs.length){
                document.querySelectorAll('[onclick^="changeImage"]').forEach(btn=>{
                    btn.addEventListener('click', function(e){
                        // onclick already inlined when thumbnails generated; but keep fallback
                    });
                });
            }
        })();
        function changeImage(src){
            const hero = document.getElementById('heroImage');
            const main = document.getElementById('mainImage');
            if(hero) hero.src = src;
            if(main) main.src = src;
        }
    </script>
</x-app-layout>