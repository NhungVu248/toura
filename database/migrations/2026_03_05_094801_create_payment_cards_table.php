<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentCardsTable extends Migration
{
    public function up()
    {
        Schema::create('payment_cards', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATION
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('payment_id');

            /*
            |--------------------------------------------------------------------------
            | CARD INFO
            |--------------------------------------------------------------------------
            */

            $table->string('card_number');

            $table->string('card_expiry');

            $table->string('card_cvv')->nullable();

            $table->string('card_holder')->nullable();

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
        Schema::dropIfExists('payment_cards');
    }
}