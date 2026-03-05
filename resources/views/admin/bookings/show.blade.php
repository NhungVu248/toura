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
            <select name="status"
                    class="border rounded px-3 py-2 text-gray-700">
                <option value="">Tất cả</option>
                <option value="pending"
                    {{ request('status')=='pending'?'selected':'' }}>
                    Pending
                </option>
                <option value="confirmed"
                    {{ request('status')=='confirmed'?'selected':'' }}>
                    Confirmed
                </option>
                <option value="cancelled"
                    {{ request('status')=='cancelled'?'selected':'' }}>
                    Cancelled
                </option>
            </select>
        </div>

        <div>
            <label class="block text-sm mb-1 text-gray-700">Payment Status</label>
            <select name="payment"
                    class="border rounded px-3 py-2 text-gray-700">
                <option value="">Tất cả</option>
                <option value="pending"
                    {{ request('payment')=='pending'?'selected':'' }}>
                    Pending
                </option>
                <option value="paid"
                    {{ request('payment')=='paid'?'selected':'' }}>
                    Paid
                </option>
                <option value="cancelled"
                    {{ request('payment')=='cancelled'?'selected':'' }}>
                    Cancelled
                </option>
            </select>
        </div>

        <button class="bg-blue-500 hover:bg-blue-600 text-gray-900 px-4 py-2 rounded shadow">
            Lọc
        </button>

        <a href="{{ route('admin.bookings.index') }}"
           class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded">
            Reset
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
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-100 text-gray-800">
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

                <tr class="border-t hover:bg-gray-50">

                    <td class="px-4 py-3 font-semibold">
                        #{{ $booking->id }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $booking->tour->title ?? '-' }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $booking->full_name }}
                    </td>

                    <td class="px-4 py-3 font-semibold text-pink-600">
                        {{ number_format($booking->total_price,0,',','.') }} đ
                    </td>

                    {{-- BOOKING STATUS --}}
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded font-medium
                            {{ $booking->booking_status=='confirmed' ? 'bg-green-100 text-green-700' :
                               ($booking->booking_status=='cancelled' ? 'bg-red-100 text-red-700' :
                               'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($booking->booking_status) }}
                        </span>
                    </td>

                    {{-- PAYMENT STATUS --}}
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-xs rounded font-medium
                            {{ $booking->payment_status=='paid' ? 'bg-green-100 text-green-700' :
                               ($booking->payment_status=='cancelled' ? 'bg-red-100 text-red-700' :
                               'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($booking->payment_status) }}
                        </span>
                    </td>

                    <td class="px-4 py-3">

                        <a href="{{ route('admin.bookings.index') }}"
                           class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-800 rounded text-xs font-medium">

                            Quay lại

                        </a>

                    </td>

                </tr>

            </tbody>
        </table>
    </div>

</div>
@endsection