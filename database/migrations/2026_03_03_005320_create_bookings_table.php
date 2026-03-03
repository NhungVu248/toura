<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | BOOKINGS TABLE
        |--------------------------------------------------------------------------
        */
        Schema::create('bookings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELATIONS
            |--------------------------------------------------------------------------
            */
            $table->unsignedBigInteger('tour_id');
            $table->unsignedBigInteger('user_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | CONTACT INFORMATION
            |--------------------------------------------------------------------------
            */
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 20);
            $table->unsignedInteger('guest_quantity');

            /*
            |--------------------------------------------------------------------------
            | BOOKING INFO
            |--------------------------------------------------------------------------
            */
            $table->date('departure_date');

            /*
            |--------------------------------------------------------------------------
            | ADD-ON SERVICES (Checkbox Style)
            |--------------------------------------------------------------------------
            */
            $table->boolean('travel_insurance')->default(false);
            $table->boolean('private_guide')->default(false);
            $table->boolean('airport_pickup')->default(false);

            /*
            |--------------------------------------------------------------------------
            | COUPON / DISCOUNT
            |--------------------------------------------------------------------------
            */
            $table->string('coupon_code')->nullable();
            $table->unsignedInteger('discount_percent')->nullable();
            $table->decimal('discount_amount', 12, 2)->nullable();

            /*
            |--------------------------------------------------------------------------
            | PRICING
            |--------------------------------------------------------------------------
            */
            $table->decimal('tour_price', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->decimal('service_total', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2);

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */
            $table->enum('payment_status', ['pending','paid','cancelled'])
                  ->default('pending');

            $table->enum('booking_status', ['pending','confirmed','cancelled'])
                  ->default('pending');

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | FOREIGN KEYS
            |--------------------------------------------------------------------------
            */
            $table->foreign('tour_id')
                  ->references('id')
                  ->on('tbl_tours')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | INDEX
            |--------------------------------------------------------------------------
            */
            $table->index(['tour_id', 'departure_date']);
        });

        /*
        |--------------------------------------------------------------------------
        | OPTIONAL: BOOKING SERVICES TABLE (Advanced Design)
        |--------------------------------------------------------------------------
        */
        Schema::create('booking_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('booking_id');
            $table->string('service_name');
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('quantity')->default(1);
            $table->timestamps();

            $table->foreign('booking_id')
                  ->references('id')
                  ->on('bookings')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_services');
        Schema::dropIfExists('bookings');
    }
};