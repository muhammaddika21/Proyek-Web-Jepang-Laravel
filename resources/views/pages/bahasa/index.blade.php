@extends('layouts.app')

@section('title', 'Bahasa Jepang')
@section('meta_description', 'Materi pembelajaran bahasa Jepang — Sistem Penulisan, Tata Bahasa, Kosakata, dan Conversation & Budaya')

@section('content')

{{-- Page Header --}}
<section class="py-12 md:py-16 bg-gradient-to-br from-[#f0f7f0] via-[#f8f7ef] to-[#e8f5e8]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-[#448646] text-sm font-semibold uppercase tracking-wider mb-2">日本語を学ぶ</p>
        <h1 class="text-3xl md:text-4xl font-extrabold text-[#296751] mb-3">Materi Bahasa Jepang</h1>
        <p class="text-gray-500 text-lg max-w-xl mx-auto">Pilih kategori untuk mulai belajar</p>
    </div>
</section>

{{-- Category Tabs — Alpine.js replaces openCategory() from original --}}
<section
    x-data="{ activeTab: 'writing' }"
    class="py-8 md:py-12"
>
    {{-- Tab Buttons --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">
        <div class="flex overflow-x-auto gap-2 pb-2 scrollbar-hide justify-center flex-wrap">
            <button
                @click="activeTab = 'writing'"
                :class="activeTab === 'writing' ? 'bg-[#448646] text-white shadow-lg shadow-[#448646]/20' : 'bg-white text-gray-600 hover:text-[#448646] hover:border-[#448646]/30 border border-gray-200'"
                class="px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap transition-all duration-300 flex items-center gap-2"
            >
                <span style="font-family: 'Noto Sans JP';" class="text-base">あ</span> Sistem Penulisan
            </button>
            <button
                @click="activeTab = 'grammar'"
                :class="activeTab === 'grammar' ? 'bg-[#448646] text-white shadow-lg shadow-[#448646]/20' : 'bg-white text-gray-600 hover:text-[#448646] hover:border-[#448646]/30 border border-gray-200'"
                class="px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap transition-all duration-300 flex items-center gap-2"
            >
                <span style="font-family: 'Noto Sans JP';" class="text-base">文</span> Tata Bahasa
            </button>
            <button
                @click="activeTab = 'vocab'"
                :class="activeTab === 'vocab' ? 'bg-[#448646] text-white shadow-lg shadow-[#448646]/20' : 'bg-white text-gray-600 hover:text-[#448646] hover:border-[#448646]/30 border border-gray-200'"
                class="px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap transition-all duration-300 flex items-center gap-2"
            >
                <span style="font-family: 'Noto Sans JP';" class="text-base">語</span> Kosakata & Kanji
            </button>
            <button
                @click="activeTab = 'culture'"
                :class="activeTab === 'culture' ? 'bg-[#448646] text-white shadow-lg shadow-[#448646]/20' : 'bg-white text-gray-600 hover:text-[#448646] hover:border-[#448646]/30 border border-gray-200'"
                class="px-5 py-2.5 rounded-full text-sm font-semibold whitespace-nowrap transition-all duration-300 flex items-center gap-2"
            >
                <span style="font-family: 'Noto Sans JP';" class="text-base">話</span> Conversation & Budaya
            </button>
        </div>
    </div>

    {{-- Tab Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Writing System --}}
        <div x-show="activeTab === 'writing'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @include('components.article-card', [
                'meta' => 'Basic Kana',
                'title' => 'Pengenalan Hiragana',
                'desc' => 'Mempelajari 46 huruf dasar Hiragana, cara tulis, dan pelafalan yang benar.',
                'btn' => 'Mulai Belajar',
                'link' => '#'
            ])
            @include('components.article-card', [
                'meta' => 'Basic Kana',
                'title' => 'Pengenalan Katakana',
                'desc' => 'Huruf untuk kata serapan asing. Penting untuk membaca nama orang non-Jepang.',
                'btn' => 'Mulai Belajar',
                'link' => '#'
            ])
            @include('components.article-card', [
                'meta' => 'Lanjutan',
                'title' => 'Dakuon & Handakuon',
                'desc' => 'Memahami perubahan bunyi seperti Ka menjadi Ga, Ha menjadi Pa, dsb.',
                'btn' => 'Mulai Belajar',
                'link' => '#'
            ])
        </div>

        {{-- Grammar --}}
        <div x-show="activeTab === 'grammar'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @include('components.article-card', [
                'meta' => 'Partikel',
                'title' => 'Partikel Dasar (Wa, Wo, Ni)',
                'desc' => 'Fungsi partikel sebagai penanda topik, objek, dan waktu dalam kalimat.',
                'btn' => 'Baca Materi',
                'link' => '#'
            ])
            @include('components.article-card', [
                'meta' => 'Sentence',
                'title' => 'Pola Kalimat Dasar (Desu/Masu)',
                'desc' => 'Struktur kalimat positif, negatif, dan tanya dalam bentuk sopan.',
                'btn' => 'Baca Materi',
                'link' => '#'
            ])
        </div>

        {{-- Vocab --}}
        <div x-show="activeTab === 'vocab'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @include('components.article-card', [
                'meta' => 'Kosakata N5',
                'title' => 'Angka & Waktu',
                'desc' => 'Cara menghitung 1-100, menyebutkan jam, hari, dan tanggal.',
                'btn' => 'Hafalkan',
                'link' => '#'
            ])
            @include('components.article-card', [
                'meta' => 'Kanji Dasar',
                'title' => 'Kanji Angka & Alam',
                'desc' => 'Pengenalan karakter Kanji paling dasar untuk pemula.',
                'btn' => 'Hafalkan',
                'link' => '#'
            ])
        </div>

        {{-- Culture --}}
        <div x-show="activeTab === 'culture'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @include('components.article-card', [
                'meta' => 'Aisatsu',
                'title' => 'Salam & Sapaan Sehari-hari',
                'desc' => 'Ohayou, Konnichiwa, dan ungkapan penting lainnya.',
                'btn' => 'Dengar Audio',
                'link' => '#'
            ])
            @include('components.article-card', [
                'meta' => 'Budaya',
                'title' => 'Etika Ojigi (Membungkuk)',
                'desc' => 'Kapan dan bagaimana cara membungkuk yang benar di Jepang.',
                'btn' => 'Baca Artikel',
                'link' => '#'
            ])
        </div>

    </div>
</section>

@endsection
