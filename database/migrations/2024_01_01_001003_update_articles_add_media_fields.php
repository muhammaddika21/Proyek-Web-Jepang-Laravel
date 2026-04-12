<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Ganti jlpt_level ke kemahiran_level (pemula/menengah/mahir)
            $table->dropColumn('jlpt_level');
            $table->enum('kemahiran_level', ['pemula', 'menengah', 'mahir'])
                  ->nullable()
                  ->after('romaji_title');

            // Media tambahan
            $table->json('additional_images')->nullable()->after('cover_image_caption');
            $table->string('audio_file')->nullable()->after('additional_images');
            $table->string('audio_label')->nullable()->after('audio_file');
            $table->string('youtube_url')->nullable()->after('audio_label');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['kemahiran_level', 'additional_images', 'audio_file', 'audio_label']);
            $table->integer('jlpt_level')->nullable()->after('romaji_title');
        });
    }
};
