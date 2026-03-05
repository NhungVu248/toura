<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tbl_tours', function (Blueprint $table) {
            $table->text('highlights')->nullable()->change();
            $table->text('included_services')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('tbl_tours', function (Blueprint $table) {
            $table->json('highlights')->change();
            $table->json('included_services')->change();
            $table->json('itinerary')->change();
        });
    }
};
