<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ban;
use App\Models\Appeal;
use Faker\Factory as Faker;
use Carbon\Carbon;

class AppealSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // Ambil user untuk jadi Admin (anggap user pertama adalah admin)
        // Sesuaikan logika ini jika Anda punya Role khusus
        $admin = User::first(); 
        
        // Ambil user lain untuk di-ban (kecuali admin)
        $usersToBan = User::where('id', '!=', $admin->id)->inRandomOrder()->take(5)->get();

        if($usersToBan->isEmpty()) {
            $this->command->info('Tidak ada user untuk di-ban.');
            return;
        }

        foreach ($usersToBan as $user) {
            // 1. Buat Data BAN Terlebih Dahulu
            $ban = Ban::create([
                'user_id'      => $user->id,
                'admin_id'     => $admin->id,
                'reason'       => $faker->sentence(),
                'banned_at'    => Carbon::now()->subDays(rand(1, 10)), // Di-ban beberapa hari lalu
                'banned_until' => Carbon::now()->addDays(rand(1, 30)), // Sampai bulan depan
                'is_active'    => true,
            ]);

            // 2. Buat Data APPEAL (Banding) untuk Ban tersebut
            Appeal::create([
                'ban_id'  => $ban->id,
                'user_id' => $user->id,
                'message' => $faker->paragraph(), // Alasan kenapa minta unban
                'status'  => $faker->randomElement(['pending', 'rejected', 'approved']),
            ]);
        }
    }
}