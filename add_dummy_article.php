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

// 2. Cari kategori "Kegiatan" sebagai Parent
$parentKegiatan = Category::firstOrCreate(
    ['slug' => 'kegiatan'],
    ['name' => 'Kegiatan UKM']
);

// 3. Hapus kategori "Festival" (untuk membersihkan DB sesuai permintaan user)
$festivalCategory = Category::where('slug', 'festival')->first();
if ($festivalCategory) {
    // Pindahkan artikel di kategori festival ke kategori lain atau hapus
    Article::where('category_id', $festivalCategory->id)->delete();
    $festivalCategory->delete();
    echo "Kategori 'Festival' berhasil dihapus.\n";
}

// 4. Cari atau buat subkategori "Kegiatan Terbaru"
$subCategoryTerbaru = Category::firstOrCreate(
    ['slug' => 'kegiatan-terbaru', 'parent_id' => $parentKegiatan->id],
    ['name' => 'Kegiatan Terbaru', 'parent_id' => $parentKegiatan->id]
);

// 5. Buat artikel dummy ke dalam subkategori Kegiatan Terbaru
$title = 'Serunya Bunkasai (Festival Budaya Jepang) Tahun Ini!';
$content = '<p>Bunkasai (文化祭) atau festival budaya Jepang adalah salah satu kegiatan tahunan yang paling ditunggu-tunggu oleh seluruh anggota Nihongo Bu. Pada kegiatan kali ini, kami mengadakan berbagai macam perlombaan, pertunjukan, dan juga bazar makanan khas Jepang yang sangat lezat.</p>
<br>
<p>Kegiatan diawali dengan sambutan dari Ketua UKM dan dilanjutkan dengan penampilan tarian tradisional Jepang, Soran Bushi. Suasana sangat meriah karena antusiasme peserta yang luar biasa. Selain itu, ada juga pojok kaligrafi (Shodo) di mana para pengunjung bisa mencoba menulis nama mereka menggunakan huruf kanji.</p>
<br>
<p>Semoga kegiatan seperti ini bisa terus dilaksanakan setiap tahun dan semakin mempererat tali persaudaraan antar anggota. Sampai jumpa di kegiatan Nihongo Bu selanjutnya!</p>';

// Hapus artikel lama dengan judul yang sama (bila ada)
Article::where('title', $title)->delete();

$article = Article::create([
    'title' => $title,
    'slug' => Str::slug($title) . '-' . time(),
    'content' => $content,
    'category_id' => $subCategoryTerbaru->id, // Dimasukkan ke subkategori 'Kegiatan Terbaru'
    'user_id' => $user->id,
    'type' => 'umum', 
    'status' => 'published',
    'view_count' => rand(10, 100),
]);

echo "Artikel dummy kegiatan berhasil dipindahkan ke subkategori 'Kegiatan Terbaru'!\nJudul: {$article->title}\nSilakan cek di halaman Kegiatan.";
