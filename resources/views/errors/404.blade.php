@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center bg-[#f8f7ef] px-4 py-16">
    <div class="text-center max-w-lg mx-auto">
        <div class="mb-8 relative inline-block">
            <span class="text-9xl font-bold text-[#80b68b]/20 select-none" style="font-family: 'Noto Sans JP', sans-serif;">空</span>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="text-6xl font-black text-[#448646]" style="font-family: 'Zen Kurenaido', serif;">404</span>
            </div>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-[#1A1A2E] mb-4" style="font-family: 'Zen Kurenaido', serif;">Halaman Tidak Ditemukan</h1>
        <p class="text-gray-600 mb-8 leading-relaxed" style="font-family: 'Noto Sans JP', sans-serif;">Maaf, halaman yang Anda cari mungkin telah dipindahkan, dihapus, atau memang tidak pernah ada.</p>
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-[#2D6A4F] to-[#0F5238] text-white rounded-full font-semibold shadow-lg shadow-[#2D6A4F]/30 hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
            Kembali ke Beranda
            <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        </a>
    </div>
</div>
@endsection
