@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">

<h2 class="text-xl font-bold mb-4">
Quản lý thanh toán
</h2>

<table class="w-full border">

<thead class="bg-gray-100">

<tr>

<th>ID</th>
<th>Booking</th>
<th>Method</th>
<th>Số tiền</th>
<th>Status</th>
<th>Created</th>
<th>Action</th>

</tr>

</thead>

<tbody>

@foreach($payments as $p)

<tr class="border-t">

<td>{{ $p->id }}</td>

<td>#{{ $p->booking_id }}</td>

<td>
{{ $p->payment_method }}
@if($p->payment_provider)
({{ $p->payment_provider }})
@endif
</td>

<td>
{{ number_format($p->final_amount,0,',','.') }}
</td>

<td>
{{ $p->payment_status }}
</td>

<td>
{{ $p->created_at->format('d/m/Y') }}
</td>

<td>

<a href="{{ route('admin.payments.show',$p->id) }}"
class="text-blue-600">

Xem

</a>

</td>

</tr>

@endforeach

</tbody>

</table>

<div class="mt-4">
{{ $payments->links() }}
</div>

</div>

@endsection