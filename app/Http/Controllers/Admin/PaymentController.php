<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','admin']);
    }

    public function index(Request $request)
    {
        $q = Payment::with('booking','card','ewallet')->orderBy('created_at','desc');

        if ($request->filled('status')) {
            $q->where('payment_status', $request->status);
        }

        $payments = $q->paginate(20);

        return view('admin.payments.index', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payment::with('booking','card','bankTransfer','ewallet')->findOrFail($id);
        return view('admin.payments.show', compact('payment'));
    }

    // admin confirms a pending bank transfer or cash payment
     public function confirm(Payment $payment)
    {

        /*
        |--------------------------------------------------------------------------
        | CHECK IF ALREADY PAID
        |--------------------------------------------------------------------------
        */

        if ($payment->payment_status === 'paid') {

            return back()->with('info','Payment already confirmed.');

        }

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | UPDATE PAYMENT
            |--------------------------------------------------------------------------
            */

            $payment->update([

                'payment_status' => 'paid',

                'paid_at' => Carbon::now(),

                'transaction_code' =>
                    $payment->transaction_code ??
                    'ADMIN-' . Str::upper(Str::random(8))

            ]);

            /*
            |--------------------------------------------------------------------------
            | UPDATE BOOKING
            |--------------------------------------------------------------------------
            */

            if ($payment->booking) {

                $payment->booking->update([

                    'payment_status' => 'paid',

                    'booking_status' => 'confirmed'

                ]);

            }

            DB::commit();

            return back()->with('success','Payment confirmed successfully.');

        }

        catch (\Throwable $e) {

            DB::rollBack();

            return back()->with('error','Confirm payment failed.');

        }

    }

    public function markFailed(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->payment_status = 'failed';
        $payment->save();

        // optional rollback booking status
        if ($payment->booking) {
            $payment->booking->payment_status = 'pending';
            $payment->booking->booking_status = 'pending';
            $payment->booking->save();
        }

        return back()->with('success','Payment marked as failed.');
    }
}