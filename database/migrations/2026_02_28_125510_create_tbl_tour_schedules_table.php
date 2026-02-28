<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_tour_schedules', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tour_id');

            $table->date('departure_date');
            $table->time('departure_time')->nullable();

            $table->unsignedInteger('seats_total')->default(30);
            $table->unsignedInteger('seats_available')->default(30);

            $table->decimal('price_override', 12, 2)->nullable();

            $table->enum('status', ['open', 'sold_out', 'cancelled'])
                  ->default('open');

            $table->timestamps();

            $table->foreign('tour_id')
                  ->references('id')
                  ->on('tbl_tours')
                  ->onDelete('cascade');

            $table->index(['tour_id', 'departure_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_tour_schedules');
    }
};