@extends('layouts.app')

@section('title', 'Home')
@section('meta_description', 'Platform lengkap UKM untuk menguasai bahasa Jepang dari nol hingga mahir.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/carousel.css') }}">
@endpush

@section('content')

{{-- ======== HERO SECTION ======== --}}
<section class="relative min-h-[85vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 z-0 hero-parallax-bg">
        <img src="{{ asset('images/hero_kereta.png') }}" alt="Hero kereta Jepang" class="w-full h-full object-cover" />
        <div class="absolute inset-0 bg-gradient-to-b from-white/70 via-white/50 to-white/80"></div>
    </div>



    <div class="text-center px-4 relative z-10 max-w-3xl mx-auto">
        <p class="text-[#2D6A4F] text-lg md:text-xl mb-3 font-medium hero-badge" style="font-family: 'Noto Sans JP', sans-serif;">
            日本語部へようこそ
        </p>
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-[#1A1A2E] leading-tight mb-6 hero-title" style="font-family: 'Zen Kurenaido', serif;">
            Belajar Bahasa &<br>
            <span class="bg-gradient-to-r from-[#2D6A4F] to-[#E76F51] bg-clip-text text-transparent">Budaya Jepang</span>
        </h1>
        <p class="text-gray-700 text-lg md:text-xl mb-10 max-w-xl mx-auto leading-relaxed hero-subtitle" style="font-family: 'Noto Sans JP', sans-serif;">
            Platform lengkap UKM untuk menguasai bahasa Jepang dari nol hingga mahir.
        </p>
        <a href="#belajar"
           class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#2D6A4F] to-[#0F5238] text-white rounded-full text-lg font-semibold shadow-lg shadow-[#2D6A4F]/30 hover:shadow-xl hover:shadow-[#2D6A4F]/40 hover:-translate-y-1 transition-all duration-300 hero-cta">
            Lihat Materi
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </a>
    </div>
</section>

{{-- ======== GALLERY / CAROUSEL SECTION ======== --}}
<section class="py-16 md:py-24 bg-white reveal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 section-heading">
            <p class="text-[#2D6A4F] text-sm font-semibold uppercase tracking-wider mb-2" style="font-family: 'Noto Sans JP';">活動記録</p>
            <h2 class="text-3xl md:text-4xl text-[#1A1A2E]" style="font-family: 'Sawarabi Mincho', serif;">Kegiatan Kami</h2>
        </div>

        <div class="carousel-container">
            <div class="carousel-wrapper" id="carouselWrapper"></div>
            <button class="carousel-nav prev" id="prevBtn" aria-label="Previous slide">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
            </button>
            <button class="carousel-nav next" id="nextBtn" aria-label="Next slide">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </button>
        </div>
        <div class="carousel-dots" id="carouselDots"></div>
    </div>
</section>

{{-- ======== KEIKEN SURU KOTO ======== --}}
<section id="belajar" class="py-16 md:py-24 bg-[#f8f7ef]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14 section-heading reveal">
            <p class="text-[#2D6A4F] text-sm font-semibold uppercase tracking-wider mb-2" style="font-family: 'Noto Sans JP';">経験すること</p>
            <h2 class="text-3xl md:text-4xl text-[#1A1A2E] mb-3" style="font-family: 'Sawarabi Mincho', serif;">Keiken Suru Koto</h2>
            <p class="text-gray-500 text-lg" style="font-family: 'Noto Sans JP';">Apa yang akan kalian alami?</p>
        </div>

        {{-- ===== BAHASA GROUP ===== --}}
        <div class="mb-12 reveal">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-[#2D6A4F]/10 flex items-center justify-center">
                    <span class="text-xl font-bold text-[#2D6A4F]" style="font-family: 'Noto Sans JP';">言</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-[#1A1A2E]" style="font-family: 'Noto Sans JP', sans-serif;">
                        <span class="text-[#2D6A4F]">言語</span> • Bahasa
                    </h3>
                    <p class="text-xs text-gray-500">Pelajari bahasa Jepang secara bertahap</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 reveal-stagger">

                {{-- Complete Guide --}}
                <a href="{{ url('/bahasa?cat=complete-guide') }}" class="reveal group relative bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#2D6A4F]/30 transition-all duration-300 hover:-translate-y-2 overflow-hidden category-card">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#2D6A4F]/5 rounded-full -translate-x-4 -translate-y-4 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#2D6A4F]/10 to-[#0F5238]/10 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                            <span class="text-2xl">📘</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1A2E] mb-2 group-hover:text-[#2D6A4F] transition-colors" style="font-family: 'Noto Sans JP', sans-serif;">Complete Guide</h3>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4" style="font-family: 'Noto Sans JP', sans-serif;">
                            Panduan lengkap belajar bahasa Jepang dari nol hingga mahir.
                        </p>
                        <span class="inline-flex items-center gap-1 text-sm font-semibold text-[#2D6A4F] group-hover:gap-2 transition-all">
                            Jelajahi <span class="text-lg">→</span>
                        </span>
                    </div>
                </a>

                {{-- Kanji --}}
                <a href="{{ url('/bahasa?cat=kanji') }}" class="reveal group relative bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#C0392B]/30 transition-all duration-300 hover:-translate-y-2 overflow-hidden category-card">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#C0392B]/5 rounded-full -translate-x-4 -translate-y-4 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#C0392B]/10 to-[#C0392B]/5 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                            <span class="text-2xl font-bold text-[#C0392B]" style="font-family: 'Noto Sans JP', sans-serif;">漢</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1A2E] mb-2 group-hover:text-[#2D6A4F] transition-colors" style="font-family: 'Noto Sans JP', sans-serif;">Kanji</h3>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4" style="font-family: 'Noto Sans JP', sans-serif;">
                            Mengenal karakter Jepang beserta onyomi dan kunyomi.
                        </p>
                        <span class="inline-flex items-center gap-1 text-sm font-semibold text-[#2D6A4F] group-hover:gap-2 transition-all">
                            Jelajahi <span class="text-lg">→</span>
                        </span>
                    </div>
                </a>

                {{-- Kotoba --}}
                <a href="{{ url('/bahasa?cat=kotoba') }}" class="reveal group relative bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#B8860B]/30 transition-all duration-300 hover:-translate-y-2 overflow-hidden category-card">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#B8860B]/5 rounded-full -translate-x-4 -translate-y-4 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#B8860B]/10 to-[#B8860B]/5 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                            <span class="text-2xl font-bold text-[#B8860B]" style="font-family: 'Noto Sans JP', sans-serif;">言</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1A2E] mb-2 group-hover:text-[#2D6A4F] transition-colors" style="font-family: 'Noto Sans JP', sans-serif;">Kotoba</h3>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4" style="font-family: 'Noto Sans JP', sans-serif;">
                            Kosakata sehari-hari untuk meningkatkan perbendaharaan kata.
                        </p>
                        <span class="inline-flex items-center gap-1 text-sm font-semibold text-[#2D6A4F] group-hover:gap-2 transition-all">
                            Jelajahi <span class="text-lg">→</span>
                        </span>
                    </div>
                </a>

                {{-- Bunpou --}}
                <a href="{{ url('/bahasa?cat=bunpou') }}" class="reveal group relative bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#4a7ec9]/30 transition-all duration-300 hover:-translate-y-2 overflow-hidden category-card">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#4a7ec9]/5 rounded-full -translate-x-4 -translate-y-4 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#4a7ec9]/10 to-[#4a7ec9]/5 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                            <span class="text-2xl font-bold text-[#4a7ec9]" style="font-family: 'Noto Sans JP', sans-serif;">文</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1A2E] mb-2 group-hover:text-[#2D6A4F] transition-colors" style="font-family: 'Noto Sans JP', sans-serif;">Bunpou</h3>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4" style="font-family: 'Noto Sans JP', sans-serif;">
                            Tata bahasa dan pola kalimat untuk komunikasi yang akurat.
                        </p>
                        <span class="inline-flex items-center gap-1 text-sm font-semibold text-[#2D6A4F] group-hover:gap-2 transition-all">
                            Jelajahi <span class="text-lg">→</span>
                        </span>
                    </div>
                </a>
            </div>
        </div>

        {{-- ===== BUDAYA & KEGIATAN GROUP ===== --}}
        <div class="reveal">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-[#E76F51]/10 flex items-center justify-center">
                    <span class="text-xl font-bold text-[#E76F51]" style="font-family: 'Noto Sans JP';">活</span>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-[#1A1A2E]" style="font-family: 'Noto Sans JP', sans-serif;">
                        <span class="text-[#E76F51]">活動と文化</span> • Kegiatan & Budaya
                    </h3>
                    <p class="text-xs text-gray-500">Rasakan pengalaman budaya dan kegiatan UKM</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 reveal-stagger">

                {{-- 1. Kegiatan Terbaru --}}
                <a href="{{ url('/kegiatan?cat=kegiatan-terbaru') }}" class="reveal group relative bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#d6975e]/30 transition-all duration-300 hover:-translate-y-2 overflow-hidden category-card">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#d6975e]/5 rounded-full -translate-x-4 -translate-y-4 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#d6975e]/10 to-[#d6975e]/5 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                            <span class="text-2xl">📰</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1A2E] mb-2 group-hover:text-[#d6975e] transition-colors" style="font-family: 'Noto Sans JP', sans-serif;">Kegiatan Terbaru</h3>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4" style="font-family: 'Noto Sans JP', sans-serif;">
                            Update terbaru seputar aktivitas dan program UKM.
                        </p>
                        <span class="inline-flex items-center gap-1 text-sm font-semibold text-[#d6975e] group-hover:gap-2 transition-all">
                            Jelajahi <span class="text-lg">→</span>
                        </span>
                    </div>
                </a>

                {{-- 2. Event --}}
                <a href="{{ url('/kegiatan?cat=event') }}" class="reveal group relative bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#7c5cbf]/30 transition-all duration-300 hover:-translate-y-2 overflow-hidden category-card">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#7c5cbf]/5 rounded-full -translate-x-4 -translate-y-4 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#7c5cbf]/10 to-[#7c5cbf]/5 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                            <span class="text-2xl">🎎</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1A2E] mb-2 group-hover:text-[#7c5cbf] transition-colors" style="font-family: 'Noto Sans JP', sans-serif;">Event</h3>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4" style="font-family: 'Noto Sans JP', sans-serif;">
                            Acara-acara seru yang diselenggarakan oleh UKM Nihon.
                        </p>
                        <span class="inline-flex items-center gap-1 text-sm font-semibold text-[#7c5cbf] group-hover:gap-2 transition-all">
                            Jelajahi <span class="text-lg">→</span>
                        </span>
                    </div>
                </a>

                {{-- 3. Budaya --}}
                <a href="{{ url('/budaya') }}" class="reveal group relative bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#E76F51]/30 transition-all duration-300 hover:-translate-y-2 overflow-hidden category-card">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#E76F51]/5 rounded-full -translate-x-4 -translate-y-4 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#E76F51]/10 to-[#E76F51]/5 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                            <span class="text-2xl">🎌</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1A2E] mb-2 group-hover:text-[#E76F51] transition-colors" style="font-family: 'Noto Sans JP', sans-serif;">Budaya</h3>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4" style="font-family: 'Noto Sans JP', sans-serif;">
                            Memahami budaya Jepang melalui tradisi, festival, dan kehidupan sehari-hari.
                        </p>
                        <span class="inline-flex items-center gap-1 text-sm font-semibold text-[#E76F51] group-hover:gap-2 transition-all">
                            Jelajahi <span class="text-lg">→</span>
                        </span>
                    </div>
                </a>

                {{-- 4. Pop Culture --}}
                <a href="{{ url('/budaya?cat=pop-culture') }}" class="reveal group relative bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-[#4a7ec9]/30 transition-all duration-300 hover:-translate-y-2 overflow-hidden category-card">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-[#4a7ec9]/5 rounded-full -translate-x-4 -translate-y-4 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#4a7ec9]/10 to-[#4a7ec9]/5 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                            <span class="text-2xl">🎮</span>
                        </div>
                        <h3 class="text-lg font-bold text-[#1A1A2E] mb-2 group-hover:text-[#4a7ec9] transition-colors" style="font-family: 'Noto Sans JP', sans-serif;">
                            Pop Culture
                        </h3>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4" style="font-family: 'Noto Sans JP', sans-serif;">
                            Anime, manga, game, dan budaya populer Jepang bersama komunitas.
                        </p>
                        <span class="inline-flex items-center gap-1 text-sm font-semibold text-[#4a7ec9] group-hover:gap-2 transition-all">
                            Jelajahi <span class="text-lg">→</span>
                        </span>
                    </div>
                </a>

            </div>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script src="{{ asset('js/carousel.js') }}"></script>
@endpush
