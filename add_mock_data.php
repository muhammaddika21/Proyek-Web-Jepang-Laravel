<?php

$bahasa = App\Models\Divisi::where('slug', 'bahasa')->first();
$budaya = App\Models\Divisi::where('slug', 'budaya')->first();

if ($bahasa) {
    $bahasa->anggota()->createMany([
        ['nama' => 'Nakajima Yuto', 'nim' => '22210101', 'jabatan' => 'Anggota', 'urutan' => 1],
        ['nama' => 'Yamada Ryosuke', 'nim' => '22210102', 'jabatan' => 'Anggota', 'urutan' => 2],
        ['nama' => 'Chinen Yuri', 'nim' => '22210103', 'jabatan' => 'Anggota', 'urutan' => 3],
    ]);
    echo "Ditambahkan 3 anggota ke Divisi Bahasa\n";
}

if ($budaya) {
    $budaya->anggota()->createMany([
        ['nama' => 'Hashimoto Kanna', 'nim' => '22210201', 'jabatan' => 'Anggota', 'urutan' => 1],
        ['nama' => 'Hamabe Minami', 'nim' => '22210202', 'jabatan' => 'Anggota', 'urutan' => 2],
    ]);
    echo "Ditambahkan 2 anggota ke Divisi Budaya\n";
}

echo "Selesai!";
