<?php

use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

// 1. Cari user pertama di database untuk dikaitkan sebagai penulis artikel
$user = User::first();

if (!$user) {
    $user = User::create([
        'name' => 'Admin Nihongo Bu',
        'email' => 'admin@nihongobu.com',
        'password' => bcrypt('password123'),
    ]);
}

// 2. Cari kategori "Budaya" sebagai Parent
$parentBudaya = Category::firstOrCreate(
    ['slug' => 'budaya'],
    ['name' => 'Budaya Jepang']
);

// 3. Cari atau buat subkategori "Tradisional"
$subCategoryTradisional = Category::firstOrCreate(
    ['slug' => 'tradisional', 'parent_id' => $parentBudaya->id],
    ['name' => 'Budaya Tradisional', 'parent_id' => $parentBudaya->id]
);

// 4. Buat artikel dummy ke dalam subkategori Budaya Tradisional
$title = 'Mengenal Chado: Upacara Minum Teh Khas Jepang';
$content = '<p>Chado (茶道) atau yang sering dikenal dengan sebutan upacara minum teh adalah salah satu kebudayaan tradisional Jepang yang sangat ikonik. Chado bukan sekadar menyeduh teh matcha biasa, melainkan sebuah seni yang sarat akan filosofi dan ketenangan.</p>
<br>
<p>Inti dari Chado adalah "Ichigo Ichie" (一期一会), yang berarti "Satu kali pertemuan dalam seumur hidup". Filosofi ini mengajarkan kita untuk menghargai setiap momen pertemuan dengan orang lain, karena momen tersebut tidak akan pernah terulang kembali dengan cara yang sama persis.</p>
<br>
<p>Dalam upacara ini, tuan rumah (Teishu) menyajikan teh kepada tamu dengan gerakan yang sangat teratur dan anggun. Mulai dari membersihkan peralatan, menyeduh teh matcha dengan chasen (pengaduk bambu), hingga menyajikan teh bersama wagashi (manisan tradisional Jepang) untuk menyeimbangkan rasa pahit teh.</p>
<br>
<p>Mempelajari Chado mengajarkan kita tentang harmoni (Wa), rasa hormat (Kei), kemurnian (Sei), dan ketenangan (Jaku). Tertarik untuk mencoba upacara minum teh ini bersama Nihongo Bu? Pantau terus info kegiatan kami selanjutnya!</p>';

// Hapus artikel lama dengan judul yang sama (bila ada)
Article::where('title', $title)->delete();

$article = Article::create([
    'title' => $title,
    'slug' => Str::slug($title) . '-' . time(),
    'content' => $content,
    'category_id' => $subCategoryTradisional->id, // Dimasukkan ke subkategori 'Tradisional'
    'user_id' => $user->id,
    'type' => 'umum', 
    'status' => 'published',
    'view_count' => rand(10, 100),
]);

echo "Artikel dummy budaya berhasil ditambahkan ke subkategori 'Budaya Tradisional'!\nJudul: {$article->title}\nSilakan cek di halaman Budaya.";
