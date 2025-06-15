<?php

// database/migrations/xxxx_xx_xx_create_appeals_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppealsTable extends Migration
{
    public function up()
    {
        Schema::create('appeals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ban_id');
            $table->unsignedBigInteger('user_id');
            $table->text('message');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->foreign('ban_id')->references('id')->on('bans')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('appeals');
    }
}
