@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

<h4 class="mb-4">Blog Management</h4>

<a href="{{ route('admin.blogs.create') }}" class="btn btn-primary mb-3">
Create Blog
</a>

<table class="table table-bordered">

<tr>
<th>ID</th>
<th>Title</th>
<th>Status</th>
<th>Actions</th>
</tr>

@foreach($blogs as $blog)

<tr>

<td>{{ $blog->id }}</td>

<td>{{ $blog->title }}</td>

<td>
@if($blog->status)
Active
@else
Hidden
@endif
</td>

<td>

<a href="{{ route('admin.blogs.edit',$blog->id) }}"
class="btn btn-warning btn-sm">
Edit
</a>

<form action="{{ route('admin.blogs.destroy',$blog->id) }}"
method="POST"
style="display:inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</table>

{{ $blogs->links() }}

</div>

@endsection