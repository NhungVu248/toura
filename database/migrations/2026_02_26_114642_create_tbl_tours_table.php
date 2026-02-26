<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblToursTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_tours', function (Blueprint $table) {
            $table->id();

            // Thông tin cơ bản
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('destination');
            $table->string('departure_location');
            $table->integer('duration'); // số ngày

            // Mô tả
            $table->text('short_description');
            $table->longText('description');

            // Giá
            $table->decimal('price_adult', 12, 2);
            $table->decimal('price_child', 12, 2)->nullable();

            // Ảnh
            $table->string('thumbnail')->nullable();

            // Trạng thái
            $table->enum('status', ['active', 'inactive'])->default('active');

            // Nổi bật
            $table->boolean('is_featured')->default(false);

            $table->timestamps();
            // $table->softDeletes(); // optional
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_tours');
    }
}