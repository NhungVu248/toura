<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentCard;
use App\Models\BankTransfer;
use App\Models\EwalletPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckoutController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | SHOW CHECKOUT PAGE
    |--------------------------------------------------------------------------
    */

    public function show(Booking $booking)
    {
        $bank = config('payment.bank');

        /*
        |--------------------------------------------------------------------------
        | TRANSFER CONTENT
        |--------------------------------------------------------------------------
        */

        $transferContent =
            $booking->full_name.' '.
            $booking->phone.' '.
            $booking->tour->title;

        /*
        |--------------------------------------------------------------------------
        | QR CODE
        |--------------------------------------------------------------------------
        */

        $qrUrl =
            "https://img.vietqr.io/image/"
            .$bank['bank_code']."-"
            .$bank['account_number']
            ."-compact2.png"
            ."?amount=".$booking->total_price
            ."&addInfo=".urlencode($transferContent)
            ."&accountName=".urlencode($bank['account_name']);

        return view('checkout.form',[
            'booking'=>$booking,
            'bank'=>$bank,
            'qrUrl'=>$qrUrl,
            'transferContent'=>$transferContent
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE PAYMENT
    |--------------------------------------------------------------------------
    */

    public function store(Request $request, Booking $booking)
    {
        $request->validate([

            'payment_method' => 'required|in:cash,card,bank_transfer,ewallet',

            'card_number' => 'required_if:payment_method,card',

            'card_expiry' => 'required_if:payment_method,card',

            'card_cvv' => 'required_if:payment_method,card',

            'wallet_provider' => 'required_if:payment_method,ewallet',

        ]);

        $amount = $booking->total_price;

        DB::beginTransaction();

        try {

            $payment = Payment::create([

                'booking_id' => $booking->id,

                'payment_method' => $request->payment_method,

                'payment_provider' => $request->wallet_provider,

                'amount' => $amount,

                'discount_percent' => $booking->discount_percent,

                'final_amount' => $amount,

                'payment_status' => 'pending',

            ]);

            /*
            |--------------------------------------------------------------------------
            | CASH PAYMENT
            |--------------------------------------------------------------------------
            */

            if ($request->payment_method === 'cash') {

                $payment->transaction_code =
                    'CASH-' . Str::upper(Str::random(8));

                $payment->save();

            }

            /*
            |--------------------------------------------------------------------------
            | CARD PAYMENT
            |--------------------------------------------------------------------------
            */

            elseif ($request->payment_method === 'card') {

                PaymentCard::create([

                    'payment_id' => $payment->id,

                    'card_number' => encrypt($request->card_number),

                    'card_expiry' => $request->card_expiry,

                    'card_cvv' => null,

                    'card_holder' =>
                        $request->card_holder ?? $booking->full_name,

                ]);

                $payment->payment_status = 'paid';

                $payment->transaction_code =
                    'CARD-' . strtoupper(Str::random(10));

                $payment->paid_at = Carbon::now();

                $payment->save();

                $booking->update([

                    'payment_status'=>'pending',

                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | BANK TRANSFER
            |--------------------------------------------------------------------------
            */

            elseif ($request->payment_method === 'bank_transfer') {

                $bank = config('payment.bank');

                $transferContent =
                    $booking->full_name.' '.
                    $booking->phone.' '.
                    $booking->tour->title;

                BankTransfer::create([

                    'payment_id' => $payment->id,

                    'bank_name' => $bank['name'],

                    'account_number' => $bank['account_number'],

                    'account_holder' => $bank['account_name'],

                    'transfer_content' => $transferContent,

                ]);

                $payment->transaction_code =
                    'BANK-' . strtoupper(Str::random(8));

                $payment->save();
            }

            /*
            |--------------------------------------------------------------------------
            | EWALLET
            |--------------------------------------------------------------------------
            */

            elseif ($request->payment_method === 'ewallet') {

                $ewallet = EwalletPayment::create([

                    'payment_id' => $payment->id,

                    'wallet_provider' => $request->wallet_provider,

                    'transaction_id' =>
                        'EW-' . strtoupper(Str::random(12)),

                ]);

                $payment->payment_status = 'paid';

                $payment->transaction_code =
                    $ewallet->transaction_id;

                $payment->paid_at = Carbon::now();

                $payment->save();

                $booking->update([

                    'payment_status'=>'paid',

                    'booking_status'=>'confirmed'

                ]);
            }

            DB::commit();

            return redirect()
                ->route('checkout.success',$payment->id);

        } catch (\Throwable $e) {

            DB::rollBack();

            \Log::error('Checkout error: '.$e->getMessage());

            return back()
                ->withErrors('Có lỗi xử lý thanh toán');
        }
    }

    /*
    |--------------------------------------------------------------------------
    | PAYMENT SUCCESS
    |--------------------------------------------------------------------------
    */

    public function success($paymentId)
    {
        $payment = Payment::with(
            'booking',
            'card',
            'bankTransfer',
            'ewallet'
        )->findOrFail($paymentId);

        return view('checkout.success', compact('payment'));
    }
}