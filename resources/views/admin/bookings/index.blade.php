@extends('admin.layouts.master')

@section('content')
<div class="p-6">

<h2 class="text-2xl font-semibold mb-6 text-gray-800">
Quản lý Booking
</h2>

{{-- FILTER --}}
<form method="GET" class="mb-6 flex gap-4 items-end">

<div>
<label class="block text-sm mb-1 text-gray-700">Booking Status</label>
<select name="status" class="border rounded px-3 py-2 text-gray-800">
<option value="">Tất cả</option>
<option value="pending" {{ request('status')=='pending'?'selected':'' }}>
Pending
</option>
<option value="confirmed" {{ request('status')=='confirmed'?'selected':'' }}>
Confirmed
</option>
<option value="cancelled" {{ request('status')=='cancelled'?'selected':'' }}>
Cancelled
</option>
</select>
</div>

<div>
<label class="block text-sm mb-1 text-gray-700">Payment Status</label>
<select name="payment" class="border rounded px-3 py-2 text-gray-800">
<option value="">Tất cả</option>
<option value="pending" {{ request('payment')=='pending'?'selected':'' }}>
Pending
</option>
<option value="paid" {{ request('payment')=='paid'?'selected':'' }}>
Paid
</option>
<option value="cancelled" {{ request('payment')=='cancelled'?'selected':'' }}>
Cancelled
</option>
</select>
</div>

<button
class="bg-blue-500 hover:bg-blue-600 text-gray-900 px-4 py-2 rounded shadow text-sm font-medium">

🔍 Lọc

</button>

<a href="{{ route('admin.bookings.index') }}"
class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-900 rounded shadow text-sm font-medium">

↻ Reset

</a>

</form>

{{-- SUCCESS MESSAGE --}}
@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-4">
{{ session('success') }}
</div>
@endif

{{-- TABLE --}}
<div class="bg-white shadow rounded overflow-x-auto">

<table class="min-w-full text-sm text-gray-800">

<thead class="bg-gray-100 text-gray-900">

<tr>
<th class="px-4 py-3 text-left">#</th>
<th class="px-4 py-3 text-left">Tour</th>
<th class="px-4 py-3 text-left">Khách</th>
<th class="px-4 py-3 text-left">Tổng tiền</th>
<th class="px-4 py-3 text-left">Booking</th>
<th class="px-4 py-3 text-left">Payment</th>
<th class="px-4 py-3 text-left">Hành động</th>
</tr>

</thead>

<tbody>

@forelse($bookings as $b)

<tr class="border-t hover:bg-gray-50">

<td class="px-4 py-3 font-medium">
#{{ $b->id }}
</td>

<td class="px-4 py-3">
{{ $b->tour->title ?? '-' }}
</td>

<td class="px-4 py-3">
{{ $b->full_name }}
</td>

<td class="px-4 py-3 font-semibold text-pink-600">
{{ number_format($b->total_price,0,',','.') }} đ
</td>

{{-- BOOKING STATUS --}}
<td class="px-4 py-3">

<span class="px-2 py-1 text-xs font-semibold rounded
{{ $b->booking_status=='confirmed' ? 'bg-green-100 text-green-700' :
($b->booking_status=='cancelled' ? 'bg-red-100 text-red-700' :
'bg-yellow-100 text-yellow-700') }}">

{{ ucfirst($b->booking_status) }}

</span>

</td>

{{-- PAYMENT STATUS --}}
<td class="px-4 py-3">

<span class="px-2 py-1 text-xs font-semibold rounded
{{ $b->payment_status=='paid' ? 'bg-green-100 text-green-700' :
($b->payment_status=='cancelled' ? 'bg-red-100 text-red-700' :
'bg-yellow-100 text-yellow-700') }}">

{{ ucfirst($b->payment_status) }}

</span>

@if($b->payment)

<div class="text-xs text-gray-600 mt-1">

@php
$method = $b->payment->payment_method;
@endphp

@if($method=='card')
💳 CARD
@elseif($method=='bank_transfer')
🏦 BANK
@elseif($method=='ewallet')
📱 EWALLET
@elseif($method=='cash')
💵 CASH
@endif

</div>

@if($b->payment->transaction_code)

<div class="text-xs text-gray-500">
TXN: {{ $b->payment->transaction_code }}
</div>

@endif

@else

<div class="text-xs text-gray-400 mt-1">
No payment
</div>

@endif

</td>

<td class="px-4 py-3 space-x-2">

<a href="{{ route('admin.bookings.show',$b->id) }}"
class="px-3 py-1 bg-indigo-200 hover:bg-indigo-300 text-gray-900 rounded text-xs font-medium shadow">

Xem

</a>

@if($b->payment && $b->payment->payment_status=='pending')

<form method="POST"
action="{{ route('admin.payments.confirm',$b->payment->id) }}"
class="inline">

@csrf

<button
onclick="return confirm('Xác nhận thanh toán?')"
class="px-3 py-1 bg-green-200 hover:bg-green-300 text-gray-900 rounded text-xs font-medium shadow">

Xác nhận thanh toán

</button>

</form>

@endif

</td>

</tr>

@empty

<tr>

<td colspan="7" class="px-4 py-6 text-center text-gray-500">

Chưa có booking nào.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

{{-- PAGINATION --}}
<div class="mt-6">

{{ $bookings->withQueryString()->links() }}

</div>

</div>
@endsection