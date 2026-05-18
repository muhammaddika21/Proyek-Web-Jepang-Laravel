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
<div class="flex items-start justify-between mb-6">
    <div>
        <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
            <a href="{{ route('admin.organisasi.index') }}" class="hover:text-[#296751] transition-colors">Organisasi</a>
            <span>›</span>
            <span class="text-gray-800 dark:text-white/90 font-medium">Anggota {{ $divisi->nama }}</span>
        </div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white/90">👥 {{ $divisi->nama }} — Daftar Anggota</h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola anggota divisi ini.</p>
    </div>
    <a href="{{ route('admin.organisasi.createAnggota', $divisi) }}"
        class="inline-flex items-center gap-2 rounded-xl bg-[#296751] hover:bg-[#1f5240] text-white px-4 py-2.5 text-sm font-semibold transition-colors shadow-sm shrink-0">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Tambah Anggota
    </a>
</div>

{{-- Table --}}
<div class="rounded-2xl border border-stone-200 bg-[#fdfcf7] dark:border-[#24463a] dark:bg-[#1a2e24] shadow-sm overflow-hidden">
    @if($anggota->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-center">
            <span class="text-5xl mb-3">🌸</span>
            <p class="text-base font-medium text-gray-600 dark:text-gray-300 mb-1">Belum ada anggota</p>
            <p class="text-sm text-gray-400 mb-4">Tambahkan anggota pertama untuk divisi ini.</p>
            <a href="{{ route('admin.organisasi.createAnggota', $divisi) }}"
                class="inline-flex items-center gap-2 rounded-xl bg-[#296751]/10 hover:bg-[#296751]/20 text-[#296751] dark:text-emerald-400 px-4 py-2 text-sm font-semibold transition-colors">
                + Tambah Anggota
            </a>
        </div>
    @else
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 dark:border-[#24463a] bg-gray-50/60 dark:bg-[#1a2e24]">
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 w-12">#</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Nama</th>
                    <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 hidden sm:table-cell">NIM</th>
                    <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-[#24463a]">
                @foreach($anggota as $index => $a)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-[#24463a]/30 transition-colors">
                    <td class="px-5 py-3.5 text-gray-400 text-xs">{{ $index + 1 }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-[#296751]/10 flex items-center justify-center shrink-0 overflow-hidden text-xs font-bold text-[#296751]">
                                @if($a->foto)
                                    <img src="{{ asset('storage/' . $a->foto) }}" class="w-full h-full object-cover">
                                @else
                                    {{ mb_substr($a->nama, 0, 1) }}
                                @endif
                            </div>
                            <span class="font-medium text-gray-800 dark:text-white/80">{{ $a->nama }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400 hidden sm:table-cell">{{ $a->nim ?? '—' }}</td>
                    <td class="px-5 py-3.5">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.organisasi.editAnggota', [$divisi, $a]) }}"
                                class="inline-flex items-center gap-1 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 px-3 py-1.5 text-xs font-semibold transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <form action="{{ route('admin.organisasi.destroyAnggota', [$divisi, $a]) }}" method="POST"
                                onsubmit="return confirm('Hapus anggota {{ $a->nama }}? Tindakan ini tidak dapat dibatalkan.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center gap-1 rounded-lg bg-red-50 hover:bg-red-100 text-red-700 dark:bg-red-500/10 dark:text-red-400 px-3 py-1.5 text-xs font-semibold transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
