@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

<h4>Edit Blog</h4>

<form method="POST"
action="{{ route('admin.blogs.update',$blog->id) }}"
enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="mb-3">

<label>Title</label>

<input type="text"
name="title"
value="{{ $blog->title }}"
class="form-control">

</div>

<div class="mb-3">

<label>Thumbnail</label>

@if($blog->thumbnail)

<img src="{{ asset('storage/'.$blog->thumbnail) }}"
width="200"
class="mb-2">

@endif

<input type="file"
name="thumbnail"
class="form-control">

</div>

<div class="mb-3">

<label>Excerpt</label>

<textarea
name="excerpt"
class="form-control">{{ $blog->excerpt }}</textarea>

</div>

<div class="mb-3">

<label>Content</label>

<textarea
name="content"
rows="8"
class="form-control">{{ $blog->content }}</textarea>

</div>

<div class="mb-3">

<label>Status</label>

<input type="checkbox"
name="status"
{{ $blog->status ? 'checked' : '' }}>

Active

</div>

<button class="btn btn-success">
Update Blog
</button>

</form>

</div>

@endsection