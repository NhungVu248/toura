<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEwalletPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('ewallet_payments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATION
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('payment_id');

            /*
            |--------------------------------------------------------------------------
            | EWALLET INFO
            |--------------------------------------------------------------------------
            */

            $table->string('wallet_provider');

            $table->string('transaction_id')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEY
            |--------------------------------------------------------------------------
            */

            $table->foreign('payment_id')
                  ->references('id')
                  ->on('payments')
                  ->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('ewallet_payments');
    }
}