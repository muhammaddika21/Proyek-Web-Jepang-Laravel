@extends('layouts.admin')

@section('content')
<div class="max-w-xl">
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-5">
        <a href="{{ route('admin.organisasi.index') }}" class="hover:text-[#296751] transition-colors">Organisasi</a>
        <span>›</span>
        <a href="{{ route('admin.organisasi.anggota', $divisi) }}" class="hover:text-[#296751] transition-colors">{{ $divisi->nama }}</a>
        <span>›</span>
        <span class="text-gray-800 dark:text-white/90 font-medium">Tambah Anggota</span>
    </div>

    <div class="rounded-2xl border border-stone-200 bg-[#fdfcf7] dark:border-[#24463a] dark:bg-[#1a2e24] shadow-sm">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-[#24463a]">
            <h2 class="text-base font-semibold text-gray-800 dark:text-white/90">➕ Tambah Anggota — {{ $divisi->nama }}</h2>
        </div>
        <form action="{{ route('admin.organisasi.storeAnggota', $divisi) }}" method="POST" class="p-6 space-y-5">
            @csrf

            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama anggota..."
                    class="w-full rounded-xl border border-gray-300 dark:border-[#24463a] bg-white dark:bg-[#112117] px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 outline-none focus:border-[#296751] focus:ring-2 focus:ring-[#296751]/20 transition-all
                    @error('nama') border-red-400 @enderror">
                @error('nama')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">NIM</label>
                <input type="text" name="nim" value="{{ old('nim') }}" placeholder="222XXXXX"
                    class="w-full rounded-xl border border-gray-300 dark:border-[#24463a] bg-white dark:bg-[#112117] px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 outline-none focus:border-[#296751] focus:ring-2 focus:ring-[#296751]/20 transition-all">
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-[#296751] hover:bg-[#1f5240] text-white px-5 py-2.5 text-sm font-semibold transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Tambahkan
                </button>
                <a href="{{ route('admin.organisasi.anggota', $divisi) }}"
                    class="inline-flex items-center rounded-xl border border-gray-300 dark:border-[#24463a] bg-white dark:bg-transparent px-5 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-[#24463a] transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
