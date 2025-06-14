<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $devEmail = 'developer@example.com';

        User::firstOrCreate(
            ['email' => $devEmail],
            [
                'name' => 'developer',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ]
        );
        $this->command->info('User "developer" dengan role admin siap dipakai!');
    }
}
