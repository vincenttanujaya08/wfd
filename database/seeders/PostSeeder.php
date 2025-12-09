<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Topic;
use App\Models\Image; // Pastikan model Image diimport
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID'); // Menggunakan locale Indonesia
        
        // Ambil semua user dan topic yang sudah ada
        $users = User::all();
        $topics = Topic::all();

        // Cek jika belum ada user atau topic, buat dulu (opsional, untuk safety)
        if($users->count() == 0) {
            $this->command->info('Harap jalankan UserSeeder terlebih dahulu!');
            return;
        }

        foreach ($users as $user) {
            // Setiap user membuat 3-5 postingan
            $limit = rand(3, 5); 

            for ($i = 0; $i < $limit; $i++) {
                $post = Post::create([
                    'user_id'     => $user->id,
                    'description' => $faker->paragraph(),
                    'status'      => $faker->boolean(80), // 80% kemungkinan status true (public)
                    'likes_count' => rand(0, 100),
                    'edited'      => $faker->boolean(10), // 10% kemungkinan pernah diedit
                    'created_at'  => $faker->dateTimeBetween('-1 year', 'now'),
                ]);

                // 1. Attach Random Topics (Many-to-Many)
                if($topics->count() > 0) {
                    // Ambil 1-3 topik acak
                    $randomTopics = $topics->random(rand(1, 3))->pluck('id')->toArray();
                    $post->topics()->sync($randomTopics);
                }

                // 2. Attach Dummy Images (One-to-Many)
                // Hanya 50% postingan yang punya gambar
                if($faker->boolean(50)) {
                    Image::create([
                        'post_id' => $post->id,
                        'path'    => 'https://picsum.photos/seed/' . rand(1, 9999) . '/600/400', // Gambar random placeholder
                    ]);
                }
            }
        }
    }
}