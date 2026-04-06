@extends('layouts.admin')

@section('content')

  {{-- ============================================ --}}
  {{-- SECTION 1: WELCOME HEADER --}}
  {{-- Berdasarkan Rekomendasi Section 2: Wireframe --}}
  {{-- ============================================ --}}
  <div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white/90 sm:text-2xl">
      Okaerinasai, Admin! 👋
    </h2>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
      Berikut ringkasan statistik dan aktivitas terbaru UKM NihonLearn.
    </p>
  </div>

  {{-- ============================================ --}}
  {{-- SECTION 2: STAT CARDS (4 kartu) --}}
  {{-- Berdasarkan Rekomendasi Section 3 --}}
  {{-- ============================================ --}}
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 md:gap-6 mb-6">

    {{-- Card 1: Total Artikel --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
      <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-green-100 dark:bg-green-500/20">
        <svg class="text-green-600 dark:text-green-400" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
        </svg>
      </div>
      <div class="flex items-end justify-between mt-5">
        <div>
          <span class="text-sm text-gray-500 dark:text-gray-400">Total Artikel</span>
          <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">42</h4>
        </div>
        <span class="flex items-center gap-1 rounded-full bg-green-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-green-600 dark:bg-green-500/15 dark:text-green-500">
          <svg class="fill-current" width="12" height="12" viewBox="0 0 12 12"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.56462 1.62393C5.70193 1.47072 5.90135 1.37432 6.12329 1.37432C6.31631 1.37415 6.50845 1.44731 6.65505 1.59381L9.65514 4.5918C9.94814 4.88459 9.94831 5.35947 9.65552 5.65246C9.36273 5.94546 8.88785 5.94562 8.59486 5.65283L6.87329 3.93247V10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125V3.93578L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65248C2.3017 5.35949 2.30185 4.88462 2.59484 4.59182L5.56462 1.62393Z"/></svg>
          +8
        </span>
      </div>
    </div>

    {{-- Card 2: Total Views --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
      <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-500/20">
        <svg class="text-blue-600 dark:text-blue-400" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
      </div>
      <div class="flex items-end justify-between mt-5">
        <div>
          <span class="text-sm text-gray-500 dark:text-gray-400">Total Views</span>
          <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">12.5K</h4>
        </div>
        <span class="flex items-center gap-1 rounded-full bg-green-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-green-600 dark:bg-green-500/15 dark:text-green-500">
          <svg class="fill-current" width="12" height="12" viewBox="0 0 12 12"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.56462 1.62393C5.70193 1.47072 5.90135 1.37432 6.12329 1.37432C6.31631 1.37415 6.50845 1.44731 6.65505 1.59381L9.65514 4.5918C9.94814 4.88459 9.94831 5.35947 9.65552 5.65246C9.36273 5.94546 8.88785 5.94562 8.59486 5.65283L6.87329 3.93247V10.125C6.87329 10.5392 6.53751 10.875 6.12329 10.875C5.70908 10.875 5.37329 10.5392 5.37329 10.125V3.93578L3.65516 5.65282C3.36218 5.94562 2.8873 5.94547 2.5945 5.65248C2.3017 5.35949 2.30185 4.88462 2.59484 4.59182L5.56462 1.62393Z"/></svg>
          11.01%
        </span>
      </div>
    </div>

    {{-- Card 3: Kategori --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
      <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-100 dark:bg-amber-500/20">
        <svg class="text-amber-600 dark:text-amber-400" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
        </svg>
      </div>
      <div class="flex items-end justify-between mt-5">
        <div>
          <span class="text-sm text-gray-500 dark:text-gray-400">Kategori</span>
          <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">8</h4>
        </div>
      </div>
    </div>

    {{-- Card 4: Draft Tertunda --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] md:p-6">
      <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-red-100 dark:bg-red-500/20">
        <svg class="text-red-500 dark:text-red-400" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div class="flex items-end justify-between mt-5">
        <div>
          <span class="text-sm text-gray-500 dark:text-gray-400">Draft Tertunda</span>
          <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">5</h4>
        </div>
        <span class="flex items-center gap-1 rounded-full bg-red-50 py-0.5 pl-2 pr-2.5 text-sm font-medium text-red-600 dark:bg-red-500/15 dark:text-red-500">
          Perlu review
        </span>
      </div>
    </div>

  </div>

  {{-- ============================================ --}}
  {{-- SECTION 3: TABEL ARTIKEL TERBARU --}}
  {{-- Berdasarkan Rekomendasi Section 3 --}}
  {{-- ============================================ --}}
  <div class="grid grid-cols-12 gap-4 md:gap-6 mb-6">
    <div class="col-span-12">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        {{-- Header Tabel --}}
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800 sm:px-6 sm:py-5 flex items-center justify-between">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            Artikel Terbaru
          </h3>
          <x-ui.button size="sm">
            + Buat Artikel
          </x-ui.button>
        </div>

        {{-- Body Tabel --}}
        <div class="p-5 sm:p-6 overflow-x-auto">
          <table class="w-full text-sm text-left">
            <thead>
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Judul</th>
                <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Kategori</th>
                <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Status</th>
                <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                <th class="pb-3 font-medium text-gray-500 dark:text-gray-400 text-right">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
              <tr>
                <td class="py-4 font-medium text-gray-800 dark:text-white/90">Belajar Hiragana Dasar</td>
                <td class="py-4">
                  <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">Bahasa</span>
                </td>
                <td class="py-4">
                  <span class="inline-flex rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600 dark:bg-green-500/15 dark:text-green-400">Published</span>
                </td>
                <td class="py-4 text-gray-500 dark:text-gray-400">28 Mar 2026</td>
                <td class="py-4 text-right">
                  <button class="text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 mr-3">Edit</button>
                  <button class="text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400">Hapus</button>
                </td>
              </tr>
              <tr>
                <td class="py-4 font-medium text-gray-800 dark:text-white/90">Festival Hanami 2026</td>
                <td class="py-4">
                  <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-0.5 text-xs font-semibold text-amber-600 dark:bg-amber-500/15 dark:text-amber-400">Budaya</span>
                </td>
                <td class="py-4">
                  <span class="inline-flex rounded-full bg-yellow-50 px-2.5 py-0.5 text-xs font-semibold text-yellow-600 dark:bg-yellow-500/15 dark:text-yellow-400">Draft</span>
                </td>
                <td class="py-4 text-gray-500 dark:text-gray-400">25 Mar 2026</td>
                <td class="py-4 text-right">
                  <button class="text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 mr-3">Edit</button>
                  <button class="text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400">Hapus</button>
                </td>
              </tr>
              <tr>
                <td class="py-4 font-medium text-gray-800 dark:text-white/90">Sejarah Origami di Jepang</td>
                <td class="py-4">
                  <span class="inline-flex rounded-full bg-purple-50 px-2.5 py-0.5 text-xs font-semibold text-purple-600 dark:bg-purple-500/15 dark:text-purple-400">Kesenian</span>
                </td>
                <td class="py-4">
                  <span class="inline-flex rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600 dark:bg-green-500/15 dark:text-green-400">Published</span>
                </td>
                <td class="py-4 text-gray-500 dark:text-gray-400">20 Mar 2026</td>
                <td class="py-4 text-right">
                  <button class="text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 mr-3">Edit</button>
                  <button class="text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400">Hapus</button>
                </td>
              </tr>
              <tr>
                <td class="py-4 font-medium text-gray-800 dark:text-white/90">Tips Persiapan JLPT N5</td>
                <td class="py-4">
                  <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-semibold text-blue-600 dark:bg-blue-500/15 dark:text-blue-400">Bahasa</span>
                </td>
                <td class="py-4">
                  <span class="inline-flex rounded-full bg-yellow-50 px-2.5 py-0.5 text-xs font-semibold text-yellow-600 dark:bg-yellow-500/15 dark:text-yellow-400">Draft</span>
                </td>
                <td class="py-4 text-gray-500 dark:text-gray-400">18 Mar 2026</td>
                <td class="py-4 text-right">
                  <button class="text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 mr-3">Edit</button>
                  <button class="text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400">Hapus</button>
                </td>
              </tr>
              <tr>
                <td class="py-4 font-medium text-gray-800 dark:text-white/90">Resep Takoyaki Sederhana</td>
                <td class="py-4">
                  <span class="inline-flex rounded-full bg-rose-50 px-2.5 py-0.5 text-xs font-semibold text-rose-600 dark:bg-rose-500/15 dark:text-rose-400">Kuliner</span>
                </td>
                <td class="py-4">
                  <span class="inline-flex rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-semibold text-green-600 dark:bg-green-500/15 dark:text-green-400">Published</span>
                </td>
                <td class="py-4 text-gray-500 dark:text-gray-400">15 Mar 2026</td>
                <td class="py-4 text-right">
                  <button class="text-gray-500 hover:text-brand-500 dark:text-gray-400 dark:hover:text-brand-400 mr-3">Edit</button>
                  <button class="text-gray-500 hover:text-red-500 dark:text-gray-400 dark:hover:text-red-400">Hapus</button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  {{-- ============================================ --}}
  {{-- SECTION 4: DATABASE SCHEMA INFO --}}
  {{-- Berdasarkan Rekomendasi Section 4 --}}
  {{-- ============================================ --}}
  <div class="grid grid-cols-12 gap-4 md:gap-6 mb-6">

    {{-- Tabel articles --}}
    <div class="col-span-12 xl:col-span-6">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800 sm:px-6 sm:py-5">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            📋 Schema: <code class="text-brand-500">articles</code>
          </h3>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Struktur data tabel artikel di database.</p>
        </div>
        <div class="p-5 sm:p-6 overflow-x-auto">
          <table class="w-full text-sm text-left">
            <thead>
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Kolom</th>
                <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Tipe</th>
                <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Keterangan</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
              <tr>
                <td class="py-3 font-mono text-xs text-brand-500">id</td>
                <td class="py-3 text-gray-500 dark:text-gray-400">BIGINT (PK)</td>
                <td class="py-3 text-gray-800 dark:text-white/90">Primary Key</td>
              </tr>
              <tr>
                <td class="py-3 font-mono text-xs text-brand-500">title</td>
                <td class="py-3 text-gray-500 dark:text-gray-400">VARCHAR(255)</td>
                <td class="py-3 text-gray-800 dark:text-white/90">Judul artikel</td>
              </tr>
              <tr>
                <td class="py-3 font-mono text-xs text-brand-500">slug</td>
                <td class="py-3 text-gray-500 dark:text-gray-400">VARCHAR(255)</td>
                <td class="py-3 text-gray-800 dark:text-white/90">URL (contoh: /belajar-hiragana)</td>
              </tr>
              <tr>
                <td class="py-3 font-mono text-xs text-brand-500">content</td>
                <td class="py-3 text-gray-500 dark:text-gray-400">LONGTEXT</td>
                <td class="py-3 text-gray-800 dark:text-white/90">Isi artikel HTML</td>
              </tr>
              <tr>
                <td class="py-3 font-mono text-xs text-brand-500">thumbnail</td>
                <td class="py-3 text-gray-500 dark:text-gray-400">VARCHAR(255)</td>
                <td class="py-3 text-gray-800 dark:text-white/90">Path gambar sampul</td>
              </tr>
              <tr>
                <td class="py-3 font-mono text-xs text-brand-500">category_id</td>
                <td class="py-3 text-gray-500 dark:text-gray-400">BIGINT (FK)</td>
                <td class="py-3 text-gray-800 dark:text-white/90">Relasi ke kategori</td>
              </tr>
              <tr>
                <td class="py-3 font-mono text-xs text-brand-500">status</td>
                <td class="py-3 text-gray-500 dark:text-gray-400">ENUM</td>
                <td class="py-3 text-gray-800 dark:text-white/90">'published' atau 'draft'</td>
              </tr>
              <tr>
                <td class="py-3 font-mono text-xs text-brand-500">views</td>
                <td class="py-3 text-gray-500 dark:text-gray-400">INTEGER</td>
                <td class="py-3 text-gray-800 dark:text-white/90">Jumlah dilihat (default: 0)</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- Tabel categories --}}
    <div class="col-span-12 xl:col-span-6">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800 sm:px-6 sm:py-5">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            📂 Schema: <code class="text-brand-500">categories</code>
          </h3>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Struktur data tabel kategori.</p>
        </div>
        <div class="p-5 sm:p-6 overflow-x-auto">
          <table class="w-full text-sm text-left">
            <thead>
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Kolom</th>
                <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Tipe</th>
                <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Keterangan</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
              <tr>
                <td class="py-3 font-mono text-xs text-brand-500">id</td>
                <td class="py-3 text-gray-500 dark:text-gray-400">BIGINT (PK)</td>
                <td class="py-3 text-gray-800 dark:text-white/90">Primary Key</td>
              </tr>
              <tr>
                <td class="py-3 font-mono text-xs text-brand-500">name</td>
                <td class="py-3 text-gray-500 dark:text-gray-400">VARCHAR(100)</td>
                <td class="py-3 text-gray-800 dark:text-white/90">Nama Kategori (Bahasa, Budaya, dll)</td>
              </tr>
              <tr>
                <td class="py-3 font-mono text-xs text-brand-500">slug</td>
                <td class="py-3 text-gray-500 dark:text-gray-400">VARCHAR(100)</td>
                <td class="py-3 text-gray-800 dark:text-white/90">URL Kategori</td>
              </tr>
              <tr>
                <td class="py-3 font-mono text-xs text-brand-500">color</td>
                <td class="py-3 text-gray-500 dark:text-gray-400">VARCHAR(20)</td>
                <td class="py-3 text-gray-800 dark:text-white/90">Kode hex untuk badge (#448646)</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>


  {{-- ============================================ --}}
  {{-- SECTION 6: COLOR PALETTE --}}
  {{-- Berdasarkan Rekomendasi Section 6 --}}
  {{-- ============================================ --}}
  <div class="grid grid-cols-12 gap-4 md:gap-6 mb-6">
    <div class="col-span-12">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800 sm:px-6 sm:py-5">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">🎨 Color Palette Admin NihonLearn</h3>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Panduan warna utama agar tampilan dashboard konsisten.</p>
        </div>
        <div class="p-5 sm:p-6">
          <div class="flex flex-wrap gap-4">
            {{-- Dark Sidebar --}}
            <div class="w-28 rounded-xl overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700">
              <div class="h-16" style="background-color: #1a2e24;"></div>
              <div class="p-2 text-center bg-white dark:bg-gray-800">
                <p class="text-xs font-bold text-gray-800 dark:text-white/90">Sidebar</p>
                <p class="text-[10px] text-gray-500 dark:text-gray-400">#1a2e24</p>
              </div>
            </div>
            {{-- Primary --}}
            <div class="w-28 rounded-xl overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700">
              <div class="h-16" style="background-color: #448646;"></div>
              <div class="p-2 text-center bg-white dark:bg-gray-800">
                <p class="text-xs font-bold text-gray-800 dark:text-white/90">Primary Btn</p>
                <p class="text-[10px] text-gray-500 dark:text-gray-400">#448646</p>
              </div>
            </div>
            {{-- Accent --}}
            <div class="w-28 rounded-xl overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700">
              <div class="h-16" style="background-color: #8fd6b0;"></div>
              <div class="p-2 text-center bg-white dark:bg-gray-800">
                <p class="text-xs font-bold text-gray-800 dark:text-white/90">Accent</p>
                <p class="text-[10px] text-gray-500 dark:text-gray-400">#8fd6b0</p>
              </div>
            </div>
            {{-- Warning --}}
            <div class="w-28 rounded-xl overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700">
              <div class="h-16" style="background-color: #d6975e;"></div>
              <div class="p-2 text-center bg-white dark:bg-gray-800">
                <p class="text-xs font-bold text-gray-800 dark:text-white/90">Warning</p>
                <p class="text-[10px] text-gray-500 dark:text-gray-400">#d6975e</p>
              </div>
            </div>
            {{-- Background --}}
            <div class="w-28 rounded-xl overflow-hidden shadow-sm border border-gray-200 dark:border-gray-700">
              <div class="h-16" style="background-color: #f1f5f9;"></div>
              <div class="p-2 text-center bg-white dark:bg-gray-800">
                <p class="text-xs font-bold text-gray-800 dark:text-white/90">Background</p>
                <p class="text-[10px] text-gray-500 dark:text-gray-400">#f1f5f9</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- ============================================ --}}
  {{-- SECTION 7: ROADMAP IMPLEMENTASI --}}
  {{-- Berdasarkan Rekomendasi Section 7 --}}
  {{-- ============================================ --}}
  <div class="grid grid-cols-12 gap-4 md:gap-6 mb-6">
    <div class="col-span-12">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-800 sm:px-6 sm:py-5">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">🚀 Roadmap Implementasi</h3>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Urutan pengerjaan fitur admin NihonLearn.</p>
        </div>
        <div class="p-5 sm:p-6">
          <div class="relative border-l-2 border-brand-200 dark:border-brand-800 ml-3 space-y-8">

            {{-- Tahap 1 --}}
            <div class="relative pl-8">
              <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-brand-500 border-2 border-white dark:border-gray-900"></div>
              <h4 class="text-sm font-bold text-gray-800 dark:text-white/90">Tahap 1: Fondasi Auth & Database</h4>
              <ul class="mt-2 space-y-1 text-sm text-gray-500 dark:text-gray-400 list-disc list-inside">
                <li>Install Auth Laravel (Breeze/UI) untuk Login Admin.</li>
                <li>Buat Migration & Model untuk <code class="text-brand-500">Article</code> dan <code class="text-brand-500">Category</code>.</li>
                <li>Setup layout dasar <code class="text-brand-500">admin.blade.php</code> (sidebar & header).</li>
              </ul>
            </div>

            {{-- Tahap 2 --}}
            <div class="relative pl-8">
              <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-brand-500 border-2 border-white dark:border-gray-900"></div>
              <h4 class="text-sm font-bold text-gray-800 dark:text-white/90">Tahap 2: Manajemen Kategori</h4>
              <ul class="mt-2 space-y-1 text-sm text-gray-500 dark:text-gray-400 list-disc list-inside">
                <li>Buat halaman CRUD (Create, Read, Update, Delete) Kategori.</li>
                <li>Pastikan kategori bisa ditambah dan dihapus.</li>
              </ul>
            </div>

            {{-- Tahap 3 --}}
            <div class="relative pl-8">
              <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-amber-400 border-2 border-white dark:border-gray-900"></div>
              <h4 class="text-sm font-bold text-gray-800 dark:text-white/90">Tahap 3: Inti Artikel (CRUD)</h4>
              <ul class="mt-2 space-y-1 text-sm text-gray-500 dark:text-gray-400 list-disc list-inside">
                <li>Buat Controller Artikel.</li>
                <li>Pasang Rich Text Editor (rekomendasi: TinyMCE/Trix).</li>
                <li>Fungsikan upload gambar Thumbnail.</li>
                <li>Buat tabel daftar artikel.</li>
              </ul>
            </div>

            {{-- Tahap 4 --}}
            <div class="relative pl-8">
              <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-gray-300 dark:bg-gray-600 border-2 border-white dark:border-gray-900"></div>
              <h4 class="text-sm font-bold text-gray-800 dark:text-white/90">Tahap 4: Finalisasi & Integrasi</h4>
              <ul class="mt-2 space-y-1 text-sm text-gray-500 dark:text-gray-400 list-disc list-inside">
                <li>Buat Dashboard Statistik (menghitung data dari database).</li>
                <li>Tampilkan data artikel ke halaman publik (Home & Halaman Artikel).</li>
              </ul>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
