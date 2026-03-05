<x-app-layout>

<div class="max-w-6xl mx-auto p-6">

<h2 class="text-2xl font-bold mb-6">
My Bookings
</h2>

<table class="w-full border rounded-lg overflow-hidden">

<thead class="bg-gray-100">
<tr>
<th class="p-3 text-left">Tour</th>
<th class="p-3">Ngày đi</th>
<th class="p-3">Khách</th>
<th class="p-3">Tổng tiền</th>
<th class="p-3">Status</th>
<th class="p-3">Action</th>
</tr>
</thead>

<tbody>

@foreach($bookings as $booking)

<tr class="border-t">

<td class="p-3">
{{ $booking->tour->title }}
</td>

<td class="p-3 text-center">
{{ \Carbon\Carbon::parse($booking->departure_date)->format('d/m/Y') }}
</td>

<td class="p-3 text-center">
{{ $booking->guest_quantity }}
</td>

<td class="p-3 text-center text-red-600 font-semibold">
{{ number_format($booking->total_price,0,',','.') }}đ
</td>

<td class="p-3 text-center">
{{ ucfirst($booking->booking_status) }}
</td>

<td class="p-3 text-center">

<a href="{{ route('booking.show',$booking->id) }}"
class="text-blue-600 hover:underline">
View
</a>

</td>

</tr>

@endforeach

</tbody>

</table>

<div class="mt-6">
{{ $bookings->links() }}
</div>

</div>

</x-app-layout>