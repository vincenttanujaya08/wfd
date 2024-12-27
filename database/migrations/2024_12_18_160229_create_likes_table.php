<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        if (Schema::hasTable('likes')) {
            Schema::table('likes', function (Blueprint $table) {
                $table->boolean('seen')->default(false); // Add the `seen` column
            });
        }
    }

    public function down()
    {
        if (Schema::hasTable('likes')) {
            Schema::table('likes', function (Blueprint $table) {
                $table->dropColumn('seen');
            });
        }
    }
};
