<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('warnings', function (Blueprint $table) {
            $table->boolean('seen')
                ->default(false)
                ->after('message');
        });
    }

    public function down()
    {
        Schema::table('warnings', function (Blueprint $table) {
            $table->dropColumn('seen');
        });
    }
};
