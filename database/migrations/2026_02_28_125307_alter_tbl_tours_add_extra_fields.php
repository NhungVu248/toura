<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_tours', function (Blueprint $table) {

            // Giá gốc (để hiển thị giảm giá)
            $table->decimal('price_original', 12, 2)
                  ->nullable()
                  ->after('price_adult');

            // Sức chứa mặc định của tour
            $table->unsignedInteger('capacity')
                  ->default(30)
                  ->after('is_featured');

            // Rating tổng hợp (denormalized)
            $table->decimal('rating_avg', 3, 2)
                  ->default(0.00)
                  ->after('capacity');

            $table->unsignedInteger('rating_count')
                  ->default(0)
                  ->after('rating_avg');

            // Chính sách hủy
            $table->text('cancellation_policy')
                  ->nullable()
                  ->after('description');

            // Địa chỉ chi tiết
            $table->string('location_address')
                  ->nullable()
                  ->after('departure_location');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_tours', function (Blueprint $table) {
            $table->dropColumn([
                'price_original',
                'capacity',
                'rating_avg',
                'rating_count',
                'cancellation_policy',
                'location_address'
            ]);
        });
    }
};