<x-app-layout>

<div class="container mx-auto px-6 py-10 max-w-4xl">

    {{-- HEADER --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            Chi tiết đặt tour
        </h1>

        <p class="text-gray-500">
            Booking #{{ $booking->id }}
        </p>
    </div>


    {{-- TOUR INFO --}}
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">

        <h2 class="text-lg font-semibold mb-4">
            Thông tin tour
        </h2>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <div class="text-sm text-gray-500">Tour</div>
                <div class="font-semibold text-gray-800">
                    {{ $booking->tour->title }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Ngày khởi hành</div>
                <div class="font-semibold">
                    {{ $booking->departure_date->format('d/m/Y') }}
                </div>
            </div>

        </div>

    </div>


    {{-- CUSTOMER INFO --}}
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">

        <h2 class="text-lg font-semibold mb-4">
            Thông tin khách hàng
        </h2>

        <div class="grid md:grid-cols-2 gap-4">

            <div>
                <div class="text-sm text-gray-500">Họ tên</div>
                <div class="font-semibold">
                    {{ $booking->full_name }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Email</div>
                <div>
                    {{ $booking->email }}
                </div>
            </div>

            <div>
                <div class="text-sm text-gray-500">Số điện thoại</div>
                <div>
                    {{ $booking->phone }}
                </div>
            </div>

        </div>

    </div>


    {{-- PASSENGER INFO --}}
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">

        <h2 class="text-lg font-semibold mb-4">
            Thông tin hành khách
        </h2>

        <div class="space-y-2">

            <div class="flex justify-between">
                <span>Người lớn</span>
                <span class="font-medium">
                    {{ $booking->adult_quantity }}
                </span>
            </div>

            <div class="flex justify-between">
                <span>Trẻ em</span>
                <span class="font-medium">
                    {{ $booking->child_quantity }}
                </span>
            </div>

            <div class="flex justify-between border-t pt-2">
                <span>Tổng khách</span>
                <span class="font-semibold">
                    {{ $booking->guest_quantity }}
                </span>
            </div>

        </div>

    </div>


    {{-- SERVICES --}}
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">

        <h2 class="text-lg font-semibold mb-4">
            Dịch vụ bổ sung
        </h2>

        @php
            $services = [];

            if($booking->travel_insurance)
                $services[] = "Bảo hiểm du lịch";

            if($booking->private_guide)
                $services[] = "Hướng dẫn viên riêng";

            if($booking->airport_pickup)
                $services[] = "Đưa đón sân bay";
        @endphp

        @if(count($services))

            <ul class="list-disc list-inside text-gray-700 space-y-1">
                @foreach($services as $service)
                    <li>{{ $service }}</li>
                @endforeach
            </ul>

        @else

            <div class="text-gray-500">
                Không có dịch vụ bổ sung
            </div>

        @endif

    </div>


    {{-- PAYMENT SUMMARY --}}
    <div class="bg-white shadow-lg rounded-xl p-6 mb-6">

        <h2 class="text-lg font-semibold mb-4">
            Chi tiết thanh toán
        </h2>

        <div class="space-y-2">

            <div class="flex justify-between">
                <span>Giá tour</span>
                <span>{{ number_format($booking->tour_price,0,',','.') }} đ</span>
            </div>

            <div class="flex justify-between">
                <span>Tạm tính</span>
                <span>{{ number_format($booking->subtotal,0,',','.') }} đ</span>
            </div>

            <div class="flex justify-between">
                <span>Dịch vụ</span>
                <span>{{ number_format($booking->service_total,0,',','.') }} đ</span>
            </div>

            @if($booking->discount_amount > 0)
            <div class="flex justify-between text-green-600">
                <span>Giảm giá</span>
                <span>-{{ number_format($booking->discount_amount,0,',','.') }} đ</span>
            </div>
            @endif

            <div class="flex justify-between border-t pt-3 font-bold text-lg text-pink-600">
                <span>Tổng thanh toán</span>
                <span>{{ number_format($booking->total_price,0,',','.') }} đ</span>
            </div>

        </div>

    </div>


    {{-- STATUS --}}
    <div class="bg-white shadow-lg rounded-xl p-6">

        <h2 class="text-lg font-semibold mb-4">
            Trạng thái
        </h2>

        <div class="flex gap-4">

            <div>
                <div class="text-sm text-gray-500 mb-1">
                    Booking
                </div>

                <span class="px-3 py-1 rounded-full text-white text-sm
                    {{ $booking->booking_status == 'confirmed' ? 'bg-green-500' :
                       ($booking->booking_status == 'cancelled' ? 'bg-red-500' : 'bg-yellow-500') }}">
                    {{ ucfirst($booking->booking_status) }}
                </span>
            </div>


            <div>
                <div class="text-sm text-gray-500 mb-1">
                    Payment
                </div>

                <span class="px-3 py-1 rounded-full text-white text-sm
                    {{ $booking->payment_status == 'paid' ? 'bg-green-600' :
                       ($booking->payment_status == 'cancelled' ? 'bg-red-600' : 'bg-gray-500') }}">
                    {{ ucfirst($booking->payment_status) }}
                </span>
            </div>

        </div>

    </div>

</div>

</x-app-layout>