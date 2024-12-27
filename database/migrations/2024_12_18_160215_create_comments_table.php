<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('text');
            $table->boolean('seen')->default(false); // Default false
            $table->boolean('hide')->default(false); // Default false
            $table->timestamps();
            $table->unsignedBigInteger('parent_id')->nullable(); // Removed "AFTER user_id"
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade'); // Self-referencing foreign key
        });
    }

    public function down()
    {
        Schema::dropIfExists('comments');
    }
};

