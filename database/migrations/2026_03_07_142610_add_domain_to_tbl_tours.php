<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDomainToTblTours extends Migration
{
    public function up()
    {
        Schema::table('tbl_tours', function (Blueprint $table) {

            if (!Schema::hasColumn('tbl_tours','domain')) {
                $table->string('domain')
                    ->nullable()
                    ->after('destination');
            }

        });
    }

    public function down()
    {
        Schema::table('tbl_tours', function (Blueprint $table) {
            $table->dropColumn('domain');
        });
    }
}