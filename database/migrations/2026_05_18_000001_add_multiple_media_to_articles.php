<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // Multiple audio files (JSON array of paths)
            $table->json('audio_files')->nullable()->after('audio_label');
            // Multiple video files (JSON array of paths)
            $table->json('video_files')->nullable()->after('audio_files');
            // Multiple YouTube URLs (JSON array of URLs)
            $table->json('youtube_urls')->nullable()->after('video_files');
        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['audio_files', 'video_files', 'youtube_urls']);
        });
    }
};
