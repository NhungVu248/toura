<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TourSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('tour','user')
            ->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('booking_status', $request->status);
        }

        if ($request->filled('payment')) {
            $query->where('payment_status', $request->payment);
        }

        $bookings = $query->paginate(20);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load('tour','user');
        return view('admin.bookings.show', compact('booking'));
    }

    /*
    |--------------------------------------------------------------------------
    | CONFIRM BOOKING (TRỪ CHỖ)
    |--------------------------------------------------------------------------
    */
    public function confirm(Booking $booking)
    {
        DB::transaction(function () use ($booking) {

            $schedule = TourSchedule::whereDate(
                'departure_date',
                $booking->departure_date
            )->lockForUpdate()->first();

            if (!$schedule) {
                abort(400, 'Không tìm thấy lịch.');
            }

            if ($schedule->seats_available < $booking->guest_quantity) {
                abort(400, 'Không đủ chỗ.');
            }

            $schedule->seats_available -= $booking->guest_quantity;
            $schedule->save();

            $booking->booking_status = 'confirmed';
            $booking->save();
        });

        return back()->with('success', 'Booking đã được xác nhận.');
    }

    public function markPaid(Booking $booking)
    {
        $booking->payment_status = 'paid';

        if ($booking->booking_status === 'pending') {
            $booking->booking_status = 'confirmed';
        }

        $booking->save();

        return back()->with('success', 'Đã đánh dấu thanh toán.');
    }

    public function cancel(Booking $booking)
    {
        if ($booking->booking_status === 'confirmed') {

            $schedule = TourSchedule::whereDate(
                'departure_date',
                $booking->departure_date
            )->first();

            if ($schedule) {
                $schedule->seats_available += $booking->guest_quantity;
                $schedule->save();
            }
        }

        $booking->booking_status = 'cancelled';
        $booking->payment_status = 'cancelled';
        $booking->save();

        return back()->with('success', 'Booking đã bị hủy.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking đã xóa.');
    }
}