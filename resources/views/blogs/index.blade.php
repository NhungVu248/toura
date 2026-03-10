<x-app-layout>
  <div class="max-w-7xl mx-auto px-6 py-16">

    <div class="flex items-center justify-between mb-8">
      <h1 class="text-3xl font-bold">Cẩm nang du lịch</h1>

      <form method="GET" action="{{ route('blogs.index') }}" class="w-full md:w-1/3 ml-4">
        <div class="relative">
          <input type="search" name="q" value="{{ request('q') }}" placeholder="Tìm kiếm bài viết..." class="w-full border rounded-lg px-4 py-2">
        </div>
      </form>
    </div>

    <div class="grid md:grid-cols-3 gap-8">
      @forelse($blogs as $blog)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
          <img src="{{ asset('storage/'.$blog->thumbnail) }}" class="h-48 w-full object-cover" alt="{{ $blog->title }}">
          <div class="p-5">
            <h3 class="font-semibold text-lg mb-2">{{ $blog->title }}</h3>
            <p class="text-gray-500 text-sm mb-3 line-clamp-3">{{ $blog->excerpt }}</p>
            <a href="{{ route('blogs.show', $blog->slug) }}" class="text-pink-500 font-semibold">Đọc thêm →</a>
          </div>
        </div>
      @empty
        <div class="col-span-3 text-center text-gray-500">Không tìm thấy bài viết.</div>
      @endforelse
    </div>

    <div class="mt-10">
      {{ $blogs->links() }}
    </div>

  </div>
</x-app-layout>