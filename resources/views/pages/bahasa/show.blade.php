@extends('layouts.app')

@section('title', $article->title)

@push('styles')
<link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
<style>
    :root {
        --plyr-color-main: #2D6A4F;
    }
    .jp-text { font-family: 'Noto Sans JP', sans-serif; font-size: 110%; }

    /* Quiz styles */
    .quiz-option { transition: all 0.25s ease; cursor: pointer; }
    .quiz-option:hover:not(.quiz-locked) { border-color: #2D6A4F; background-color: rgba(45,106,79,0.05); transform: translateY(-1px); }
    .quiz-option.selected { border-color: #2D6A4F; background-color: rgba(45,106,79,0.08); box-shadow: 0 0 0 3px rgba(45,106,79,0.12); }
    .quiz-option.correct { border-color: #22c55e !important; background-color: rgba(34,197,94,0.08) !important; }
    .quiz-option.wrong { border-color: #ef4444 !important; background-color: rgba(239,68,68,0.06) !important; }
    .quiz-locked { pointer-events: none; }

    /* ===== VOCAB TABLE — MINIMALIST MODERN ===== */
    .vocab-table-wrapper {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        background: #fff;
    }
    .vocab-table-header {
        background: #fafafa;
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
    }
    .vocab-table-header h3 { 
        color: #111827 !important; 
        font-size: 1.05rem !important;
        margin-bottom: 2px;
    }
    .vocab-table-header p { 
        color: #6b7280 !important; 
    }
    .vocab-table-header .material-symbols-outlined { color: #10b981 !important; font-size: 1.1rem; }
    .vocab-table { width: 100%; border-collapse: collapse; }
    .vocab-table thead { background: #ffffff; }
    .vocab-table th {
        font-family: 'Inter', sans-serif;
        padding: 14px 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6b7280;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
    }
    .vocab-table td {
        padding: 16px 20px;
        font-size: 0.95rem;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }
    .vocab-table tbody tr { transition: background 0.15s ease; }
    .vocab-table tbody tr:hover { background: #f9fafb; }
    .vocab-table tbody tr:last-child td { border-bottom: none; }
    .vocab-table td.jp-col {
        font-family: 'Noto Sans JP', sans-serif;
        font-weight: 500;
        font-size: 1.25em;
        color: #111827;
    }
    .vocab-table td.romaji-col {
        color: #6b7280;
        font-size: 0.9rem;
    }
    .vocab-table td.arti-col {
        color: #374151;
        font-weight: 500;
    }
    .vocab-table td.contoh-col {
        font-family: 'Noto Sans JP', sans-serif;
        color: #4b5563;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    /* ===== ARTICLE LAYOUT — WIDER + CENTERED ===== */
    .article-main {
        max-width: 1280px;
        width: 100%;
    }
    .article-content-col { width: 100%; }
    .article-sidebar-col { width: 300px; flex-shrink: 0; }
    @media (min-width: 1024px) {
        .article-content-col { flex: 1; min-width: 0; }
    }
    @media (max-width: 1023px) {
        .article-sidebar-col { width: 100%; }
    }
    @media (max-width: 768px) {
        .vocab-table th, .vocab-table td { padding: 10px 8px; }
        .vocab-table td { font-size: 0.85rem; }
        .vocab-table td.jp-col { font-size: 1rem; line-height: 1.3; }
        .vocab-table td.romaji-col { font-size: 0.8rem; }
        .vocab-table td.contoh-col { font-size: 0.8rem; line-height: 1.4; }
        .vocab-table th { font-size: 0.65rem; }
        
        /* Adjust column widths for mobile */
        .vocab-table th:nth-child(1) { width: 22% !important; } /* Kanji/Kata */
        .vocab-table th:nth-child(2) { width: 23% !important; } /* Romaji */
        .vocab-table th:nth-child(3) { width: 25% !important; } /* Arti */
        .vocab-table th:nth-child(4) { width: 30% !important; } /* Contoh */
    }

    /* Quiz warning shake */
    .quiz-warning { animation: shake 0.45s cubic-bezier(.36,.07,.19,.97) both; }
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        15% { transform: translateX(-7px); }
        30% { transform: translateX(7px); }
        45% { transform: translateX(-5px); }
        60% { transform: translateX(5px); }
        75% { transform: translateX(-3px); }
        90% { transform: translateX(3px); }
    }

    /* Prose wider */
    .prose.prose-wide { max-width: none; }
</style>
@endpush

@section('content')

{{-- Sub-hero Header --}}
<header class="relative w-full min-h-[280px] md:min-h-[320px] overflow-hidden flex items-end pb-10 px-6 md:px-16"
    style="background-color: #e7eefe;">
    @if($article->cover_image)
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}"
                class="w-full h-full object-cover opacity-40 blur-sm scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-[#f8f7ef] to-transparent"></div>
        </div>
    @else
        <div class="absolute inset-0 z-0 bg-gradient-to-br from-[#e7eefe] to-[#d3daea]">
            <div class="absolute inset-0 bg-gradient-to-t from-[#f8f7ef] to-transparent"></div>
        </div>
    @endif
    <div class="relative z-10 max-w-5xl mx-auto w-full flex flex-col items-center text-center gap-3">
        <div class="flex items-center gap-3 flex-wrap justify-center">
            @if($article->kemahiran_level)
                <span class="px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide
                    {{ $article->kemahiran_level === 'pemula' ? 'bg-green-100 text-green-800' : ($article->kemahiran_level === 'menengah' ? 'bg-amber-100 text-amber-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($article->kemahiran_level) }}
                </span>
            @endif
            @if($article->category)
                <span class="px-3 py-1 rounded-full bg-gray-200/80 text-gray-700 text-xs font-medium tracking-wide">
                    {{ $article->category->name }}
                </span>
            @endif
        </div>
        <h1 class="text-3xl md:text-4xl lg:text-5xl text-gray-900 leading-tight max-w-3xl" style="font-family: 'Zen Kurenaido', serif;">
            {{ $article->title }}
        </h1>
        <div class="flex items-center gap-4 text-sm text-gray-500 mt-2 justify-center">
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

{{-- Main Content Area — centered & wider --}}
<main class="flex-grow w-full article-main mx-auto px-4 md:px-10 xl:px-16 py-12 flex flex-col lg:flex-row gap-12">

    {{-- Left Column: Article Content --}}
    <article class="article-content-col space-y-10">

        @php
            $audioHtmlArr   = [];  // indexed: $audioHtmlArr[0] = HTML for [audio1]
            $youtubeHtmlArr = []; // indexed
            $videoHtmlArr   = []; // indexed
            $audioHtml   = '';   // legacy [audio]
            $youtubeHtml = '';   // legacy [youtube]
            $quizHtml    = '';
        @endphp

        {{-- Pre-render Multiple Audios (audio_files[]) --}}
        @if($article->audio_files)
            @foreach($article->audio_files as $i => $af)
                @php ob_start(); @endphp
                <div class="my-6 not-prose rounded-2xl overflow-hidden border border-gray-100 bg-white shadow-sm hover:shadow-md transition-shadow">
                    @if($af['label'] ?? '')
                        <div class="px-4 py-2.5 bg-[#f8fcf9] border-b border-gray-100 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#2D6A4F] text-[18px]">music_note</span>
                            <p class="font-semibold text-[#1a3c2a] text-sm">{{ $af['label'] }}</p>
                        </div>
                    @endif
                    <div class="p-1">
                        <audio controls class="plyr-media w-full">
                            <source src="{{ asset('storage/' . $af['path']) }}" type="audio/mpeg">
                        </audio>
                    </div>
                </div>
                @php $audioHtmlArr[$i] = ob_get_clean(); @endphp
            @endforeach
        @endif

        {{-- Pre-render Legacy Single Audio (audio_file) --}}
        @if($article->audio_file)
            @php ob_start(); @endphp
            <div class="my-8 not-prose rounded-2xl overflow-hidden border border-gray-100 bg-white shadow-sm hover:shadow-md transition-shadow">
                <div class="px-4 py-2.5 bg-[#f8fcf9] border-b border-gray-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#2D6A4F] text-[18px]">music_note</span>
                    <p class="font-semibold text-[#1a3c2a] text-sm">{{ $article->audio_label ?: 'Dengarkan Audio' }}</p>
                </div>
                <div class="p-1">
                    <audio controls class="plyr-media w-full">
                        <source src="{{ asset('storage/' . $article->audio_file) }}" type="audio/mpeg">
                    </audio>
                </div>
            </div>
            @php $audioHtml = ob_get_clean(); @endphp
        @endif

        {{-- Pre-render Multiple Videos (video_files[]) --}}
        @if($article->video_files)
            @foreach($article->video_files as $i => $vf)
                @php ob_start(); @endphp
                <div class="my-8 not-prose rounded-2xl overflow-hidden border border-gray-100 bg-white shadow-sm hover:shadow-md transition-shadow">
                    @if($vf['label'] ?? '')
                        <div class="px-4 py-2.5 bg-[#f8fcf9] border-b border-gray-100 flex items-center gap-2">
                            <span class="material-symbols-outlined text-[#2D6A4F] text-[18px]">movie</span>
                            <p class="font-semibold text-[#1a3c2a] text-sm">{{ $vf['label'] }}</p>
                        </div>
                    @endif
                    <div class="bg-black">
                        <video controls class="plyr-media w-full">
                            <source src="{{ asset('storage/' . $vf['path']) }}" type="video/mp4">
                        </video>
                    </div>
                </div>
                @php $videoHtmlArr[$i] = ob_get_clean(); @endphp
            @endforeach
        @endif

        {{-- Pre-render Multiple YouTubes (youtube_urls[]) --}}
        @if($article->youtube_urls)
            @foreach($article->youtube_urls as $i => $ytUrl)
                @php
                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $ytUrl, $ytMatches);
                    $ytId = $ytMatches[1] ?? null;
                    ob_start();
                @endphp
                @if($ytId)
                <div class="my-8 rounded-2xl overflow-hidden shadow-lg border border-gray-100 relative pt-[56.25%] not-prose">
                    <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/{{ $ytId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                @endif
                @php $youtubeHtmlArr[$i] = ob_get_clean(); @endphp
            @endforeach
        @endif

        {{-- Pre-render Legacy Single YouTube (youtube_url) --}}
        @if($article->youtube_url && empty($article->youtube_urls))
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

        {{-- Pre-render Vocabulary Tables (multiple) — REDESIGNED --}}
        @php
            $vocabTablesHtml = [];
            $allVocabHtml = '';
        @endphp
        @if($article->vocabulary_list && count($article->vocabulary_list) > 0)
            @php
                $vocabData = $article->vocabulary_list;
                $firstItem = reset($vocabData);
                $isGrouped = isset($firstItem['rows']);
                if (!$isGrouped) {
                    $vocabData = [['title' => '', 'rows' => $vocabData]];
                }
            @endphp

            @foreach($vocabData as $tIndex => $table)
                @php ob_start(); @endphp
                <div class="my-10 not-prose">
                    <div class="vocab-table-wrapper">
                        {{-- Table Header --}}
                        <div class="vocab-table-header">
                            <h3 class="text-lg font-bold text-[#1a3c2a] flex items-center gap-2" style="font-family: 'Noto Sans JP', sans-serif;">
                                <span class="material-symbols-outlined text-[#2D6A4F]">menu_book</span>
                                @if(!empty($table['title']))
                                    {{ $table['title'] }}
                                @else
                                    Daftar Kosakata{{ count($vocabData) > 1 ? ' #' . ($tIndex + 1) : '' }}
                                @endif
                            </h3>
                            <p class="text-xs text-[#6b8f7b] mt-1">{{ count($table['rows']) }} entri kosakata</p>
                        </div>
                        {{-- Table Body --}}
                        <div class="overflow-x-auto bg-white">
                            <table class="w-full text-left vocab-table">
                                <thead>
                                    <tr>
                                        <th style="width: 18%;">Kanji / Kata</th>
                                        <th style="width: 20%;">Romaji</th>
                                        <th style="width: 28%;">Arti</th>
                                        <th style="width: 34%;">Contoh</th>
                                    </tr>
                                </thead>
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

        {{-- Pre-render Interactive Quiz — with "must answer all" logic --}}
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
                    totalCorrect: 0,
                    totalChecked: 0,
                    allChecked: false,
                    showWarning: false,
                    warningMessage: '',
                    selectOption(qIdx, oIdx) {
                        if (this.quizzes[qIdx].checked) return;
                        this.quizzes[qIdx].selected = oIdx;
                        this.showWarning = false;
                    },
                    allAnswered() {
                        return this.quizzes.every(q => q.selected !== null);
                    },
                    unansweredCount() {
                        return this.quizzes.filter(q => q.selected === null).length;
                    },
                    checkAll() {
                        if (!this.allAnswered()) {
                            const count = this.unansweredCount();
                            this.warningMessage = 'Harap jawab ' + count + ' soal yang belum dijawab terlebih dahulu!';
                            this.showWarning = true;
                            // Scroll to first unanswered
                            const firstIdx = this.quizzes.findIndex(q => q.selected === null);
                            if (firstIdx >= 0) {
                                const el = document.getElementById('quiz-q-' + firstIdx);
                                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                            return;
                        }
                        this.showWarning = false;
                        this.totalCorrect = 0;
                        this.totalChecked = 0;
                        this.quizzes.forEach(q => {
                            q.checked = true;
                            this.totalChecked++;
                            if (q.selected === q.answer) {
                                this.totalCorrect++;
                            }
                        });
                        this.allChecked = true;
                    },
                    resetAll() {
                        this.quizzes.forEach(q => { q.selected = null; q.checked = false; });
                        this.totalCorrect = 0;
                        this.totalChecked = 0;
                        this.allChecked = false;
                        this.showWarning = false;
                    },
                    isCorrect(qIdx) { return this.quizzes[qIdx].selected === this.quizzes[qIdx].answer; },
                    optionClass(qIdx, oIdx) {
                        let q = this.quizzes[qIdx];
                        if (!q.checked) {
                            return q.selected === oIdx ? 'selected' : '';
                        }
                        if (oIdx === q.answer) return 'correct';
                        if (q.selected === oIdx && oIdx !== q.answer) return 'wrong';
                        return 'quiz-locked';
                    }
                }">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 md:p-8">
                    {{-- Quiz Header --}}
                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                        <h3 class="text-2xl text-gray-800" style="font-family: 'Sawarabi Mincho', serif;">Latihan Soal</h3>
                        <span class="px-3 py-1 bg-gray-100 text-[#0F5238] font-semibold text-sm rounded-full"
                            x-text="'Skor: ' + totalCorrect + '/' + quizzes.length">
                        </span>
                    </div>

                    {{-- Warning Banner --}}
                    <div x-show="showWarning" x-transition
                        class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl flex items-center gap-3 quiz-warning">
                        <span class="material-symbols-outlined text-amber-500">warning</span>
                        <p class="text-amber-800 text-sm font-medium" x-text="warningMessage"></p>
                    </div>

                    {{-- Questions --}}
                    <div class="space-y-8">
                        <template x-for="(quiz, qIdx) in quizzes" :key="qIdx">
                            <div class="space-y-4" :id="'quiz-q-' + qIdx">
                                <p class="text-lg text-gray-800 font-medium" x-text="(qIdx + 1) + '. ' + quiz.question"></p>

                                {{-- Unanswered indicator --}}
                                <div x-show="showWarning && quiz.selected === null"
                                    class="text-xs text-amber-600 font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">error</span>
                                    Belum dijawab
                                </div>

                                {{-- Options --}}
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <template x-for="(option, oIdx) in quiz.options" :key="oIdx">
                                        <button
                                            type="button"
                                            @click="selectOption(qIdx, oIdx)"
                                            class="quiz-option py-3 px-5 rounded-xl border border-gray-200 bg-white text-left text-gray-700 text-base transition-all flex items-center gap-3"
                                            :class="[optionClass(qIdx, oIdx), quiz.checked ? 'quiz-locked' : '', (showWarning && quiz.selected === null) ? 'border-amber-300' : '']"
                                        >
                                            <span class="w-7 h-7 rounded-full border-2 flex items-center justify-center text-xs font-bold flex-shrink-0 transition-all"
                                                :class="quiz.selected === oIdx
                                                    ? (quiz.checked
                                                        ? (oIdx === quiz.answer ? 'bg-green-500 border-green-500 text-white' : 'bg-red-500 border-red-500 text-white')
                                                        : 'bg-[#2D6A4F] border-[#2D6A4F] text-white')
                                                    : (quiz.checked && oIdx === quiz.answer ? 'bg-green-500 border-green-500 text-white' : 'border-gray-300 text-gray-400')"
                                                x-text="String.fromCharCode(65 + oIdx)">
                                            </span>
                                            <span x-text="option"></span>
                                        </button>
                                    </template>
                                </div>

                                {{-- Feedback per question --}}
                                <div x-show="quiz.checked" x-transition class="mt-2">
                                    <div x-show="isCorrect(qIdx)"
                                        class="p-3 bg-green-50 rounded-lg flex items-start gap-2 border border-green-200">
                                        <span class="material-symbols-outlined text-green-600 mt-0.5 text-sm">check_circle</span>
                                        <p class="text-green-800 text-sm font-medium">Benar! Jawaban yang tepat.</p>
                                    </div>
                                    <div x-show="!isCorrect(qIdx)"
                                        class="p-3 bg-red-50 rounded-lg flex items-start gap-2 border border-red-200">
                                        <span class="material-symbols-outlined text-red-600 mt-0.5 text-sm">cancel</span>
                                        <p class="text-red-800 text-sm font-medium">Salah. Jawaban yang benar adalah <strong x-text="String.fromCharCode(65 + quiz.answer)"></strong>.</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-8 flex flex-col sm:flex-row items-center gap-4 border-t border-gray-100 pt-6">
                        <button x-show="!allChecked" @click="checkAll()" type="button"
                            class="bg-[#2D6A4F] hover:bg-[#0F5238] text-white font-bold py-3 px-8 rounded-full transition-colors shadow-lg shadow-[#2D6A4F]/20">
                            Cek Jawaban
                        </button>
                        <button x-show="allChecked" @click="resetAll()" type="button" x-transition
                            class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-8 rounded-full transition-colors">
                            Ulangi Kuis
                        </button>

                        {{-- Answered counter (before checking) --}}
                        <div x-show="!allChecked" class="text-sm text-gray-400">
                            <span x-text="quizzes.filter(q => q.selected !== null).length"></span>/<span x-text="quizzes.length"></span> terjawab
                        </div>

                        {{-- Score Summary --}}
                        <div x-show="allChecked" x-transition class="flex items-center gap-2 text-sm">
                            <template x-if="totalCorrect === quizzes.length">
                                <span class="text-green-600 font-bold flex items-center gap-1">
                                    <span class="material-symbols-outlined text-lg">emoji_events</span>
                                    Sempurna! Semua benar!
                                </span>
                            </template>
                            <template x-if="totalCorrect > 0 && totalCorrect < quizzes.length">
                                <span class="text-amber-600 font-bold">
                                    {{ "Kamu menjawab benar" }} <span x-text="totalCorrect"></span> dari <span x-text="quizzes.length"></span> soal.
                                </span>
                            </template>
                            <template x-if="totalCorrect === 0 && allChecked">
                                <span class="text-red-600 font-bold">Belum ada yang benar. Coba lagi!</span>
                            </template>
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

        @endif

        @php
            $rawContent = $article->grammar_explanation ?? $article->content ?? '';
            $parsedContent = $rawContent;

            // === NUMBERED IMAGE SHORTCODES: [gambar1], [gambar2], etc. ===
            // Strip leading path prefixes that Quill sometimes injects
            $hasAnyGambar = false;
            foreach ($individualImageHtml as $idx => $html) {
                $num = $idx + 1;
                $tag = "[gambar{$num}]";
                // Match shortcode in various forms the Quill editor might produce:
                // <p>[gambar2]</p>  or  [gambar2]  or  <p> [gambar2] </p>
                if (str_contains($parsedContent, $tag)) {
                    $hasAnyGambar = true;
                    // Replace wrapped in <p> tags (most common from Quill)
                    $parsedContent = str_replace("<p>{$tag}</p>", $html, $parsedContent);
                    $parsedContent = str_replace("<p>{$tag} </p>", $html, $parsedContent);
                    $parsedContent = str_replace("<p> {$tag}</p>", $html, $parsedContent);
                    $parsedContent = str_replace("<p> {$tag} </p>", $html, $parsedContent);
                    // Replace standalone
                    $parsedContent = str_replace($tag, $html, $parsedContent);
                }
            }


            // === NUMBERED VOCAB SHORTCODES ===
            $hasAnyNumberedVocab = false;
            foreach ($vocabTablesHtml as $idx => $html) {
                $num = $idx + 1;
                $tag = "[vocab{$num}]";
                if (str_contains($parsedContent, $tag)) {
                    $hasAnyNumberedVocab = true;
                    $parsedContent = str_replace("<p>{$tag}</p>", $html, $parsedContent);
                    $parsedContent = str_replace($tag, $html, $parsedContent);
                }
            }

            // === NUMBERED AUDIO SHORTCODES [audio1], [audio2] ... ===
            $hasAnyNumberedAudio = false;
            foreach ($audioHtmlArr as $idx => $html) {
                $num = $idx + 1;
                $tag = "[audio{$num}]";
                if (str_contains($parsedContent, $tag)) {
                    $hasAnyNumberedAudio = true;
                    $parsedContent = str_replace("<p>{$tag}</p>", $html, $parsedContent);
                    $parsedContent = str_replace($tag, $html, $parsedContent);
                }
            }

            // === NUMBERED VIDEO SHORTCODES [video1], [video2] ... ===
            $hasAnyNumberedVideo = false;
            foreach ($videoHtmlArr as $idx => $html) {
                $num = $idx + 1;
                $tag = "[video{$num}]";
                if (str_contains($parsedContent, $tag)) {
                    $hasAnyNumberedVideo = true;
                    $parsedContent = str_replace("<p>{$tag}</p>", $html, $parsedContent);
                    $parsedContent = str_replace($tag, $html, $parsedContent);
                }
            }

            // === NUMBERED YOUTUBE SHORTCODES [youtube1], [youtube2] ... ===
            $hasAnyNumberedYoutube = false;
            foreach ($youtubeHtmlArr as $idx => $html) {
                $num = $idx + 1;
                $tag = "[youtube{$num}]";
                if (str_contains($parsedContent, $tag)) {
                    $hasAnyNumberedYoutube = true;
                    $parsedContent = str_replace("<p>{$tag}</p>", $html, $parsedContent);
                    $parsedContent = str_replace($tag, $html, $parsedContent);
                }
            }

            // === GENERIC LEGACY SHORTCODES ===
            $hasAudio   = str_contains($parsedContent, '[audio]');
            $hasYoutube = str_contains($parsedContent, '[youtube]');
            $hasVocab   = str_contains($parsedContent, '[vocab]');
            $hasQuiz    = str_contains($parsedContent, '[quiz]');
            $hasGallery = str_contains($parsedContent, '[gallery]');

            if ($hasAudio) {
                $parsedContent = str_replace('<p>[audio]</p>', $audioHtml, $parsedContent);
                $parsedContent = str_replace('[audio]', $audioHtml, $parsedContent);
            }
            if ($hasYoutube) {
                $parsedContent = str_replace('<p>[youtube]</p>', $youtubeHtml, $parsedContent);
                $parsedContent = str_replace('[youtube]', $youtubeHtml, $parsedContent);
            }
            if ($hasVocab) {
                $parsedContent = str_replace('<p>[vocab]</p>', $allVocabHtml, $parsedContent);
                $parsedContent = str_replace('[vocab]', $allVocabHtml, $parsedContent);
            }
            if ($hasQuiz) {
                $parsedContent = str_replace('<p>[quiz]</p>', $quizHtml, $parsedContent);
                $parsedContent = str_replace('[quiz]', $quizHtml, $parsedContent);
            }
            if ($hasGallery) {
                $parsedContent = str_replace('<p>[gallery]</p>', $galleryHtml, $parsedContent);
                $parsedContent = str_replace('[gallery]', $galleryHtml, $parsedContent);
            }
        @endphp

        {{-- Fallback: Show media NOT placed via shortcode (auto-render at top) --}}

        {{-- Legacy single audio --}}
        @if(!$hasAudio && $audioHtml)
            {!! $audioHtml !!}
        @endif

        {{-- Multiple audios: only show those NOT placed via shortcode --}}
        @foreach($audioHtmlArr as $i => $aHtml)
            @if(!str_contains($rawContent, '[audio' . ($i+1) . ']'))
                {!! $aHtml !!}
            @endif
        @endforeach

        {{-- Legacy single youtube --}}
        @if(!$hasYoutube && $youtubeHtml)
            {!! $youtubeHtml !!}
        @endif

        {{-- Multiple youtubes: only show those NOT placed via shortcode --}}
        @foreach($youtubeHtmlArr as $i => $ytHtml)
            @if(!str_contains($rawContent, '[youtube' . ($i+1) . ']'))
                {!! $ytHtml !!}
            @endif
        @endforeach

        {{-- Multiple videos: only show those NOT placed via shortcode --}}
        @foreach($videoHtmlArr as $i => $vHtml)
            @if(!str_contains($rawContent, '[video' . ($i+1) . ']'))
                {!! $vHtml !!}
            @endif
        @endforeach

        {{-- Article Body --}}
        <div class="prose prose-wide prose-lg prose-slate max-w-none leading-relaxed text-gray-700
            prose-headings:text-gray-900 prose-headings:font-bold
            prose-a:text-[#2D6A4F] prose-a:underline prose-a:decoration-[#2D6A4F]/30
            prose-strong:text-gray-900 prose-blockquote:border-l-4 prose-blockquote:border-[#2D6A4F]/30
            prose-code:bg-gray-100 prose-code:rounded prose-code:px-1
            prose-li:marker:text-[#2D6A4F]">
            {!! $parsedContent !!}
        </div>

        {{-- Fallback: Vocab --}}
        @if(!$hasVocab && !$hasAnyNumberedVocab && $allVocabHtml)
            {!! $allVocabHtml !!}
        @endif

        {{-- Fallback: Quiz --}}
        @if(!$hasQuiz && $quizHtml)
            {!! $quizHtml !!}
        @endif


    </article>

    {{-- Right Column: Sidebar --}}
    <aside class="article-sidebar-col hidden lg:block">
        <div class="sticky top-28 space-y-6">

            {{-- Back to list --}}
            <a href="{{ route('bahasa.index') }}"
                class="flex items-center gap-2 text-sm text-[#2D6A4F] hover:text-[#0F5238] font-medium transition-colors mb-2">
                <span class="material-symbols-outlined text-base">arrow_back</span>
                Kembali ke Daftar Materi
            </a>

            {{-- Article Info --}}
            <div class="bg-white rounded-xl p-5 border border-gray-200 shadow-sm">
                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-4">Info Artikel</h4>
                <div class="space-y-3 text-sm">
                    @if($article->kemahiran_level)
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-[#2D6A4F]/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#2D6A4F] text-base">school</span>
                        </span>
                        <div>
                            <span class="text-gray-400 text-xs">Level</span>
                            <p class="text-gray-800 font-semibold text-sm">{{ ucfirst($article->kemahiran_level) }}</p>
                        </div>
                    </div>
                    @endif
                    @if($article->category)
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-[#2D6A4F]/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#2D6A4F] text-base">category</span>
                        </span>
                        <div>
                            <span class="text-gray-400 text-xs">Kategori</span>
                            <p class="text-gray-800 font-semibold text-sm">{{ $article->category->name }}</p>
                        </div>
                    </div>
                    @endif
                    @if($article->read_time)
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-[#2D6A4F]/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#2D6A4F] text-base">schedule</span>
                        </span>
                        <div>
                            <span class="text-gray-400 text-xs">Waktu Baca</span>
                            <p class="text-gray-800 font-semibold text-sm">{{ $article->read_time }} menit</p>
                        </div>
                    </div>
                    @endif
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-[#2D6A4F]/10 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[#2D6A4F] text-base">calendar_today</span>
                        </span>
                        <div>
                            <span class="text-gray-400 text-xs">Tanggal</span>
                            <p class="text-gray-800 font-semibold text-sm">{{ $article->published_at ? $article->published_at->translatedFormat('d M Y') : $article->created_at->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </aside>
</main>

{{-- Article Navigation (prev/next) --}}
@if(isset($prevArticle) || isset($nextArticle))
<div class="w-full py-12 border-t border-gray-200/50 bg-transparent">
    <div class="max-w-5xl mx-auto px-4 md:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
        @if(isset($prevArticle) && $prevArticle)
        <a href="{{ route('bahasa.show', $prevArticle->slug) }}" class="w-full md:w-[45%] flex items-center gap-4 p-4 rounded-xl hover:bg-white transition-colors group">
            <div class="w-14 h-14 rounded-lg bg-gray-200 overflow-hidden shrink-0">
                @if($prevArticle->cover_image)
                    <img src="{{ asset('storage/' . $prevArticle->cover_image) }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity" alt="">
                @endif
            </div>
            <div>
                <span class="text-xs text-gray-400 uppercase tracking-wider mb-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">arrow_back</span> Sebelumnya
                </span>
                <h4 class="text-base text-gray-800 group-hover:text-[#0F5238] transition-colors" style="font-family: 'Sawarabi Mincho', serif;">{{ $prevArticle->title }}</h4>
            </div>
        </a>
        @else
            <div class="w-full md:w-[45%]"></div>
        @endif

        @if(isset($nextArticle) && $nextArticle)
        <a href="{{ route('bahasa.show', $nextArticle->slug) }}" class="w-full md:w-[45%] flex items-center justify-end gap-4 p-4 rounded-xl hover:bg-white transition-colors group text-right">
            <div>
                <span class="text-xs text-gray-400 uppercase tracking-wider mb-1 flex items-center justify-end gap-1">
                    Berikutnya <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </span>
                <h4 class="text-base text-gray-800 group-hover:text-[#0F5238] transition-colors" style="font-family: 'Sawarabi Mincho', serif;">{{ $nextArticle->title }}</h4>
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

@push('scripts')
<script src="https://cdn.plyr.io/3.7.8/plyr.polyfilled.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const players = Array.from(document.querySelectorAll('.plyr-media')).map(p => new Plyr(p, {
            controls: ['play-large', 'play', 'progress', 'current-time', 'mute', 'volume', 'fullscreen']
        }));
    });
</script>
@endpush
