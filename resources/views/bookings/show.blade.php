<x-app-layout>

<div class="container mx-auto p-6 max-w-3xl">

    <h2 class="text-2xl font-semibold mb-6">
        Booking #{{ $booking->id }}
    </h2>

    <div class="bg-white shadow rounded-2xl p-6 space-y-4">

        <div>
            <strong>Tour:</strong>
            <span class="text-gray-700">
                {{ $booking->tour->title }}
            </span>
        </div>

        <div>
            <strong>Người đặt:</strong>
            {{ $booking->full_name }}
            <span class="text-gray-500">
                ({{ $booking->email }})
            </span>
        </div>

        <div>
            <strong>Số lượng khách:</strong>
            {{ $booking->guest_quantity }}
        </div>

        <div>
            <strong>Ngày khởi hành:</strong>
            {{ $booking->departure_date->format('d/m/Y') }}
        </div>

        <div>
            <strong>Dịch vụ:</strong>

            @php
                $services = [];
                if($booking->travel_insurance) $services[] = 'Bảo hiểm';
                if($booking->private_guide) $services[] = 'Hướng dẫn viên riêng';
                if($booking->airport_pickup) $services[] = 'Đưa đón sân bay';
            @endphp

            {{ count($services) ? implode(' | ', $services) : 'Không có' }}
        </div>

        <div>
            <strong>Tổng tiền:</strong>
            <span class="text-pink-600 font-bold text-lg">
                {{ number_format($booking->total_price,0,',','.') }} đ
            </span>
        </div>

        <div>
            <strong>Booking status:</strong>

            <span class="px-3 py-1 rounded-full text-white text-sm
                {{ $booking->booking_status == 'confirmed' ? 'bg-green-500' :
                   ($booking->booking_status == 'cancelled' ? 'bg-red-500' : 'bg-yellow-500') }}">
                {{ ucfirst($booking->booking_status) }}
            </span>
        </div>

        <div>
            <strong>Payment:</strong>

            <span class="px-3 py-1 rounded-full text-white text-sm
                {{ $booking->payment_status == 'paid' ? 'bg-green-600' :
                   ($booking->payment_status == 'cancelled' ? 'bg-red-600' : 'bg-gray-500') }}">
                {{ ucfirst($booking->payment_status) }}
            </span>
        </div>

    </div>

</div>

</x-app-layout>