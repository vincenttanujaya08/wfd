<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Reply; // Pastikan Model Reply ada
use App\Models\CommentLike; // Pastikan Model CommentLike ada
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('id_ID');

        // 1. Tentukan Target Korban Notifikasi (Misal User ID 1)
        $targetUser = User::find(1);
        
        if (!$targetUser) {
            $this->command->info('User ID 1 tidak ditemukan. Pastikan UserSeeder sudah dijalankan.');
            return;
        }

        // Ambil user lain sebagai "Pelaku" (yang nge-like/komen)
        $actors = User::where('id', '!=', $targetUser->id)->get();

        if ($actors->count() == 0) {
            $this->command->info('Butuh user lain untuk membuat notifikasi.');
            return;
        }

        $this->command->info("Membuat notifikasi untuk user: " . $targetUser->name);

        // ---------------------------------------------------------
        // A. SIMULASI FOLLOWERS BARU (Unread)
        // ---------------------------------------------------------
        foreach ($actors->random(min(3, $actors->count())) as $actor) {
            // Cek dulu biar gak duplikat
            $exists = DB::table('user_followers')
                ->where('user_id', $targetUser->id)
                ->where('follower_id', $actor->id)
                ->exists();

            if (!$exists) {
                DB::table('user_followers')->insert([
                    'user_id'     => $targetUser->id,
                    'follower_id' => $actor->id,
                    'seen'        => 0, // PENTING: 0 artinya belum dibaca
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ]);
            }
        }

        // ---------------------------------------------------------
        // B. SIMULASI LIKE & KOMEN DI POSTINGAN TARGET
        // ---------------------------------------------------------
        $posts = Post::where('user_id', $targetUser->id)->get();

        foreach ($posts as $post) {
            // 1. Buat Fake Like (Unread)
            $randomActor = $actors->random();
            // Cek duplicate like
            if (!Like::where('user_id', $randomActor->id)->where('post_id', $post->id)->exists()) {
                Like::create([
                    'user_id' => $randomActor->id,
                    'post_id' => $post->id,
                    'seen'    => 0, // Unread
                ]);
                $post->increment('likes_count');
            }

            // 2. Buat Fake Comment (Unread)
            Comment::create([
                'user_id' => $actors->random()->id,
                'post_id' => $post->id,
                'text'    => $faker->sentence(),
                'seen'    => 0, // Unread
            ]);
        }

        // ---------------------------------------------------------
        // C. SIMULASI REPLY & LIKE DI KOMENTAR TARGET
        // ---------------------------------------------------------
        // Ambil komentar milik target user di postingan orang lain/diri sendiri
        $myComments = Comment::where('user_id', $targetUser->id)->get();

        foreach ($myComments as $comment) {
            // 1. Orang lain membalas komentar kita
            Reply::create([
                'comment_id' => $comment->id,
                'user_id'    => $actors->random()->id,
                'text'       => 'Balasan: ' . $faker->sentence(),
                'seen'       => 0, // Unread
            ]);

            // 2. Orang lain menyukai komentar kita
            // Cek duplicate comment like
            $actorForLike = $actors->random();
            $exists = CommentLike::where('comment_id', $comment->id)
                                 ->where('user_id', $actorForLike->id)
                                 ->exists();
            
            if (!$exists) {
                CommentLike::create([
                    'comment_id' => $comment->id,
                    'user_id'    => $actorForLike->id,
                    'seen'       => 0, // Unread
                ]);
            }
        }
    }
}