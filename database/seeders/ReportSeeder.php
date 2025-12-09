<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Report;
use Faker\Factory as Faker;

class ReportSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');
        
        // Ambil semua user
        $users = User::all();

        // Pastikan ada minimal 2 user untuk saling lapor
        if($users->count() < 2) {
            $this->command->info('User terlalu sedikit untuk membuat dummy report.');
            return;
        }

        foreach ($users as $index => $user) {
            // Setiap user melaporkan 1-2 user lain secara acak
            $targets = $users->except($user->id)->random(rand(1, 2));

            foreach ($targets as $target) {
                Report::create([
                    'reporter_id'      => $user->id,
                    'reported_user_id' => $target->id,
                    'description'      => $faker->randomElement([
                        'Mengirim pesan spam berulang kali.',
                        'Postingan mengandung ujaran kebencian.',
                        'Menggunakan foto profil palsu.',
                        'Berkomentar kasar di postingan saya.',
                        'Penipuan berkedok investasi.'
                    ]),
                    'status'           => $faker->randomElement(['pending', 'pending', 'resolved']), // Lebih banyak pending
                    'created_at'       => $faker->dateTimeBetween('-1 month', 'now'),
                ]);
            }
        }
    }
}