<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {

            // Phone
            $table->string('phone', 20)->nullable()->after('email')->index();
            $table->timestamp('phone_verified_at')->nullable()->after('phone');

            // Address
            $table->text('address')->nullable()->after('phone_verified_at');

            // Role
            $table->string('role')->default('user')->after('address');

            // Avatar
            $table->string('avatar_url')->nullable()->after('role');

            // Last login
            $table->timestamp('last_login_at')->nullable()->after('avatar_url');

            // Active status
            $table->boolean('is_active')->default(true)->after('last_login_at');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'phone_verified_at',
                'address',
                'role',
                'avatar_url',
                'last_login_at',
                'is_active'
            ]);
        });
    }
}
