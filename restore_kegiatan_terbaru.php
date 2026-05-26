<?php

use App\Models\Category;

// 1. Cari kategori parent "Kegiatan"
$parentKegiatan = Category::where('slug', 'kegiatan')->first();

if (!$parentKegiatan) {
    $parentKegiatan = Category::create([
        'name' => 'Kegiatan UKM',
        'slug' => 'kegiatan',
        'type' => 'umum',
    ]);
}

// 2. Buat subkategori "Kegiatan Terbaru" dengan type 'umum' (bukan 'bahasa')
$subCategoryTerbaru = Category::firstOrCreate(
    ['slug' => 'kegiatan-terbaru', 'parent_id' => $parentKegiatan->id],
    [
        'name' => 'Kegiatan Terbaru', 
        'parent_id' => $parentKegiatan->id,
        'type' => 'umum' // PASTIKAN TYPE ADALAH UMUM AGAR TIDAK NYASAR KE BAHASA
    ]
);

// Jika sudah ada sebelumnya tapi type-nya salah, kita update
$subCategoryTerbaru->update(['type' => 'umum']);

echo "Subkategori 'Kegiatan Terbaru' berhasil dikembalikan dengan tipe yang benar (Umum).\nSilakan cek halaman Kegiatan.";
