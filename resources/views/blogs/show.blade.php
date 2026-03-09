<x-app-layout>

<div class="max-w-4xl mx-auto px-6 py-16">

<h1 class="text-4xl font-bold mb-6">
{{ $blog->title }}
</h1>

<img src="{{ asset('storage/'.$blog->thumbnail) }}"
class="rounded-xl mb-8">

<div class="prose max-w-none whitespace-pre-line">
    {!! $blog->content !!}
</div>

</div>

</x-app-layout>