@extends('admin.layouts.master')

@section('content')
<div class="p-6">

    <h2 class="text-2xl font-semibold mb-6">
        Quản lý Booking
    </h2>

    {{-- FILTER --}}
    <form method="GET" class="mb-6 flex gap-4 items-end">

        <div>
            <label class="block text-sm mb-1">Booking Status</label>
            <select name="status"
                    class="border rounded px-3 py-2">
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
            <label class="block text-sm mb-1">Payment Status</label>
            <select name="payment"
                    class="border rounded px-3 py-2">
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

        <button class="bg-blue-600 text-white px-4 py-2 rounded">
            Lọc
        </button>

        <a href="{{ route('admin.bookings.index') }}"
           class="px-4 py-2 border rounded">
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
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
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
                <tr class="border-t">

                    <td class="px-4 py-3">
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

                    {{-- BOOKING STATUS BADGE --}}
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-white text-xs rounded
                            {{ $b->booking_status=='confirmed' ? 'bg-green-500' :
                               ($b->booking_status=='cancelled' ? 'bg-red-500' : 'bg-yellow-500') }}">
                            {{ ucfirst($b->booking_status) }}
                        </span>
                    </td>

                    {{-- PAYMENT STATUS BADGE --}}
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 text-white text-xs rounded
                            {{ $b->payment_status=='paid' ? 'bg-green-600' :
                               ($b->payment_status=='cancelled' ? 'bg-red-600' : 'bg-gray-500') }}">
                            {{ ucfirst($b->payment_status) }}
                        </span>
                    </td>

                    <td class="px-4 py-3 space-x-2">

                        <a href="{{ route('admin.bookings.show',$b->id) }}"
                           class="px-3 py-1 bg-blue-500 text-white rounded text-xs">
                            Xem
                        </a>

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