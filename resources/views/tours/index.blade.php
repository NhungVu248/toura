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
        </section>

{{-- SEARCH FILTER --}}
<div class="max-w-7xl mx-auto px-6 -mt-12 mb-10">

<div class="bg-white shadow-lg rounded-xl p-6 border">

<h3 class="text-lg font-semibold mb-1">
Bộ lọc tìm kiếm
</h3>

<p class="text-sm text-gray-500 mb-4">
Kết quả cho: <strong>{{ request('destination') ?? 'Tất cả' }}</strong>
</p>

<form method="GET" action="{{ route('tours.index') }}">

<div class="grid md:grid-cols-6 gap-4">

{{-- KEYWORD --}}
<div>
<label class="text-sm text-gray-500">Từ khóa</label>

<input type="text"
name="q"
value="{{ request('q') }}"
placeholder="Tìm kiếm tour..."
class="w-full border rounded-lg px-3 py-2">
</div>

{{-- DESTINATION --}}
<div>
<label class="text-sm text-gray-500">Điểm đến</label>

<select name="destination"
class="w-full border rounded-lg px-3 py-2">

<option value="">Tất cả</option>

@foreach($destinations ?? [] as $d)

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

@foreach($domains ?? [] as $dom)

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
class="w-1/2 border rounded-lg px-2 py-2">

<input type="number"
name="max_price"
value="{{ request('max_price') }}"
placeholder="Đến"
class="w-1/2 border rounded-lg px-2 py-2">

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

{{-- BUTTON --}}
<div class="flex items-end gap-3">

<button
type="submit"
class="bg-pink-500 hover:bg-pink-600 text-white px-5 py-2 rounded-lg">

Tìm kiếm

</button>

<a href="{{ route('tours.index') }}"
class="text-sm text-gray-500 hover:text-gray-700">

Xóa bộ lọc

</a>

</div>

</div>

</form>

</div>

</div>

{{-- TOUR LIST --}}
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
                    ⏳ {{ $tour->duration }}
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
{{-- TRAVEL BLOG --}}
<section class="py-16 bg-white">

<div class="max-w-7xl mx-auto px-6">

<h2 class="text-3xl font-bold text-center mb-10 text-pink-600">
Cẩm nang du lịch
</h2>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">

@foreach($blogs as $blog)

<div class="bg-white rounded-xl shadow-lg overflow-hidden">

<img src="{{ asset('storage/'.$blog->thumbnail) }}"
class="h-44 w-full object-cover">

<div class="p-5">

<h3 class="font-semibold text-lg mb-2">
{{ $blog->title }}
</h3>

<p class="text-sm text-gray-500 line-clamp-2 mb-3">
{{ $blog->excerpt }}
</p>

<a href="{{ route('blogs.show',$blog->slug) }}"
class="text-pink-500 font-medium">
Đọc thêm →
</a>

</div>

</div>

@endforeach

</div>

</div>
</section>
{{-- TOP TOURS --}}
<section class="py-16 bg-gray-50">

<div class="max-w-7xl mx-auto px-6">

<h2 class="text-3xl font-bold text-center mb-10 text-pink-600">
Tour được đặt nhiều nhất
</h2>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

@foreach($topTours as $tour)

<a href="{{ route('tours.show',$tour->slug) }}"
class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition group">

<div class="relative h-48 overflow-hidden">

<img src="{{ asset('storage/'.$tour->thumbnail) }}"
class="w-full h-full object-cover group-hover:scale-110 transition">

<div class="absolute top-3 left-3 bg-yellow-500 text-white text-xs px-2 py-1 rounded">
🔥 Popular
</div>

</div>

<div class="p-4">

<div class="text-sm text-gray-500 mb-1">
📍 {{ $tour->destination }}
</div>

<h3 class="font-semibold text-lg mb-2 line-clamp-2">
{{ $tour->title }}
</h3>

<div class="flex justify-between items-center">

<span class="text-pink-600 font-bold">
{{ number_format($tour->price_adult) }} đ
</span>

<span class="text-xs text-gray-400">
{{ $tour->bookings_count }} bookings
</span>

</div>

</div>

</a>

@endforeach

</div>

</div>

</section>
{{-- NEWSLETTER SECTION --}}
<section class="bg-gradient-to-r from-pink-50 to-yellow-50 py-16">

    <div class="max-w-5xl mx-auto text-center px-6">

        <h2 class="text-3xl font-bold text-pink-600 mb-4">
            Nhận khuyến mãi tour
        </h2>

        <p class="text-gray-600 mb-8">
            Đăng ký email để nhận ưu đãi, mã giảm giá và thông tin tour mới nhất từ Toura
        </p>

        @if(session('success'))
            <div class="text-green-600 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('newsletter.subscribe') }}"
              method="POST"
              class="flex flex-col md:flex-row justify-center gap-3 max-w-xl mx-auto">

            @csrf

            <input
                type="email"
                name="email"
                placeholder="Nhập email của bạn"
                required
                class="flex-1 px-4 py-3 rounded-lg border focus:outline-none focus:ring-2 focus:ring-pink-300"
            >

            <button
                type="submit"
                class="px-6 py-3 bg-pink-500 text-white rounded-lg font-semibold hover:bg-pink-600 transition">
                Đăng ký
            </button>

        </form>

    </div>

</section>
</x-app-layout>