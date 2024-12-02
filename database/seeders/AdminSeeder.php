<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $adminExists = User::where('email', 'admin@gmail.com')->exists();

        if (!$adminExists) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'), // Securely hash the password
            ]);
            echo "Admin user created.\n";
        } else {
            echo "Admin user already exists.\n";
        }
    }
}

