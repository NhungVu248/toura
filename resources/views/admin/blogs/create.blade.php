@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

<h4>Create Blog</h4>

<form method="POST"
action="{{ route('admin.blogs.store') }}"
enctype="multipart/form-data">

@csrf

<div class="mb-3">

<label>Title</label>

<input type="text"
name="title"
class="form-control">

</div>

<div class="mb-3">

<label>Thumbnail</label>

<input type="file"
name="thumbnail"
class="form-control">

</div>

<div class="mb-3">

<label>Excerpt</label>

<textarea
name="excerpt"
class="form-control"></textarea>

</div>

<div class="mb-3">

<label>Content</label>

<textarea
name="content"
rows="8"
class="form-control"></textarea>

</div>

<div class="mb-3">

<label>Status</label>

<input type="checkbox"
name="status"
checked>

Active

</div>

<button class="btn btn-success">
Save Blog
</button>

</form>

</div>

@endsection