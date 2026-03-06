<x-app-layout>

<div class="max-w-6xl mx-auto px-6 py-10">

    {{-- HEADER --}}
    <div class="flex items-center justify-between mb-8">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                My Bookings
            </h1>

            <p class="text-gray-500 text-sm">
                Quản lý các tour bạn đã đặt
            </p>
        </div>

    </div>


    {{-- BOOKING LIST --}}
    <div class="space-y-6">

        @foreach($bookings as $booking)

        <div class="bg-white shadow-lg rounded-xl overflow-hidden">

            <div class="grid md:grid-cols-5 gap-6 p-6 items-center">

                {{-- TOUR --}}
                <div class="md:col-span-2">

                    <div class="font-semibold text-gray-800 text-lg">
                        {{ $booking->tour->title }}
                    </div>

                    <div class="text-sm text-gray-500 mt-1">
                        Booking #{{ $booking->id }}
                    </div>

                </div>


                {{-- DATE --}}
                <div class="text-center">

                    <div class="text-sm text-gray-500">
                        Ngày khởi hành
                    </div>

                    <div class="font-medium">
                        {{ \Carbon\Carbon::parse($booking->departure_date)->format('d/m/Y') }}
                    </div>

                </div>


                {{-- PASSENGERS --}}
                <div class="text-center">

                    <div class="text-sm text-gray-500">
                        Hành khách
                    </div>

                    <div class="font-medium">
                        {{ $booking->adult_quantity }} NL
                        •
                        {{ $booking->child_quantity }} TE
                    </div>

                </div>


                {{-- PRICE --}}
                <div class="text-center">

                    <div class="text-sm text-gray-500">
                        Tổng tiền
                    </div>

                    <div class="text-pink-600 font-bold text-lg">
                        {{ number_format($booking->total_price,0,',','.') }} đ
                    </div>

                </div>

            </div>


            {{-- FOOTER --}}
            <div class="border-t bg-gray-50 px-6 py-4 flex justify-between items-center">

                <div class="flex gap-4">

                    {{-- BOOKING STATUS --}}
                    <span class="px-3 py-1 rounded-full text-sm text-white
                        {{ $booking->booking_status == 'confirmed' ? 'bg-green-500' :
                           ($booking->booking_status == 'cancelled' ? 'bg-red-500' : 'bg-yellow-500') }}">
                        {{ ucfirst($booking->booking_status) }}
                    </span>


                    {{-- PAYMENT STATUS --}}
                    <span class="px-3 py-1 rounded-full text-sm text-white
                        {{ $booking->payment_status == 'paid' ? 'bg-green-600' :
                           ($booking->payment_status == 'cancelled' ? 'bg-red-600' : 'bg-gray-500') }}">
                        Payment: {{ ucfirst($booking->payment_status) }}
                    </span>

                </div>


                {{-- ACTION --}}
                <a href="{{ route('booking.show',$booking->id) }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">

                    View Details

                </a>

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