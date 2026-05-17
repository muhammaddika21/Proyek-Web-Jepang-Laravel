@extends('layouts.admin')

@section('content')

  {{-- ============================================ --}}
  {{-- SECTION 1: WELCOME HEADER --}}
  {{-- ============================================ --}}
  <div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white/90 sm:text-2xl">
      Okaerinasai, {{ Auth::user()->name ?? 'Admin' }}! 👋
    </h2>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
      Berikut ringkasan statistik dan aktivitas terbaru UKM NihonLearn.
    </p>
  </div>

  {{-- ============================================ --}}
  {{-- SECTION 2: STAT CARDS (Dynamic dari DB) --}}
  {{-- ============================================ --}}
  <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 md:gap-6 mb-6">

    {{-- Card 1: Total Artikel --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-[#24463a] dark:bg-[#1a2e24] md:p-6">
      <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-green-100 dark:bg-green-500/20">
        <svg class="text-green-600 dark:text-green-400" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
        </svg>
      </div>
      <div class="flex items-end justify-between mt-5">
        <div>
          <span class="text-sm text-gray-500 dark:text-gray-400">Total Artikel</span>
          <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $stats['total_articles'] }}</h4>
        </div>
      </div>
    </div>

    {{-- Card 2: Published --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-[#24463a] dark:bg-[#1a2e24] md:p-6">
      <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-100 dark:bg-emerald-500/20">
        <svg class="text-emerald-600 dark:text-emerald-400" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div class="flex items-end justify-between mt-5">
        <div>
          <span class="text-sm text-gray-500 dark:text-gray-400">Published</span>
          <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $stats['published_articles'] }}</h4>
        </div>
        <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-0.5 text-xs font-semibold text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400">Live</span>
      </div>
    </div>

    {{-- Card 3: Draft --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-[#24463a] dark:bg-[#1a2e24] md:p-6">
      <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-yellow-100 dark:bg-yellow-500/20">
        <svg class="text-yellow-600 dark:text-yellow-400" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div class="flex items-end justify-between mt-5">
        <div>
          <span class="text-sm text-gray-500 dark:text-gray-400">Draft</span>
          <h4 class="mt-2 text-2xl font-bold text-gray-800 dark:text-white/90">{{ $stats['draft_articles'] }}</h4>
        </div>
        @if($stats['draft_articles'] > 0)
          <span class="inline-flex rounded-full bg-yellow-50 px-2.5 py-0.5 text-xs font-semibold text-yellow-600 dark:bg-yellow-500/15 dark:text-yellow-400">Perlu review</span>
        @endif
      </div>
    </div>

    {{-- Card 4: Breakdown Tipe --}}
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-[#24463a] dark:bg-[#1a2e24] md:p-6">
      <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-500/20">
        <svg class="text-blue-600 dark:text-blue-400" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.75V12A2.25 2.25 0 014.5 9.75h15A2.25 2.25 0 0121.75 12v.75m-8.69-6.44l-2.12-2.12a1.5 1.5 0 00-1.061-.44H4.5A2.25 2.25 0 002.25 6v12a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9a2.25 2.25 0 00-2.25-2.25h-5.379a1.5 1.5 0 01-1.06-.44z" />
        </svg>
      </div>
      <div class="flex items-end justify-between mt-5">
        <div>
          <span class="text-sm text-gray-500 dark:text-gray-400">Breakdown</span>
          <div class="mt-2 flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 text-sm font-bold text-blue-700 dark:text-blue-400">🎌 {{ $stats['bahasa_articles'] }}</span>
            <span class="text-gray-300 dark:text-gray-600">|</span>
            <span class="inline-flex items-center gap-1.5 text-sm font-bold text-amber-700 dark:text-amber-400">🏯 {{ $stats['umum_articles'] }}</span>
          </div>
        </div>
      </div>
    </div>

  </div>

  {{-- ============================================ --}}
  {{-- SECTION 3: ARTIKEL TERBARU (Dynamic) --}}
  {{-- ============================================ --}}
  <div class="grid grid-cols-12 gap-4 md:gap-6 mb-6">

    {{-- Artikel Terbaru --}}
    <div class="col-span-12 xl:col-span-7">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24]">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-[#24463a] sm:px-6 sm:py-5 flex items-center justify-between">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            📝 Artikel Terbaru
          </h3>
          <a href="{{ route('admin.articles.index') }}"
            class="text-xs font-semibold text-emerald-500 hover:text-emerald-600 transition-colors">
            Lihat Semua →
          </a>
        </div>
        <div class="p-5 sm:p-6 overflow-x-auto">
          @if($recentArticles->count() > 0)
            <table class="w-full text-sm text-left">
              <thead>
                <tr class="border-b border-gray-100 dark:border-[#24463a]">
                  <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Judul</th>
                  <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Tipe</th>
                  <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Status</th>
                  <th class="pb-3 font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                  <th class="pb-3 font-medium text-gray-500 dark:text-gray-400 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach($recentArticles as $article)
                  <tr class="hover:bg-gray-50 dark:hover:bg-white/[0.02] transition-colors">
                    <td class="py-4 font-medium text-gray-800 dark:text-white/90 max-w-[200px] truncate">{{ $article->title }}</td>
                    <td class="py-4">
                      <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $article->type === 'bahasa' ? 'bg-blue-50 text-blue-600 dark:bg-blue-500/15 dark:text-blue-400' : 'bg-amber-50 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400' }}">
                        {{ $article->type === 'bahasa' ? '🎌 Bahasa' : '🏯 Umum' }}
                      </span>
                    </td>
                    <td class="py-4">
                      <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $article->status === 'published' ? 'bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-400' : 'bg-yellow-50 text-yellow-600 dark:bg-yellow-500/15 dark:text-yellow-400' }}">
                        {{ ucfirst($article->status) }}
                      </span>
                    </td>
                    <td class="py-4 text-gray-500 dark:text-gray-400 text-xs">{{ $article->updated_at->format('d M Y') }}</td>
                    <td class="py-4 text-right">
                      <a href="{{ route('admin.articles.show', $article) }}" class="text-gray-500 hover:text-emerald-500 dark:text-gray-400 dark:hover:text-emerald-400 mr-2 text-xs font-semibold">View</a>
                      <a href="{{ route('admin.articles.edit', $article) }}" class="text-gray-500 hover:text-emerald-500 dark:text-gray-400 dark:hover:text-emerald-400 text-xs font-semibold">Edit</a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          @else
            <div class="text-center py-10">
              <span class="text-4xl mb-3 block">📝</span>
              <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada artikel. <a href="{{ route('admin.articles.create') }}" class="text-emerald-500 hover:underline">Buat sekarang</a></p>
            </div>
          @endif
        </div>
      </div>
    </div>

    {{-- Artikel Populer --}}
    <div class="col-span-12 xl:col-span-5">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24]">
        <div class="px-5 py-4 border-b border-gray-200 dark:border-[#24463a] sm:px-6 sm:py-5">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
            🔥 Artikel Populer
          </h3>
        </div>
        <div class="p-5 sm:p-6">
          @if($popularArticles->count() > 0)
            <div class="space-y-4">
              @foreach($popularArticles as $index => $article)
                <a href="{{ route('admin.articles.show', $article) }}"
                  class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-white/[0.03] transition-colors group">
                  <span class="flex-shrink-0 w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-500/20 flex items-center justify-center text-sm font-bold text-emerald-600 dark:text-emerald-400">
                    {{ $index + 1 }}
                  </span>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90 truncate group-hover:text-emerald-500 transition-colors">{{ $article->title }}</p>
                    <div class="flex items-center gap-2 mt-1">
                      <span class="text-[10px] text-gray-400">{{ $article->category->name ?? '-' }}</span>
                      <span class="text-gray-300 dark:text-gray-600">•</span>
                      <span class="text-[10px] text-gray-400">👁 {{ number_format($article->view_count) }} views</span>
                    </div>
                  </div>
                </a>
              @endforeach
            </div>
          @else
            <div class="text-center py-10">
              <span class="text-4xl mb-3 block">📊</span>
              <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada data views.</p>
            </div>
          @endif
        </div>
      </div>
    </div>

  </div>

  {{-- ============================================ --}}
  {{-- SECTION 4: QUICK ACTIONS --}}
  {{-- ============================================ --}}
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-6">
    <a href="{{ route('admin.articles.create') }}"
      class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24] p-5 hover:border-emerald-300 dark:hover:border-emerald-700 hover:shadow-lg transition-all group">
      <span class="text-2xl mb-3 block">🏯</span>
      <h4 class="text-sm font-bold text-gray-800 dark:text-white/90 group-hover:text-emerald-500 transition-colors">Buat Artikel Umum</h4>
      <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Budaya, Event, Pengetahuan</p>
    </a>
    <a href="{{ route('admin.articles.createBahasa') }}"
      class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24] p-5 hover:border-blue-300 dark:hover:border-blue-700 hover:shadow-lg transition-all group">
      <span class="text-2xl mb-3 block">🎌</span>
      <h4 class="text-sm font-bold text-gray-800 dark:text-white/90 group-hover:text-blue-500 transition-colors">Buat Artikel Bahasa</h4>
      <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Pembelajaran Jepang (Quill Editor)</p>
    </a>
    <a href="{{ route('admin.articles.index') }}"
      class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24] p-5 hover:border-amber-300 dark:hover:border-amber-700 hover:shadow-lg transition-all group">
      <span class="text-2xl mb-3 block">📋</span>
      <h4 class="text-sm font-bold text-gray-800 dark:text-white/90 group-hover:text-amber-500 transition-colors">Kelola Artikel</h4>
      <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Edit, hapus, ubah status</p>
    </a>
  </div>

  {{-- ============================================ --}}
  {{-- SECTION 5: COLOR PALETTE --}}
  {{-- ============================================ --}}
  <div class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24] mb-6">
    <div class="px-5 py-4 border-b border-gray-200 dark:border-[#24463a] sm:px-6 sm:py-5">
      <h3 class="text-base font-medium text-gray-800 dark:text-white/90">🎨 Color Palette UKM NihonLearn</h3>
      <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Panduan warna resmi proyek.</p>
    </div>
    <div class="p-5 sm:p-6">
      <div class="flex flex-wrap gap-4">
        @php
          $colors = [
            ['name' => 'Hijau Tua',  'hex' => '#448646'],
            ['name' => 'Hijau Soft', 'hex' => '#80b68b'],
            ['name' => 'Forest',     'hex' => '#296751'],
            ['name' => 'Cream',      'hex' => '#f8f7ef'],
            ['name' => 'Gold',       'hex' => '#d6975e'],
            ['name' => 'Olive',      'hex' => '#404235'],
          ];
        @endphp
        @foreach($colors as $c)
          <div class="w-28 rounded-xl overflow-hidden shadow-sm border border-gray-200 dark:border-[#24463a]">
            <div class="h-16" style="background-color: {{ $c['hex'] }};"></div>
            <div class="p-2 text-center bg-white dark:bg-[#24463a]">
              <p class="text-xs font-bold text-gray-800 dark:text-white/90">{{ $c['name'] }}</p>
              <p class="text-[10px] text-gray-500 dark:text-gray-400">{{ $c['hex'] }}</p>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

@endsection
