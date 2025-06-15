<?php

// database/migrations/xxxx_xx_xx_create_warnings_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarningsTable extends Migration
{
    public function up()
    {
        Schema::create('warnings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('admin_id');
            $table->text('message');
            $table->unsignedBigInteger('report_id')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('report_id')->references('id')->on('reports')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('warnings');
    }
}
