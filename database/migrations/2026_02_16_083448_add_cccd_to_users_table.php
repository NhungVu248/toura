<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCccdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cccd', 20)->nullable()->unique()->after('phone');
            $table->timestamp('cccd_verified_at')->nullable()->after('cccd');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cccd', 'cccd_verified_at']);
        });
    }
}
