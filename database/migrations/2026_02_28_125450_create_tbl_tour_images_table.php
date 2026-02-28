<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tbl_tour_images', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tour_id');

            $table->string('path'); // đường dẫn file
            $table->string('caption')->nullable();

            $table->boolean('is_primary')->default(false);
            $table->integer('sort_order')->default(0);

            $table->timestamps();

            $table->foreign('tour_id')
                  ->references('id')
                  ->on('tbl_tours')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_tour_images');
    }
};