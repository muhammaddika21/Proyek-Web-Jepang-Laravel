<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel pengurus inti (Ketua & Wakil — selalu hanya 2 baris)
        Schema::create('pengurus_inti', function (Blueprint $table) {
            $table->id();
            $table->string('jabatan'); // 'Ketua' atau 'Wakil Ketua'
            $table->string('nama');
            $table->string('nim')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // Tabel divisi (Bahasa, Budaya, HPD — struktur tetap)
        Schema::create('divisi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');       // Nama divisi
            $table->string('slug');       // bahasa, budaya, hpd
            $table->string('deskripsi')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Tabel anggota divisi
        Schema::create('anggota_divisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('divisi_id')->constrained('divisi')->onDelete('cascade');
            $table->string('nama');
            $table->string('nim')->nullable();
            $table->string('jabatan')->default('Anggota'); // 'Ketua Divisi' atau 'Anggota'
            $table->string('foto')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_divisi');
        Schema::dropIfExists('divisi');
        Schema::dropIfExists('pengurus_inti');
    }
};
