<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Tour;
use App\Models\TourSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Show booking form
    |--------------------------------------------------------------------------
    */
    public function create(Tour $tour)
    {
        $tour->load('upcomingSchedules');

        if ($tour->upcomingSchedules->isEmpty()) {
            return back()->with('error', 'Tour hiện chưa có lịch khởi hành.');
        }

        return view('bookings.create', compact('tour'));
    }

    /*
    |--------------------------------------------------------------------------
    | Store booking
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tour_id' => 'required|exists:tbl_tours,id',
            'schedule_id' => 'required|exists:tbl_tour_schedules,id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'guest_quantity' => 'required|integer|min:1',
            'travel_insurance' => 'nullable',
            'private_guide' => 'nullable',
            'airport_pickup' => 'nullable',
            'coupon_code' => 'nullable|string|max:50',
        ]);

        DB::beginTransaction();

        try {
            $tour = Tour::findOrFail($data['tour_id']);

            // Lock schedule row to prevent overbooking
            $schedule = TourSchedule::where('id', $data['schedule_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $guestQty = (int) $data['guest_quantity'];

            /*
            |--------------------------------------------------------------------------
            | CHECK AVAILABLE SEATS
            |--------------------------------------------------------------------------
            */
            if ($schedule->seats_available < $guestQty) {
                return back()->withInput()
                    ->with('error', 'Số chỗ còn lại không đủ.');
            }

            /*
            |--------------------------------------------------------------------------
            | PRICE CALCULATION
            |--------------------------------------------------------------------------
            */
            $tourPrice = $tour->price_adult;
            $subtotal = $tourPrice * $guestQty;

            $travelInsurance = $request->boolean('travel_insurance');
            $privateGuide = $request->boolean('private_guide');
            $airportPickup = $request->boolean('airport_pickup');

            $serviceTotal = 0;

            if ($travelInsurance) {
                $serviceTotal += 100000 * $guestQty;
            }

            if ($privateGuide) {
                $serviceTotal += 500000 * $guestQty;
            }

            if ($airportPickup) {
                $serviceTotal += 300000 * $guestQty;
            }

            /*
            |--------------------------------------------------------------------------
            | COUPON SIMPLE LOGIC
            |--------------------------------------------------------------------------
            */
            $discountPercent = null;
            $discountAmount = 0;

            if ($request->filled('coupon_code')) {
                if (strtoupper($request->coupon_code) === 'VIP10') {
                    $discountPercent = 10;
                }

                if ($discountPercent) {
                    $discountAmount = ($subtotal + $serviceTotal)
                        * ($discountPercent / 100);
                }
            }

            $total = $subtotal + $serviceTotal - $discountAmount;

            /*
            |--------------------------------------------------------------------------
            | CREATE BOOKING
            |--------------------------------------------------------------------------
            */
            $booking = Booking::create([
                'tour_id' => $tour->id,
                'user_id' => Auth::id(),
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'guest_quantity' => $guestQty,
                'departure_date' => $schedule->departure_date,
                'travel_insurance' => $travelInsurance,
                'private_guide' => $privateGuide,
                'airport_pickup' => $airportPickup,
                'coupon_code' => $request->coupon_code,
                'discount_percent' => $discountPercent,
                'discount_amount' => $discountAmount,
                'tour_price' => $tourPrice,
                'subtotal' => $subtotal,
                'service_total' => $serviceTotal,
                'total_price' => $total,
                'payment_status' => 'pending',
                'booking_status' => 'pending',
            ]);

            DB::commit();

            return redirect()
                ->route('booking.show', $booking)
                ->with('success', 'Đặt chỗ thành công. Vui lòng thanh toán.');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Booking Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Có lỗi xảy ra khi đặt tour.');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Show booking detail (Client)
    |--------------------------------------------------------------------------
    */
    public function show(Booking $booking)
    {
        // Security: user can only see their own booking
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load('tour');

        return view('bookings.show', compact('booking'));
    }
}