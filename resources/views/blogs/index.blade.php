<x-app-layout>

<div class="max-w-7xl mx-auto px-6 py-16">

<h1 class="text-3xl font-bold mb-10">
Cẩm nang du lịch
</h1>

<div class="grid md:grid-cols-3 gap-8">

@foreach($blogs as $blog)

<div class="bg-white rounded-xl shadow-lg overflow-hidden">

<img src="{{ asset('storage/'.$blog->thumbnail) }}"
class="h-48 w-full object-cover">

<div class="p-5">

<h3 class="font-semibold text-lg mb-2">
{{ $blog->title }}
</h3>

<p class="text-gray-500 text-sm mb-3 line-clamp-3">
{{ $blog->excerpt }}
</p>

<a href="{{ route('blogs.show',$blog->slug) }}"
class="text-pink-500 font-semibold">
Đọc thêm →
</a>

</div>

</div>

@endforeach

</div>

<div class="mt-10">
{{ $blogs->links() }}
</div>

</div>

</x-app-layout>