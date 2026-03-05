<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATION
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('booking_id');

            /*
            |--------------------------------------------------------------------------
            | PAYMENT INFO
            |--------------------------------------------------------------------------
            */

            $table->enum('payment_method', [
                'cash',
                'card',
                'bank_transfer',
                'ewallet'
            ]);

            $table->string('payment_provider')->nullable();

            /*
            |--------------------------------------------------------------------------
            | AMOUNT
            |--------------------------------------------------------------------------
            */

            $table->decimal('amount', 12, 2);
            $table->unsignedInteger('discount_percent')->nullable();
            $table->decimal('final_amount', 12, 2);

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('payment_status', [
                'pending',
                'paid',
                'failed'
            ])->default('pending');

            $table->string('transaction_code')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->foreign('booking_id')
                  ->references('id')
                  ->on('bookings')
                  ->onDelete('cascade');

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */

            $table->index(['booking_id', 'payment_status']);

        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}