<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('newsletter_subscriptions', function (Blueprint $table) {

            $table->id();

            // email đăng ký
            $table->string('email')->unique();

            // tên người dùng (không bắt buộc)
            $table->string('name')->nullable();

            // đã xác nhận email chưa
            $table->boolean('confirmed')->default(false);

            // thời gian đăng ký
            $table->timestamp('subscribed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('newsletter_subscriptions');
    }
};