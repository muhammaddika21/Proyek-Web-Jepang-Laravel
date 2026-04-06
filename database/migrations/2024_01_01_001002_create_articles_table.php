<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            // Info Dasar
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['umum', 'bahasa'])->default('umum');
            $table->text('excerpt')->nullable();              // Ringkasan singkat
            $table->longText('content')->nullable();          // Konten artikel umum (HTML/Rich text)
            $table->string('cover_image')->nullable();        // Path foto sampul
            $table->string('cover_image_caption')->nullable();

            // Field khusus Artikel Bahasa (type='bahasa')
            $table->string('japanese_title')->nullable();     // Judul dalam huruf Jepang
            $table->string('romaji_title')->nullable();       // Judul dalam romaji
            $table->integer('jlpt_level')->nullable();        // 1-5 (N5=1, N1=5)
            $table->longText('grammar_explanation')->nullable(); // Penjelasan grammar
            $table->json('vocabulary_list')->nullable();      // [{"kata":"私","romaji":"watashi","arti":"saya"}]
            $table->json('quiz_questions')->nullable();       // [{question, options, answer}]

            // Meta
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->integer('read_time')->nullable();         // Estimasi menit baca
            $table->integer('view_count')->default(0);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
