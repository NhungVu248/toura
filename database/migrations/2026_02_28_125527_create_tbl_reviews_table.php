<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_reviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tour_id');
            $table->unsignedBigInteger('user_id')->nullable();

            $table->tinyInteger('rating'); // 1–5
            $table->text('comment')->nullable();

            $table->boolean('approved')->default(false);

            $table->timestamps();

            $table->foreign('tour_id')
                  ->references('id')
                  ->on('tbl_tours')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();

            $table->index(['tour_id', 'approved']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_reviews');
    }
};