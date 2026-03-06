<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->unsignedInteger('adult_quantity')->default(1)->after('guest_quantity');

            $table->unsignedInteger('child_quantity')->default(0)->after('adult_quantity');

        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->dropColumn('adult_quantity');

            $table->dropColumn('child_quantity');

        });
    }
};