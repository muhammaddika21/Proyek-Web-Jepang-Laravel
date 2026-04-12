@extends('layouts.admin')

@section('content')

  {{-- Flash Messages --}}
  @if(session('success'))
    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 dark:border-green-500/20 dark:bg-green-500/10 dark:text-green-400"
      x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)">
      {{ session('success') }}
    </div>
  @endif

  {{-- Header --}}
  <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <h2 class="text-xl font-bold text-gray-800 dark:text-white/90 sm:text-2xl">📝 Kelola Artikel</h2>
      <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Buat, edit, dan publikasikan artikel untuk website NihonLearn.</p>
    </div>
    {{-- Tombol Buat Artikel --}}
    <div x-data="{ open: false }" class="relative">
      <button @click="open = !open"
        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
        + Buat Artikel Baru
      </button>
      {{-- Dropdown Pilih Tipe --}}
      <div x-show="open" @click.away="open = false"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-64 rounded-xl border border-gray-200 bg-white shadow-lg dark:border-gray-700 dark:bg-gray-900 z-50 overflow-hidden"
        style="display:none;">
        <div class="p-3">
          <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 px-2">Pilih Tipe Artikel</p>
          <a href="{{ route('admin.articles.create') }}"
            class="flex items-center gap-3 rounded-lg px-3 py-3 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
            <div class="w-10 h-10 rounded-lg bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-lg">🏯</div>
            <div>
              <p class="text-sm font-bold text-gray-800 dark:text-white">Artikel Umum</p>
              <p class="text-[11px] text-gray-400">Budaya, Event, Pengetahuan</p>
            </div>
          </a>
          <a href="{{ route('admin.articles.createBahasa') }}"
            class="flex items-center gap-3 rounded-lg px-3 py-3 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
            <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center text-lg">🎌</div>
            <div>
              <p class="text-sm font-bold text-gray-800 dark:text-white">Artikel Bahasa</p>
              <p class="text-[11px] text-gray-400">Pembelajaran Jepang (Tae Kim style)</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>

  {{-- Statistik --}}
  <div class="grid grid-cols-2 sm:grid-cols-5 gap-4 mb-6">
    <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-4">
      <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">Total Artikel</p>
      <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $stats['total'] }}</p>
    </div>
    <div class="rounded-xl border border-green-200 bg-green-50 dark:border-green-500/20 dark:bg-green-500/10 p-4">
      <p class="text-xs text-green-600 dark:text-green-400 font-medium">Published</p>
      <p class="text-2xl font-bold text-green-700 dark:text-green-400 mt-1">{{ $stats['published'] }}</p>
    </div>
    <div class="rounded-xl border border-yellow-200 bg-yellow-50 dark:border-yellow-500/20 dark:bg-yellow-500/10 p-4">
      <p class="text-xs text-yellow-600 dark:text-yellow-400 font-medium">Draft</p>
      <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-400 mt-1">{{ $stats['draft'] }}</p>
    </div>
    <div class="rounded-xl border border-amber-200 bg-amber-50 dark:border-amber-500/20 dark:bg-amber-500/10 p-4">
      <p class="text-xs text-amber-600 dark:text-amber-400 font-medium">🏯 Artikel Umum</p>
      <p class="text-2xl font-bold text-amber-700 dark:text-amber-400 mt-1">{{ $stats['umum'] }}</p>
    </div>
    <div class="rounded-xl border border-blue-200 bg-blue-50 dark:border-blue-500/20 dark:bg-blue-500/10 p-4">
      <p class="text-xs text-blue-600 dark:text-blue-400 font-medium">🎌 Artikel Bahasa</p>
      <p class="text-2xl font-bold text-blue-700 dark:text-blue-400 mt-1">{{ $stats['bahasa'] }}</p>
    </div>
  </div>

  {{-- Filter & Search (sebagai form GET) --}}
  <form method="GET" action="{{ route('admin.articles.index') }}"
    class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] mb-6">
    <div class="p-4 flex flex-wrap items-center gap-3">
      {{-- Search --}}
      <div class="flex items-center gap-2 flex-1 min-w-[200px]">
        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        <input type="text" name="search" value="{{ request('search') }}"
          placeholder="Cari judul artikel..."
          class="w-full border-0 bg-transparent text-sm text-gray-800 dark:text-white/90 placeholder:text-gray-400 focus:outline-none focus:ring-0">
      </div>

      {{-- Filter Tipe --}}
      <select name="type" onchange="this.form.submit()"
        class="text-xs rounded-lg border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 px-3 py-2">
        <option value="all" {{ request('type','all') === 'all' ? 'selected' : '' }}>Semua Tipe</option>
        <option value="bahasa" {{ request('type') === 'bahasa' ? 'selected' : '' }}>🎌 Bahasa</option>
        <option value="umum"   {{ request('type') === 'umum'   ? 'selected' : '' }}>🏯 Umum</option>
      </select>

      {{-- Filter Kategori --}}
      <select name="category" onchange="this.form.submit()"
        class="text-xs rounded-lg border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 px-3 py-2">
        <option value="all">Semua Kategori</option>
        <optgroup label="📘 Bahasa Jepang">
          @foreach($categories->where('type', 'bahasa') as $cat)
            <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </optgroup>
        <optgroup label="🏯 Umum">
          @foreach($categories->where('type', 'umum') as $cat)
            <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
          @endforeach
        </optgroup>
      </select>

      {{-- Filter Status --}}
      <select name="status" onchange="this.form.submit()"
        class="text-xs rounded-lg border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 px-3 py-2">
        <option value="all"       {{ request('status','all') === 'all' ? 'selected' : '' }}>Semua Status</option>
        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>✅ Published</option>
        <option value="draft"     {{ request('status') === 'draft'     ? 'selected' : '' }}>📝 Draft</option>
      </select>

      {{-- Sorting --}}
      <select name="sort" onchange="this.form.submit()"
        class="text-xs rounded-lg border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 px-3 py-2">
        <option value="newest" {{ request('sort','newest') === 'newest' ? 'selected' : '' }}>↓ Terbaru</option>
        <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>↑ Terlama</option>
        <option value="views"  {{ request('sort') === 'views'  ? 'selected' : '' }}>🔥 Paling Banyak Dilihat</option>
      </select>

      {{-- Tombol Search --}}
      <button type="submit" class="px-4 py-2 text-xs bg-brand-500 text-white rounded-lg font-medium hover:bg-brand-600 transition-colors">
        Cari
      </button>
      @if(request()->hasAny(['search','type','category','status','sort']))
        <a href="{{ route('admin.articles.index') }}" class="px-3 py-2 text-xs text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
          Reset
        </a>
      @endif
    </div>
  </form>

  {{-- Table --}}
  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
    <div class="overflow-x-auto">
      <table class="w-full text-sm text-left">
        <thead>
          <tr class="border-b border-gray-100 dark:border-gray-800">
            <th class="px-6 py-4 font-medium text-gray-500 dark:text-gray-400">Judul</th>
            <th class="px-6 py-4 font-medium text-gray-500 dark:text-gray-400">Tipe</th>
            <th class="px-6 py-4 font-medium text-gray-500 dark:text-gray-400">Kategori</th>
            <th class="px-6 py-4 font-medium text-gray-500 dark:text-gray-400">Status</th>
            <th class="px-6 py-4 font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
            <th class="px-6 py-4 font-medium text-gray-500 dark:text-gray-400 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
          @forelse($articles as $article)
          <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
            <td class="px-6 py-4">
              <p class="font-medium text-gray-800 dark:text-white">{{ $article->title }}</p>
              <p class="text-xs text-gray-400 mt-0.5">
                {{ $article->read_time ? $article->read_time . ' menit baca' : '' }}
                @if($article->type === 'bahasa' && $article->quiz_questions)
                  · {{ count($article->quiz_questions) }} soal kuis
                @endif
              </p>
            </td>
            <td class="px-6 py-4">
              <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $article->type_badge }}">
                {{ $article->type === 'bahasa' ? 'Bahasa' : 'Umum' }}
              </span>
            </td>
            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
              {{ $article->category?->name ?? '-' }}
            </td>
            <td class="px-6 py-4">
              <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $article->status_badge }}">
                {{ ucfirst($article->status) }}
              </span>
            </td>
            <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
              <p class="text-sm">{{ $article->updated_at->format('d M Y') }}</p>
              <p class="text-[10px] text-gray-400">{{ $article->updated_at->format('H:i') }}</p>
            </td>
            <td class="px-6 py-4 text-right whitespace-nowrap">
              <div class="flex items-center justify-end gap-2">
                {{-- Preview --}}
                <a href="{{ route('admin.articles.show', $article) }}"
                  class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 text-gray-500 hover:bg-blue-50 hover:text-blue-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-blue-500/20 dark:hover:text-blue-400 transition-colors" title="Preview">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                </a>
                {{-- Edit --}}
                <a href="{{ route('admin.articles.edit', $article) }}"
                  class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 text-gray-500 hover:bg-brand-50 hover:text-brand-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-brand-500/20 dark:hover:text-brand-400 transition-colors" title="Edit">
                  <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                </a>
                {{-- Toggle Status --}}
                <form method="POST" action="{{ route('admin.articles.toggleStatus', $article) }}">
                  @csrf @method('PATCH')
                  <button type="submit" title="{{ $article->status === 'published' ? 'Jadikan Draft' : 'Publish' }}"
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 text-gray-500 hover:bg-green-50 hover:text-green-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-green-500/20 dark:hover:text-green-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                      @if($article->status === 'published')
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      @else
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      @endif
                    </svg>
                  </button>
                </form>
                {{-- Hapus --}}
                <form method="POST" action="{{ route('admin.articles.destroy', $article) }}"
                  onsubmit="return confirm('Yakin hapus artikel ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" title="Hapus"
                    class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-50 text-gray-500 hover:bg-red-50 hover:text-red-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-red-500/20 dark:hover:text-red-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-6 py-16 text-center">
              <div class="flex flex-col items-center gap-3">
                <span class="text-5xl">📭</span>
                <p class="text-gray-500 dark:text-gray-400 font-medium">Belum ada artikel</p>
                <a href="{{ route('admin.articles.create') }}"
                  class="text-sm text-brand-500 hover:underline">Buat artikel pertama Anda</a>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if($articles->hasPages())
    <div class="border-t border-gray-100 dark:border-gray-800 px-6 py-4 flex items-center justify-between">
      <p class="text-xs text-gray-500">
        Menampilkan {{ $articles->firstItem() }}-{{ $articles->lastItem() }} dari {{ $articles->total() }} artikel
      </p>
      <div class="flex gap-1">
        {{ $articles->links() }}
      </div>
    </div>
    @endif
  </div>

@endsection
