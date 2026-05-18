@extends('layouts.admin')

@section('content')

@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
    class="mb-6 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-3.5 text-emerald-800 dark:border-emerald-700/40 dark:bg-emerald-900/20 dark:text-emerald-300">
    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span class="text-sm font-medium">{{ session('success') }}</span>
</div>
@endif

{{-- Header --}}
<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white/90 sm:text-2xl">🏮 Manajemen Organisasi</h2>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola pengurus inti dan anggota setiap divisi UKM Nihon STIS.</p>
</div>

{{-- ===== PENGURUS INTI ===== --}}
<div class="mb-8">
    <h3 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
        <span class="w-1 h-5 bg-[#296751] rounded-full inline-block"></span>
        Pengurus Inti
    </h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach($pengurusInti as $pengurus)
        <div class="rounded-2xl border border-stone-200 bg-[#fdfcf7] dark:border-[#24463a] dark:bg-[#1a2e24] shadow-sm p-5 flex flex-col gap-3">
            {{-- Avatar + Info --}}
            <div class="flex items-center gap-3">
                @php
                    $kanjiInti = [
                        'Ketua'       => '長',
                        'Wakil Ketua' => '副',
                        'Sekretaris'  => '記',
                        'Bendahara'   => '財',
                    ];
                    $kanji = $kanjiInti[$pengurus->jabatan] ?? '員';
                @endphp
                <div class="w-12 h-12 rounded-full bg-[#296751]/10 flex items-center justify-center shrink-0 text-lg font-bold text-[#296751]" style="font-family: 'Noto Sans JP', sans-serif;">
                    {{ $kanji }}
                </div>
                <div class="flex-1 min-w-0">
                    <span class="inline-block text-xs font-semibold uppercase tracking-wider text-[#296751] dark:text-emerald-400 mb-0.5">{{ $pengurus->jabatan }}</span>
                    <p class="text-sm font-bold text-gray-800 dark:text-white/90 truncate">{{ $pengurus->nama }}</p>
                    @if($pengurus->nim)
                        <p class="text-xs text-gray-400">{{ $pengurus->nim }}</p>
                    @endif
                </div>
            </div>
            {{-- Edit Button --}}
            <a href="{{ route('admin.organisasi.editPengurus', $pengurus) }}"
                class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-[#296751]/10 hover:bg-[#296751]/20 text-[#296751] dark:text-emerald-400 px-3 py-2 text-xs font-semibold transition-colors w-full">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
        </div>
        @endforeach
    </div>
</div>

{{-- ===== DIVISI ===== --}}
@foreach($divisi as $div)
<div class="mb-8">
    <h3 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
        <span class="w-1 h-5 bg-amber-500 rounded-full inline-block"></span>
        {{ $div->nama }}
        @if($div->deskripsi)
            <span class="text-xs font-normal text-gray-400">— {{ $div->deskripsi }}</span>
        @endif
    </h3>

    {{-- Ketua Divisi --}}
    <div class="rounded-2xl border border-stone-200 bg-[#fdfcf7] dark:border-[#24463a] dark:bg-[#1a2e24] shadow-sm p-5 mb-4">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-semibold uppercase tracking-wider text-amber-600 dark:text-amber-400">Ketua Divisi</span>
            <a href="{{ route('admin.organisasi.editKetuaDivisi', $div) }}"
                class="inline-flex items-center gap-1 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400 px-3 py-1.5 text-xs font-semibold transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Ketua
            </a>
        </div>
        @if($div->ketuaDivisi)
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center shrink-0 text-sm font-bold text-amber-700" style="font-family: 'Noto Sans JP', sans-serif;">
                    長
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-white/90">{{ $div->ketuaDivisi->nama }}</p>
                    @if($div->ketuaDivisi->nim)<p class="text-xs text-gray-400">NIM: {{ $div->ketuaDivisi->nim }}</p>@endif
                </div>
            </div>
        @else
            <p class="text-sm text-gray-400 italic">Belum ada ketua divisi. <a href="{{ route('admin.organisasi.editKetuaDivisi', $div) }}" class="text-amber-600 underline">Tambah sekarang</a></p>
        @endif
    </div>

    {{-- Anggota --}}
    <div class="rounded-2xl border border-stone-200 bg-[#fdfcf7] dark:border-[#24463a] dark:bg-[#1a2e24] shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100 dark:border-[#24463a] flex items-center justify-between">
            <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                Anggota
                <span class="ml-1.5 inline-flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-700 px-2 py-0.5 text-xs font-bold text-gray-600 dark:text-gray-300">
                    {{ $div->anggota->where('jabatan', 'Anggota')->count() }}
                </span>
            </span>
            <a href="{{ route('admin.organisasi.anggota', $div) }}"
                class="inline-flex items-center gap-1 rounded-lg bg-[#296751]/10 hover:bg-[#296751]/20 text-[#296751] dark:text-emerald-400 px-3 py-1.5 text-xs font-semibold transition-colors">
                Kelola Anggota →
            </a>
        </div>
        @php $anggotaList = $div->anggota->where('jabatan', 'Anggota'); @endphp
        @if($anggotaList->isEmpty())
            <div class="px-5 py-6 text-center text-sm text-gray-400 italic">Belum ada anggota.</div>
        @else
            <ul class="divide-y divide-gray-100 dark:divide-[#24463a]">
                @foreach($anggotaList as $a)
                <li class="px-5 py-3 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center shrink-0 text-xs font-bold text-gray-500" style="font-family: 'Noto Sans JP', sans-serif;">
                        員
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 dark:text-white/80 truncate">{{ $a->nama }}</p>
                        @if($a->nim)<p class="text-xs text-gray-400">{{ $a->nim }}</p>@endif
                    </div>
                </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endforeach

@endsection
