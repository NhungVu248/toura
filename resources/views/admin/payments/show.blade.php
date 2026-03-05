@extends('layouts.app')

@section('content')

<div class="container mx-auto p-6">

<h2 class="text-xl font-bold mb-4">
Payment #{{ $payment->id }}
</h2>

<div class="border p-4 rounded mb-4">

<p>
<strong>Booking:</strong>
#{{ $payment->booking_id }}
</p>

<p>
<strong>Payment Method:</strong>
{{ $payment->payment_method }}
</p>

<p>
<strong>Provider:</strong>
{{ $payment->payment_provider }}
</p>

<p>
<strong>Amount:</strong>
{{ number_format($payment->final_amount,0,',','.') }}
</p>

<p>
<strong>Status:</strong>
{{ $payment->payment_status }}
</p>

</div>

@if($payment->payment_status!='paid')

<form method="POST"
action="{{ route('admin.payments.confirm',$payment->id) }}">

@csrf

<button
class="bg-green-600 text-white px-4 py-2 rounded">

Xác nhận thanh toán

</button>

</form>

<form method="POST"
action="{{ route('admin.payments.fail',$payment->id) }}">

@csrf

<button
class="bg-red-600 text-white px-4 py-2 rounded mt-2">

Đánh dấu thất bại

</button>

</form>

@endif

</div>

@endsection