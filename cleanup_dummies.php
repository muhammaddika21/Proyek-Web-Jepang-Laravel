<?php

use App\Models\Article;
use App\Models\Category;

// 1. Hapus Artikel Dummy
$titles = [
    'Serunya Bunkasai (Festival Budaya Jepang) Tahun Ini!',
    'Mengenal Chado: Upacara Minum Teh Khas Jepang'
];

$articlesDeleted = Article::whereIn('title', $titles)->delete();
echo "Berhasil menghapus {$articlesDeleted} artikel dummy.\n";

// 2. Hapus Kategori Dummy yang salah tipe (yang muncul di menu Bahasa)
// Karena saat dibuat script sebelumnya lupa diset type = 'umum', defaultnya mungkin jadi 'bahasa'
$categorySlugs = ['kegiatan-terbaru', 'tradisional', 'festival'];

$categoriesDeleted = Category::whereIn('slug', $categorySlugs)->delete();
echo "Berhasil menghapus {$categoriesDeleted} subkategori dummy.\n";

echo "\nSelesai! Database sudah bersih dari data dummy yang salah tempat.";
