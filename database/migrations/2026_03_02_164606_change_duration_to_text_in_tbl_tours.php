<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('tbl_tours', function (Blueprint $table) {
            $table->string('duration')->change();
        });
    }

    public function down()
    {
        Schema::table('tbl_tours', function (Blueprint $table) {
            $table->integer('duration')->change();
        });
    }
};
