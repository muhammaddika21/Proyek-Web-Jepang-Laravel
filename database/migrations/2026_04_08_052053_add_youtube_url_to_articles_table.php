<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom-kolom media yang hilang di tabel articles.
     */
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Kita gunakan Schema::hasColumn untuk mengecek satu per satu
            // Dan kita hapus ->after(...) agar tidak error jika kolom referensinya tidak ada
            
            if (!Schema::hasColumn('articles', 'additional_images')) {
                $table->json('additional_images')->nullable();
            }

            if (!Schema::hasColumn('articles', 'audio_file')) {
                $table->string('audio_file')->nullable();
            }

            if (!Schema::hasColumn('articles', 'audio_label')) {
                $table->string('audio_label')->nullable();
            }

            if (!Schema::hasColumn('articles', 'youtube_url')) {
                $table->string('youtube_url')->nullable();
            }

            if (!Schema::hasColumn('articles', 'kemahiran_level')) {
                $table->enum('kemahiran_level', ['pemula', 'menengah', 'mahir'])->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $columns = ['additional_images', 'audio_file', 'audio_label', 'youtube_url', 'kemahiran_level'];
            foreach ($columns as $col) {
                if (Schema::hasColumn('articles', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
