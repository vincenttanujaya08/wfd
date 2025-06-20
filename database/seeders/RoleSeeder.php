<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();

        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'admin',  'created_at' => $now, 'updated_at' => $now],
            ['id' => 2, 'name' => 'user',   'created_at' => $now, 'updated_at' => $now],
            ['id' => 3, 'name' => 'banned', 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
