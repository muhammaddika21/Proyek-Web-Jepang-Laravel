<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganisasiSeeder extends Seeder
{
    public function run(): void
    {
        // Pengurus Inti — 4 jabatan
        DB::table('pengurus_inti')->insert([
            ['jabatan' => 'Ketua', 'nama' => 'Nama Ketua', 'nim' => '222XXXXX', 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['jabatan' => 'Wakil Ketua', 'nama' => 'Nama Wakil Ketua', 'nim' => '222XXXXX', 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['jabatan' => 'Sekretaris', 'nama' => 'Nama Sekretaris', 'nim' => '222XXXXX', 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
            ['jabatan' => 'Bendahara', 'nama' => 'Nama Bendahara', 'nim' => '222XXXXX', 'foto' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);


        // Divisi
        DB::table('divisi')->insert([
            ['nama' => 'Divisi Bahasa', 'slug' => 'bahasa', 'deskripsi' => 'Bertanggung jawab atas pembelajaran bahasa Jepang.', 'urutan' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Divisi Budaya', 'slug' => 'budaya', 'deskripsi' => 'Bertanggung jawab atas kegiatan budaya Jepang.', 'urutan' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Divisi HPD', 'slug' => 'hpd', 'deskripsi' => 'Humas, Publikasi, dan Dokumentasi.', 'urutan' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Ketua tiap divisi (ambil divisi IDs)
        $bahasa = DB::table('divisi')->where('slug', 'bahasa')->value('id');
        $budaya = DB::table('divisi')->where('slug', 'budaya')->value('id');
        $hpd    = DB::table('divisi')->where('slug', 'hpd')->value('id');

        DB::table('anggota_divisi')->insert([
            ['divisi_id' => $bahasa, 'nama' => 'Ketua Divisi Bahasa', 'nim' => '222XXXXX', 'jabatan' => 'Ketua Divisi', 'urutan' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['divisi_id' => $budaya, 'nama' => 'Ketua Divisi Budaya', 'nim' => '222XXXXX', 'jabatan' => 'Ketua Divisi', 'urutan' => 0, 'created_at' => now(), 'updated_at' => now()],
            ['divisi_id' => $hpd,    'nama' => 'Ketua Divisi HPD',   'nim' => '222XXXXX', 'jabatan' => 'Ketua Divisi', 'urutan' => 0, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
