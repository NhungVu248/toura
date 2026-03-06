<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblContactsTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('phone_number', 20)->nullable();
            $table->string('email', 255)->nullable();
            $table->text('message');
            $table->enum('status', ['new', 'in_progress', 'replied', 'closed'])->default('new');
            $table->text('admin_reply')->nullable();
            $table->timestamp('replied_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_contacts');
    }
}