<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class DummyBahasaArticleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil admin user pertama
        $user = User::first();
        
        // 2. Ambil kategori Complete Guide
        $category = Category::where('slug', 'complete-guide')->first();

        if (!$category) {
            $this->command->error("Kategori 'Complete Guide' tidak ditemukan. Pastikan CategorySeeder sudah dijalankan.");
            return;
        }

        // 3. Daftar topik untuk 12 artikel
        $topics = [
            ['title' => 'Salam Perkenalan (Aisatsu)', 'jp' => '挨拶', 'rm' => 'Aisatsu'],
            ['title' => 'Partikel Dasar (Wa, Ga, O)', 'jp' => '助詞', 'rm' => 'Joshi'],
            ['title' => 'Angka dan Waktu', 'jp' => '数字と時間', 'rm' => 'Suuji to Jikan'],
            ['title' => 'Hari dan Tanggal', 'jp' => '曜日と日付', 'rm' => 'Youbi to Hiduke'],
            ['title' => 'Keluarga dan Sebutan', 'jp' => '家族', 'rm' => 'Kazoku'],
            ['title' => 'Kata Tunjuk (Kore, Sore, Are)', 'jp' => '指示詞', 'rm' => 'Shijishi'],
            ['title' => 'Kata Sifat Dasar (I & Na)', 'jp' => '形容詞', 'rm' => 'Keiyoushi'],
            ['title' => 'Kata Kerja Bentuk Masu', 'jp' => '動詞 (ます形)', 'rm' => 'Doushi (Masu-kei)'],
            ['title' => 'Cara Memesan Makanan', 'jp' => '注文', 'rm' => 'Chuumon'],
            ['title' => 'Menanyakan Arah dan Tempat', 'jp' => '道案内', 'rm' => 'Michiannai'],
            ['title' => 'Bentuk Lampau (Mashita)', 'jp' => '過去形', 'rm' => 'Kakokei'],
            ['title' => 'Mengungkapkan Keinginan (Tai)', 'jp' => '希望表現', 'rm' => 'Kibou Hyougen'],
        ];

        // 4. Generate 12 artikel
        foreach ($topics as $index => $topic) {
            $fullTitle = "Panduan Lengkap: " . $topic['title'];
            
            Article::create([
                'user_id' => $user->id ?? 1,
                'category_id' => $category->id,
                'title' => $fullTitle,
                'slug' => Str::slug($fullTitle) . '-' . uniqid(),
                'type' => 'bahasa',
                'kemahiran_level' => 'pemula', // Level Pemula
                'status' => 'published',
                'excerpt' => "Panduan belajar bahasa Jepang tingkat pemula yang membahas tuntas tentang {$topic['title']}.",
                'content' => "<p>Ini adalah konten pembelajaran dummy untuk materi <strong>{$topic['title']}</strong>.</p><p>Panduan ini dirancang khusus untuk pemula yang ingin memahami konsep dasar secara perlahan dan terstruktur. Silakan baca dan pahami tabel kosakata serta contoh kalimat di bawah ini.</p>",
                'japanese_title' => $topic['jp'],
                'romaji_title' => $topic['rm'],
                'read_time' => rand(3, 8),
                'view_count' => rand(15, 1000),
                'published_at' => now()->subDays(rand(1, 30)),
            ]);
        }
        
        $this->command->info("✅ 12 Artikel Dummy (Bahasa > Complete Guide > Pemula) berhasil dibuat!");
    }
}
