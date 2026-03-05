<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankTransfersTable extends Migration
{
    public function up()
    {
        Schema::create('bank_transfers', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATION
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('payment_id');

            /*
            |--------------------------------------------------------------------------
            | BANK INFO
            |--------------------------------------------------------------------------
            */

            $table->string('bank_name');

            $table->string('account_number');

            $table->string('account_holder');

            $table->string('transfer_content');

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
        Schema::dropIfExists('bank_transfers');
    }
}