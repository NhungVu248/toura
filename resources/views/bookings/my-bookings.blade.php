<x-app-layout>

<div class="max-w-6xl mx-auto px-6 py-10">

{{-- HEADER --}}
<div class="mb-8">

<h1 class="text-3xl font-bold text-pink-500">
Lịch sử đặt tour
</h1>

<p class="text-gray-500 text-sm">
Quản lý các tour đã đặt của bạn
</p>

</div>


{{-- BOOKING LIST --}}
<div class="space-y-6">

@foreach($bookings as $booking)

<div class="bg-white rounded-xl shadow p-6">

<div class="flex gap-6">

{{-- IMAGE --}}
<div class="w-60 h-36 rounded-lg overflow-hidden">

@if($booking->tour->thumbnail)

<img
src="{{ asset('storage/'.$booking->tour->thumbnail) }}"
class="w-full h-full object-cover">

@endif

</div>


{{-- INFO --}}
<div class="flex-1">

<div class="flex justify-between items-start">

<div>

<h2 class="text-lg font-semibold">
{{ $booking->tour->title }}
</h2>

<div class="text-sm text-gray-500 mt-1">
📍 {{ $booking->tour->destination }}
</div>

</div>

<span class="px-3 py-1 text-sm rounded-full text-white
{{ $booking->booking_status == 'confirmed' ? 'bg-green-500' :
($booking->booking_status == 'cancelled' ? 'bg-red-500' : 'bg-yellow-500') }}">

{{ ucfirst($booking->booking_status) }}

</span>

</div>


{{-- META INFO --}}
<div class="grid grid-cols-4 gap-6 text-sm mt-4">

<div>
<div class="text-gray-400">Mã booking</div>
<div class="font-medium">
BK{{ $booking->id }}
</div>
</div>

<div>
<div class="text-gray-400">Ngày khởi hành</div>
<div class="font-medium">
{{ \Carbon\Carbon::parse($booking->departure_date)->format('d/m/Y') }}
</div>
</div>

<div>
<div class="text-gray-400">Số khách</div>
<div class="font-medium">
{{ $booking->adult_quantity }} người
</div>
</div>

<div>
<div class="text-gray-400">Tổng tiền</div>
<div class="font-bold text-pink-500">
{{ number_format($booking->total_price) }} đ
</div>
</div>

</div>


{{-- ACTIONS --}}
<div class="flex gap-3 mt-4">

<a href="{{ route('booking.show',$booking->id) }}"
class="px-4 py-2 border rounded text-sm hover:bg-gray-100">

Xem chi tiết

</a>

</div>


</div>

</div>

</div>

@endforeach

</div>


{{-- PAGINATION --}}
<div class="mt-10">
{{ $bookings->links() }}
</div>

</div>

</x-app-layout>