@extends('layouts.app')

@section('title', $article->title)

@push('styles')
<style>
    .jp-text { font-family: 'Noto Sans JP', sans-serif; font-size: 110%; }

    /* Quiz styles */
    .quiz-option { transition: all 0.25s ease; cursor: pointer; }
    .quiz-option:hover:not(.quiz-locked) { border-color: #E76F51; background-color: rgba(231,111,81,0.05); transform: translateY(-1px); }
    .quiz-option.selected { border-color: #E76F51; background-color: rgba(231,111,81,0.08); box-shadow: 0 0 0 3px rgba(231,111,81,0.12); }
    .quiz-option.correct { border-color: #22c55e !important; background-color: rgba(34,197,94,0.08) !important; }
    .quiz-option.wrong { border-color: #ef4444 !important; background-color: rgba(239,68,68,0.06) !important; }
    .quiz-locked { pointer-events: none; }

    /* ===== VOCAB TABLE — MINIMALIST MODERN ===== */
    .vocab-table-wrapper { border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb; box-shadow: 0 1px 3px rgba(0,0,0,0.05); background: #fff; }
    .vocab-table-header { background: #fafafa; padding: 16px 20px; border-bottom: 1px solid #e5e7eb; }
    .vocab-table-header h3 { color: #111827 !important; font-size: 1.05rem !important; margin-bottom: 2px; }
    .vocab-table-header p { color: #6b7280 !important; }
    .vocab-table-header .material-symbols-outlined { color: #10b981 !important; font-size: 1.1rem; }
    .vocab-table { width: 100%; border-collapse: collapse; }
    .vocab-table thead { background: #ffffff; }
    .vocab-table th { font-family: 'Inter', sans-serif; padding: 14px 20px; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280; border-bottom: 1px solid #e5e7eb; text-align: left; }
    .vocab-table td { padding: 16px 20px; font-size: 0.95rem; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
    .vocab-table tbody tr { transition: background 0.15s ease; }
    .vocab-table tbody tr:hover { background: #f9fafb; }
    .vocab-table tbody tr:last-child td { border-bottom: none; }
    .vocab-table td.jp-col { font-family: 'Noto Sans JP', sans-serif; font-weight: 500; font-size: 1.25em; color: #111827; }
    .vocab-table td.romaji-col { color: #6b7280; font-size: 0.9rem; }
    .vocab-table td.arti-col { color: #374151; font-weight: 500; }
    .vocab-table td.contoh-col { font-family: 'Noto Sans JP', sans-serif; color: #4b5563; font-size: 0.9rem; line-height: 1.5; }

    /* Article layout */
    .article-main { max-width: 1280px; width: 100%; }
    .article-content-col { width: 100%; }
    .article-sidebar-col { width: 300px; flex-shrink: 0; }
    @media (min-width: 1024px) { .article-content-col { flex: 1; min-width: 0; } }
    @media (max-width: 1023px) { .article-sidebar-col { width: 100%; } }
    @media (max-width: 768px) {
        .vocab-table th, .vocab-table td { padding: 10px 8px; }
        .vocab-table td { font-size: 0.85rem; }
        .vocab-table td.jp-col { font-size: 1rem; line-height: 1.3; }
        .vocab-table td.romaji-col { font-size: 0.8rem; }
        .vocab-table td.contoh-col { font-size: 0.8rem; line-height: 1.4; }
        .vocab-table th { font-size: 0.65rem; }
        
        /* Adjust column widths for mobile */
        .vocab-table th:nth-child(1) { width: 22% !important; }
        .vocab-table th:nth-child(2) { width: 23% !important; }
        .vocab-table th:nth-child(3) { width: 25% !important; }
        .vocab-table th:nth-child(4) { width: 30% !important; }
    }

    /* Quiz warning */
    .quiz-warning { animation: shake 0.45s cubic-bezier(.36,.07,.19,.97) both; }
    @keyframes shake { 0%,100%{transform:translateX(0)} 15%{transform:translateX(-7px)} 30%{transform:translateX(7px)} 45%{transform:translateX(-5px)} 60%{transform:translateX(5px)} 75%{transform:translateX(-3px)} 90%{transform:translateX(3px)} }
    .prose.prose-wide { max-width: none; }
</style>
@endpush

@section('content')

{{-- Sub-hero Header --}}
<header class="relative w-full min-h-[280px] md:min-h-[320px] overflow-hidden flex items-end pb-10 px-6 md:px-16"
    style="background-color: #fdf0ec;">
    @if($article->cover_image)
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}"
                class="w-full h-full object-cover opacity-35 blur-sm scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-[#f8f7ef] to-transparent"></div>
        </div>
    @else
        <div class="absolute inset-0 z-0 bg-gradient-to-br from-[#fdf0ec] to-[#f0e0d8]">
            <div class="absolute inset-0 bg-gradient-to-t from-[#f8f7ef] to-transparent"></div>
        </div>
    @endif
    <div class="relative z-10 max-w-5xl mx-auto w-full flex flex-col items-center text-center gap-3">
        <div class="flex items-center gap-3 flex-wrap justify-center hero-sub-slide">
            @if($article->category)
                <span class="px-3 py-1 rounded-full bg-[#E76F51]/10 text-[#E76F51] text-xs font-medium tracking-wide">
                    {{ $article->category->name }}
                </span>
            @endif
        </div>
        <h1 class="text-3xl md:text-4xl lg:text-5xl text-gray-900 leading-tight max-w-3xl hero-title-slide" style="font-family: 'Zen Kurenaido', serif;">
            {{ $article->title }}
        </h1>
        <div class="flex items-center gap-4 text-sm text-gray-500 mt-2 justify-center hero-sub-slide">
            @if($article->user)
                <span>Oleh {{ $article->user->name ?? 'Admin' }}</span>
            @endif
            @if($article->read_time)
                <span>• {{ $article->read_time }} min baca</span>
            @endif
            <span>• {{ $article->published_at ? $article->published_at->translatedFormat('d F Y') : $article->created_at->translatedFormat('d F Y') }}</span>
        </div>
    </div>
</header>

{{-- Main Content — centered & wider --}}
<main class="flex-grow w-full article-main mx-auto px-4 md:px-10 xl:px-16 py-12 flex flex-col lg:flex-row gap-12">

    {{-- Left: Article Content --}}
    <article class="article-content-col space-y-10">

        @php
            $audioHtml = '';
            $youtubeHtml = '';
            $quizHtml = '';
        @endphp

        {{-- Pre-render Audio --}}
        @if($article->audio_file)
            @php ob_start(); @endphp
            <div class="bg-gray-50 rounded-xl p-5 my-8 flex items-start gap-4 not-prose border border-gray-100 hover:bg-gray-100/50 transition-colors">
                <button onclick="this.closest('div').querySelector('audio').play()" class="mt-1 flex-shrink-0 w-10 h-10 rounded-full bg-[#E76F51] text-white flex items-center justify-center hover:bg-[#c5533b] transition-colors">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">play_arrow</span>
                </button>
                <div class="flex-grow w-full">
                    <p class="font-medium text-gray-800 mb-2">{{ $article->audio_label ?: 'Dengarkan Audio' }}</p>
                    <audio controls class="w-full h-10">
                        <source src="{{ asset('storage/' . $article->audio_file) }}" type="audio/mpeg">
                    </audio>
                </div>
            </div>
            @php $audioHtml = ob_get_clean(); @endphp
        @endif

        {{-- Pre-render YouTube --}}
        @if($article->youtube_url)
            @php
                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $article->youtube_url, $matches);
                $videoId = $matches[1] ?? null;
            @endphp
            @if($videoId)
                @php ob_start(); @endphp
                <div class="my-8 rounded-2xl overflow-hidden shadow-lg border border-gray-100 relative pt-[56.25%] not-prose">
                    <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                @php $youtubeHtml = ob_get_clean(); @endphp
            @endif
        @endif

        {{-- Pre-render Vocabulary Tables --}}
        @php
            $vocabTablesHtml = [];
            $allVocabHtml = '';
        @endphp
        @if($article->vocabulary_list && count($article->vocabulary_list) > 0)
            @php
                $vocabData = $article->vocabulary_list;
                $firstItem = reset($vocabData);
                $isGrouped = isset($firstItem['rows']);
                if (!$isGrouped) { $vocabData = [['title' => '', 'rows' => $vocabData]]; }
            @endphp
            @foreach($vocabData as $tIndex => $table)
                @php ob_start(); @endphp
                <div class="my-10 not-prose">
                    <div class="vocab-table-wrapper">
                        <div class="vocab-table-header">
                            <h3 class="text-lg font-bold flex items-center gap-2" style="font-family: 'Noto Sans JP', sans-serif;">
                                <span class="material-symbols-outlined">menu_book</span>
                                @if(!empty($table['title'])) {{ $table['title'] }}
                                @else Daftar Kosakata{{ count($vocabData) > 1 ? ' #' . ($tIndex + 1) : '' }}
                                @endif
                            </h3>
                            <p class="text-xs mt-1">{{ count($table['rows']) }} entri kosakata</p>
                        </div>
                        <div class="overflow-x-auto bg-white">
                            <table class="w-full text-left vocab-table">
                                <thead><tr>
                                    <th style="width:18%;">Kanji / Kata</th>
                                    <th style="width:20%;">Romaji</th>
                                    <th style="width:28%;">Arti</th>
                                    <th style="width:34%;">Contoh</th>
                                </tr></thead>
                                <tbody>
                                    @foreach($table['rows'] as $vocab)
                                        <tr>
                                            <td class="jp-col">{{ $vocab['kata'] ?? $vocab['word'] ?? '-' }}</td>
                                            <td class="romaji-col">{{ $vocab['romaji'] ?? '-' }}</td>
                                            <td class="arti-col">{{ $vocab['arti'] ?? $vocab['meaning'] ?? '-' }}</td>
                                            <td class="contoh-col">{{ $vocab['contoh'] ?? $vocab['example'] ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @php $vocabTablesHtml[$tIndex] = ob_get_clean(); @endphp
            @endforeach
            @php $allVocabHtml = implode('', $vocabTablesHtml); @endphp
        @endif

        {{-- Pre-render Interactive Quiz --}}
        @if($article->quiz_questions && count($article->quiz_questions) > 0)
            @php ob_start(); @endphp
            <div class="my-12 not-prose"
                x-data="{
                    quizzes: {{ json_encode(collect($article->quiz_questions)->map(function($q, $i) {
                        return [
                            'question' => $q['question'] ?? '',
                            'options' => is_string($q['options'] ?? '') ? array_map('trim', explode(',', $q['options'])) : ($q['options'] ?? []),
                            'answer' => (int)($q['answer'] ?? 0),
                            'selected' => null,
                            'checked' => false,
                        ];
                    })->values()) }},
                    totalCorrect: 0, totalChecked: 0, allChecked: false, showWarning: false, warningMessage: '',
                    selectOption(qIdx, oIdx) { if (this.quizzes[qIdx].checked) return; this.quizzes[qIdx].selected = oIdx; this.showWarning = false; },
                    allAnswered() { return this.quizzes.every(q => q.selected !== null); },
                    unansweredCount() { return this.quizzes.filter(q => q.selected === null).length; },
                    checkAll() {
                        if (!this.allAnswered()) {
                            const count = this.unansweredCount();
                            this.warningMessage = 'Harap jawab ' + count + ' soal yang belum dijawab terlebih dahulu!';
                            this.showWarning = true;
                            const firstIdx = this.quizzes.findIndex(q => q.selected === null);
                            if (firstIdx >= 0) { const el = document.getElementById('quiz-q-' + firstIdx); if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' }); }
                            return;
                        }
                        this.showWarning = false; this.totalCorrect = 0; this.totalChecked = 0;
                        this.quizzes.forEach(q => { q.checked = true; this.totalChecked++; if (q.selected === q.answer) this.totalCorrect++; });
                        this.allChecked = true;
                    },
                    resetAll() { this.quizzes.forEach(q => { q.selected = null; q.checked = false; }); this.totalCorrect = 0; this.totalChecked = 0; this.allChecked = false; this.showWarning = false; },
                    isCorrect(qIdx) { return this.quizzes[qIdx].selected === this.quizzes[qIdx].answer; },
                    optionClass(qIdx, oIdx) { let q = this.quizzes[qIdx]; if (!q.checked) { return q.selected === oIdx ? 'selected' : ''; } if (oIdx === q.answer) return 'correct'; if (q.selected === oIdx && oIdx !== q.answer) return 'wrong'; return 'quiz-locked'; }
                }">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8">
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                        <h3 class="text-2xl text-gray-800" style="font-family: 'Sawarabi Mincho', serif;">Latihan Soal</h3>
                        <span class="px-3 py-1 bg-gray-100 text-[#E76F51] font-semibold text-sm rounded-full" x-text="'Skor: ' + totalCorrect + '/' + quizzes.length"></span>
                    </div>
                    <div x-show="showWarning" x-transition class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-center gap-3 quiz-warning">
                        <span class="material-symbols-outlined text-amber-500">warning</span>
                        <p class="text-amber-800 text-sm font-medium" x-text="warningMessage"></p>
                    </div>
                    <div class="space-y-8">
                        <template x-for="(quiz, qIdx) in quizzes" :key="qIdx">
                            <div class="space-y-4" :id="'quiz-q-' + qIdx">
                                <p class="text-lg text-gray-800 font-medium" x-text="(qIdx + 1) + '. ' + quiz.question"></p>
                                <div x-show="showWarning && quiz.selected === null" class="text-xs text-amber-600 font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">error</span> Belum dijawab
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <template x-for="(option, oIdx) in quiz.options" :key="oIdx">
                                        <button type="button" @click="selectOption(qIdx, oIdx)"
                                            class="quiz-option py-3 px-5 rounded-xl border border-gray-200 bg-white text-left text-gray-700 text-base transition-all flex items-center gap-3"
                                            :class="[optionClass(qIdx, oIdx), quiz.checked ? 'quiz-locked' : '', (showWarning && quiz.selected === null) ? 'border-amber-300' : '']">
                                            <span class="w-7 h-7 rounded-full border-2 flex items-center justify-center text-xs font-bold flex-shrink-0 transition-all"
                                                :class="quiz.selected === oIdx ? (quiz.checked ? (oIdx === quiz.answer ? 'bg-green-500 border-green-500 text-white' : 'bg-red-500 border-red-500 text-white') : 'bg-[#E76F51] border-[#E76F51] text-white') : (quiz.checked && oIdx === quiz.answer ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 text-gray-400')"
                                                x-text="String.fromCharCode(65 + oIdx)"></span>
                                            <span x-text="option"></span>
                                        </button>
                                    </template>
                                </div>
                                <div x-show="quiz.checked" x-transition class="mt-2">
                                    <div x-show="isCorrect(qIdx)" class="p-3 bg-green-50 rounded-lg flex items-start gap-2 border border-green-200">
                                        <span class="material-symbols-outlined text-green-600 mt-0.5 text-sm">check_circle</span>
                                        <p class="text-green-800 text-sm font-medium">Benar! Jawaban yang tepat.</p>
                                    </div>
                                    <div x-show="!isCorrect(qIdx)" class="p-3 bg-red-50 rounded-lg flex items-start gap-2 border border-red-200">
                                        <span class="material-symbols-outlined text-red-600 mt-0.5 text-sm">cancel</span>
                                        <p class="text-red-800 text-sm font-medium">Salah. Jawaban yang benar adalah <strong x-text="String.fromCharCode(65 + quiz.answer)"></strong>.</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div class="mt-8 flex flex-col sm:flex-row items-center gap-4 border-t border-gray-100 pt-6">
                        <button x-show="!allChecked" @click="checkAll()" type="button"
                            class="bg-[#E76F51] hover:bg-[#c5533b] text-white font-bold py-3 px-8 rounded-full transition-colors shadow-lg shadow-[#E76F51]/20">
                            Cek Jawaban
                        </button>
                        <button x-show="allChecked" @click="resetAll()" type="button" x-transition
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-full transition-colors">
                            Ulangi Kuis
                        </button>
                        <div x-show="!allChecked" class="text-sm text-gray-400">
                            <span x-text="quizzes.filter(q => q.selected !== null).length"></span>/<span x-text="quizzes.length"></span> terjawab
                        </div>
                        <div x-show="allChecked" x-transition class="flex items-center gap-2 text-sm">
                            <template x-if="totalCorrect === quizzes.length"><span class="text-green-600 font-bold flex items-center gap-1"><span class="material-symbols-outlined text-lg">emoji_events</span> Sempurna! Semua benar!</span></template>
                            <template x-if="totalCorrect > 0 && totalCorrect < quizzes.length"><span class="text-amber-600 font-bold">Kamu menjawab benar <span x-text="totalCorrect"></span> dari <span x-text="quizzes.length"></span> soal.</span></template>
                            <template x-if="totalCorrect === 0 && allChecked"><span class="text-red-600 font-bold">Belum ada yang benar. Coba lagi!</span></template>
                        </div>
                    </div>
                </div>
            </div>
            @php $quizHtml = ob_get_clean(); @endphp
        @endif

        {{-- Pre-render Individual Images --}}
        @php
            $individualImageHtml = [];
            $galleryHtml = '';
        @endphp
        @if($article->additional_images && count($article->additional_images) > 0)
            @foreach($article->additional_images as $imgIndex => $img)
                @php ob_start(); @endphp
                <figure class="my-8 not-prose">
                    <img src="{{ asset('storage/' . $img) }}" class="rounded-2xl w-full max-h-[500px] object-cover border border-gray-200 shadow-sm" alt="Gambar {{ $imgIndex + 1 }}">
                </figure>
                @php $individualImageHtml[$imgIndex] = ob_get_clean(); @endphp
            @endforeach

            @php ob_start(); @endphp
            <div class="my-10 not-prose">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#E76F51]">photo_library</span> Galeri Foto
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($article->additional_images as $img)
                        <img src="{{ asset('storage/' . $img) }}" class="rounded-xl w-full aspect-square object-cover border border-gray-200 shadow-sm hover:shadow-md transition-shadow cursor-pointer" alt="Galeri">
                    @endforeach
                </div>
            </div>
            @php $galleryHtml = ob_get_clean(); @endphp
        @endif

        @php
            $rawContent = $article->content ?? '';
            $parsedContent = $rawContent;

            $hasAnyGambar = false;
            foreach ($individualImageHtml as $idx => $html) {
                $num = $idx + 1;
                $tag = "[gambar{$num}]";
                if (str_contains($parsedContent, $tag)) {
                    $hasAnyGambar = true;
                    $parsedContent = str_replace("<p>{$tag}</p>", $html, $parsedContent);
                    $parsedContent = str_replace("<p>{$tag} </p>", $html, $parsedContent);
                    $parsedContent = str_replace("<p> {$tag}</p>", $html, $parsedContent);
                    $parsedContent = str_replace("<p> {$tag} </p>", $html, $parsedContent);
                    $parsedContent = str_replace($tag, $html, $parsedContent);
                }
            }

            $hasAnyNumberedVocab = false;
            foreach (($vocabTablesHtml ?? []) as $idx => $html) {
                $num = $idx + 1;
                $tag = "[vocab{$num}]";
                if (str_contains($parsedContent, $tag)) {
                    $hasAnyNumberedVocab = true;
                    $parsedContent = str_replace("<p>{$tag}</p>", $html, $parsedContent);
                    $parsedContent = str_replace($tag, $html, $parsedContent);
                }
            }

            $hasAudio   = str_contains($parsedContent, '[audio]');
            $hasYoutube = str_contains($parsedContent, '[youtube]');
            $hasVocab   = str_contains($parsedContent, '[vocab]');
            $hasQuiz    = str_contains($parsedContent, '[quiz]');
            $hasGallery = str_contains($parsedContent, '[gallery]');

            if ($hasAudio) { $parsedContent = str_replace(['<p>[audio]</p>','[audio]'], $audioHtml, $parsedContent); }
            if ($hasYoutube) { $parsedContent = str_replace(['<p>[youtube]</p>','[youtube]'], $youtubeHtml, $parsedContent); }
            if ($hasVocab) { $parsedContent = str_replace(['<p>[vocab]</p>','[vocab]'], $allVocabHtml ?? '', $parsedContent); }
            if ($hasQuiz) { $parsedContent = str_replace(['<p>[quiz]</p>','[quiz]'], $quizHtml, $parsedContent); }
            if ($hasGallery) { $parsedContent = str_replace(['<p>[gallery]</p>','[gallery]'], $galleryHtml, $parsedContent); }
        @endphp

        @if(!$hasAudio && $audioHtml) {!! $audioHtml !!} @endif
        @if(!$hasYoutube && $youtubeHtml) {!! $youtubeHtml !!} @endif

        <div class="prose prose-wide prose-lg prose-slate max-w-none leading-relaxed text-gray-700
            prose-headings:text-gray-900 prose-headings:font-bold
            prose-a:text-[#E76F51] prose-a:underline prose-a:decoration-[#E76F51]/30
            prose-strong:text-gray-900 prose-blockquote:border-l-4 prose-blockquote:border-[#E76F51]/30
            prose-li:marker:text-[#E76F51]">
            {!! $parsedContent !!}
        </div>

        @if(!$hasVocab && !($hasAnyNumberedVocab ?? false) && !empty($allVocabHtml)) {!! $allVocabHtml !!} @endif
        @if(!$hasQuiz && $quizHtml) {!! $quizHtml !!} @endif
        @if(!$hasGallery && !$hasAnyGambar && $galleryHtml) {!! $galleryHtml !!} @endif

    </article>

    {{-- Right Sidebar --}}
    <aside class="article-sidebar-col hidden lg:block">
        <div class="sticky top-28 space-y-6">
            <a href="{{ route('kegiatan.index') }}"
                class="flex items-center gap-2 text-sm text-[#E76F51] hover:text-[#c5533b] font-medium transition-colors mb-2">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Kembali ke Daftar Kegiatan
            </a>

            {{-- Article Info --}}
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Info Artikel</h4>
                <div class="space-y-3 text-sm">
                    @if($article->category)
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-[#E76F51]/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#E76F51] text-base">category</span>
                        </span>
                        <div>
                            <span class="text-gray-400 text-xs">Kategori</span>
                            <p class="text-gray-800 font-semibold text-sm">{{ $article->category->name }}</p>
                        </div>
                    </div>
                    @endif
                    @if($article->read_time)
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-[#E76F51]/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#E76F51] text-base">schedule</span>
                        </span>
                        <div>
                            <span class="text-gray-400 text-xs">Waktu Baca</span>
                            <p class="text-gray-800 font-semibold text-sm">{{ $article->read_time }} menit</p>
                        </div>
                    </div>
                    @endif
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-[#E76F51]/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#E76F51] text-base">calendar_today</span>
                        </span>
                        <div>
                            <span class="text-gray-400 text-xs">Tanggal</span>
                            <p class="text-gray-800 font-semibold text-sm">{{ $article->published_at ? $article->published_at->translatedFormat('d M Y') : $article->created_at->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tips --}}
            <div class="bg-[#E76F51]/5 rounded-xl p-5 border border-[#E76F51]/10">
                <h4 class="text-xs font-semibold text-[#E76F51] uppercase tracking-widest mb-3 flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base">lightbulb</span> Tips Kegiatan
                </h4>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-[#E76F51] text-sm mt-0.5">check_circle</span>
                        <span>Catat jadwal dan lokasi kegiatan</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-[#E76F51] text-sm mt-0.5">check_circle</span>
                        <span>Ikuti dan bagikan ke teman UKM</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-[#E76F51] text-sm mt-0.5">check_circle</span>
                        <span>Dokumentasikan pengalamanmu!</span>
                    </li>
                </ul>
            </div>
        </div>
    </aside>
</main>

{{-- Prev/Next Navigation --}}
@if(isset($prevArticle) || isset($nextArticle))
<div class="w-full py-12 border-t border-gray-200/50 bg-transparent">
    <div class="max-w-5xl mx-auto px-4 md:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
        @if(isset($prevArticle) && $prevArticle)
        <a href="{{ route('kegiatan.show', $prevArticle->slug) }}" class="w-full md:w-[45%] flex items-center gap-4 p-4 rounded-xl hover:bg-white transition-colors group">
            <div class="w-14 h-14 rounded-lg bg-gray-200 overflow-hidden shrink-0">
                @if($prevArticle->cover_image)
                    <img src="{{ asset('storage/' . $prevArticle->cover_image) }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity" alt="">
                @endif
            </div>
            <div>
                <span class="text-xs text-gray-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">arrow_back</span> Sebelumnya
                </span>
                <h4 class="text-base text-gray-800 group-hover:text-[#E76F51] transition-colors" style="font-family: 'Sawarabi Mincho', serif;">{{ $prevArticle->title }}</h4>
            </div>
        </a>
        @else
            <div class="w-full md:w-[45%]"></div>
        @endif
        @if(isset($nextArticle) && $nextArticle)
        <a href="{{ route('kegiatan.show', $nextArticle->slug) }}" class="w-full md:w-[45%] flex items-center justify-end gap-4 p-4 rounded-xl hover:bg-white transition-colors group text-right">
            <div>
                <span class="text-xs text-gray-400 uppercase tracking-wider mb-1 flex items-center justify-end gap-1">
                    Berikutnya <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </span>
                <h4 class="text-base text-gray-800 group-hover:text-[#E76F51] transition-colors" style="font-family: 'Sawarabi Mincho', serif;">{{ $nextArticle->title }}</h4>
            </div>
            <div class="w-14 h-14 rounded-lg bg-gray-200 overflow-hidden shrink-0">
                @if($nextArticle->cover_image)
                    <img src="{{ asset('storage/' . $nextArticle->cover_image) }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity" alt="">
                @endif
            </div>
        </a>
        @endif
    </div>
</div>
@endif

@endsection
