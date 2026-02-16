<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCccdSecurityOnUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            // Bỏ unique cũ nếu có
            $table->dropUnique(['cccd']);

            // Thêm cccd_hash để search & unique
            $table->string('cccd_hash', 64)->nullable()->unique()->after('cccd');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('cccd_hash');
        });
    }
}
