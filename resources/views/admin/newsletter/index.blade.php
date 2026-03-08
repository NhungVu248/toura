@extends('admin.layouts.master')

@section('content')

<div class="container-fluid">

<h4 class="mb-4">Newsletter Subscribers</h4>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">
<div class="card-body">

<table class="table table-bordered">

<thead>
<tr>
<th>ID</th>
<th>Email</th>
<th>Name</th>
<th>Subscribed</th>
<th>Action</th>
</tr>
</thead>

<tbody>

@foreach($subscribers as $sub)

<tr>

<td>{{ $sub->id }}</td>

<td>{{ $sub->email }}</td>

<td>{{ $sub->name ?? '-' }}</td>

<td>{{ $sub->created_at->format('d/m/Y') }}</td>

<td>

<form action="{{ route('admin.newsletter.delete',$sub->id) }}"
      method="POST">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm">
Delete
</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

{{ $subscribers->links() }}

</div>
</div>

</div>

@endsection
