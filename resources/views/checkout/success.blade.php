<x-app-layout>

<div class="max-w-4xl mx-auto py-10 px-6">

{{-- SUCCESS HEADER --}}
<div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center mb-6">

<h2 class="text-3xl font-bold text-green-600 mb-2">
✔ Thanh toán thành công
</h2>

<p class="text-gray-600">
Cảm ơn bạn đã đặt tour. Thông tin booking của bạn đã được xác nhận.
</p>

</div>


{{-- BOOKING CARD --}}
<div class="bg-white shadow rounded-lg p-6 mb-6">

<h3 class="text-xl font-semibold mb-4">
Thông tin booking
</h3>

<div class="grid grid-cols-2 gap-4 text-sm">

<div>
<strong>Mã booking:</strong><br>
#{{ $payment->booking->id }}
</div>

<div>
<strong>Mã giao dịch:</strong><br>
{{ $payment->transaction_code }}
</div>

<div>
<strong>Phương thức thanh toán:</strong><br>
{{ ucfirst($payment->payment_method) }}
</div>

<div>
<strong>Trạng thái thanh toán:</strong><br>
<span class="text-green-600 font-semibold">
{{ ucfirst($payment->payment_status) }}
</span>
</div>

</div>

</div>


{{-- TOUR SUMMARY --}}
<div class="bg-white shadow rounded-lg p-6 mb-6">

<h3 class="text-xl font-semibold mb-4">
Thông tin tour
</h3>

<div class="flex gap-4">

<img
src="{{ asset('storage/'.$payment->booking->tour->thumbnail) }}"
class="w-40 h-28 object-cover rounded"
>

<div>

<p class="font-semibold text-lg">
{{ $payment->booking->tour->title }}
</p>

<p class="text-gray-600 text-sm">
📍 {{ $payment->booking->tour->destination }}
</p>

<p class="text-gray-600 text-sm">
📅 Khởi hành:
{{ \Carbon\Carbon::parse($payment->booking->departure_date)->format('d/m/Y') }}
</p>

<p class="text-gray-600 text-sm">
👥 Số khách:
{{ $payment->booking->guest_quantity }}
</p>

</div>

</div>

</div>


{{-- PAYMENT SUMMARY --}}
<div class="bg-white shadow rounded-lg p-6">

<h3 class="text-xl font-semibold mb-4">
Tổng thanh toán
</h3>

<div class="flex justify-between mb-2">

<span>Tổng tiền</span>

<span class="font-semibold text-lg text-red-600">
{{ number_format($payment->final_amount,0,',','.') }} VNĐ
</span>

</div>

</div>


{{-- ACTION BUTTONS --}}
<div class="flex gap-4 mt-6">

<a
href="{{ route('tours.index') }}"
class="flex-1 border rounded-lg py-3 text-center hover:bg-gray-100"
>
Tiếp tục khám phá tour
</a>

<a
href="{{ route('booking.show',$payment->booking_id) }}"
class="flex-1 py-3 rounded-lg text-white text-center bg-gradient-to-r from-pink-500 to-yellow-400"
>
Xem chi tiết booking
</a>

</div>


</div>

</x-app-layout>