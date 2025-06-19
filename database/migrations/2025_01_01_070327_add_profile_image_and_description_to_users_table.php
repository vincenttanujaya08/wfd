<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileImageAndDescriptionToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Add a profile_image column with a default link
            $table->string('profile_image', 2083) // 2083 is the maximum length for a URL
                ->default('images/default-profile.png') // Default image link
                ->after('email');

            // Add a description column with a default value
            $table->string('description')->default(' ')->after('profile_image');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the columns
            $table->dropColumn(['profile_image', 'description']);
        });
    }
}
