@extends('layouts.admin')

@section('content')

  {{-- Header & Breadcrumb --}}
  <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <div>
      <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-2">
        <a href="{{ route('admin.articles.index') }}" class="hover:text-brand-500">Kelola Artikel</a>
        <span>›</span>
        <span class="font-medium text-gray-800 dark:text-white/90">Preview Artikel</span>
      </div>
      <h2 class="text-xl font-bold text-gray-800 dark:text-white/90 sm:text-2xl">
        {{ $article->type === 'bahasa' ? '🎌' : '🏯' }} Preview Artikel
      </h2>
    </div>
    <div class="flex items-center gap-3 flex-wrap">
      @if($article->type === 'bahasa' && $article->kemahiran_level)
        @php
          $levelConfig = [
            'pemula'   => ['🌱', 'bg-green-50 text-green-700 dark:bg-green-500/15 dark:text-green-400'],
            'menengah' => ['🌿', 'bg-yellow-50 text-yellow-700 dark:bg-yellow-500/15 dark:text-yellow-400'],
            'mahir'    => ['🌳', 'bg-red-50 text-red-700 dark:bg-red-500/15 dark:text-red-400'],
          ];
          $lc = $levelConfig[$article->kemahiran_level] ?? ['📚', 'bg-gray-100 text-gray-600'];
        @endphp
        <span class="inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-bold {{ $lc[1] }}">
          {{ $lc[0] }} {{ ucfirst($article->kemahiran_level) }}
        </span>
      @endif
      <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $article->status_badge }}">
        {{ ucfirst($article->status) }}
      </span>
      <a href="{{ route('admin.articles.edit', $article) }}"
        class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:hover:bg-white/5 transition-colors">
        ✏️ Edit Artikel
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

    {{-- =============== MAIN CONTENT =============== --}}
    <div class="xl:col-span-8 space-y-6">

      {{-- Cover Image --}}
      @if($article->cover_image)
        <div class="overflow-hidden rounded-2xl border border-gray-200 dark:border-gray-800 shadow-sm">
          <img src="{{ asset('storage/' . $article->cover_image) }}"
            alt="Cover {{ $article->title }}"
            class="w-full h-auto object-cover max-h-[420px]">
          @if($article->cover_image_caption)
            <div class="px-6 py-3 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40">
              <p class="text-xs italic text-gray-500 dark:text-gray-400 text-center">{{ $article->cover_image_caption }}</p>
            </div>
          @endif
        </div>
      @endif

      {{-- Article Header & Content --}}
      <div class="rounded-2xl border border-gray-200 bg-white px-8 py-8 dark:border-gray-800 dark:bg-white/[0.03]">
        <div class="flex items-center gap-2 mb-4 flex-wrap">
          <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold {{ $article->type_badge }}">
            {{ $article->type === 'bahasa' ? '🎌 Bahasa' : '🏯 Umum' }}
          </span>
          @if($article->category)
            <span class="text-gray-400">•</span>
            <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ $article->category->name }}</span>
          @endif
          @if($article->read_time)
            <span class="text-gray-400">•</span>
            <span class="text-xs text-gray-400">⏱ {{ $article->read_time }} menit baca</span>
          @endif
        </div>

        <h1 class="text-3xl font-bold text-gray-900 dark:text-white leading-tight mb-4">{{ $article->title }}</h1>

        @if($article->type === 'bahasa' && ($article->japanese_title || $article->romaji_title))
          <div class="mb-6 p-5 rounded-xl bg-blue-50 dark:bg-blue-500/10 border border-blue-100 dark:border-blue-500/20">
            @if($article->japanese_title)
              <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $article->japanese_title }}</p>
            @endif
            @if($article->romaji_title)
              <p class="text-sm italic text-gray-500 dark:text-gray-400 mt-1">{{ $article->romaji_title }}</p>
            @endif
          </div>
        @endif

        @if($article->excerpt)
          <div class="mb-6 border-l-4 border-brand-500 pl-4 py-1">
            <p class="text-base text-gray-600 dark:text-gray-400 font-medium leading-relaxed italic">{{ $article->excerpt }}</p>
          </div>
        @endif

        @php $konten = $article->type === 'bahasa' ? $article->grammar_explanation : $article->content; @endphp
        @if($konten)
          <div class="prose prose-sm dark:prose-invert max-w-none text-gray-700 dark:text-gray-300 leading-relaxed">
            {!! $konten !!}
          </div>
        @else
          <div class="flex flex-col items-center py-10 text-gray-400">
            <span class="text-4xl mb-2">📄</span>
            <p class="text-sm italic">Belum ada konten artikel.</p>
          </div>
        @endif
      </div>

      {{-- Kosakata Table --}}
      @if($article->type === 'bahasa' && $article->vocabulary_list && count($article->vocabulary_list) > 0)
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 bg-blue-50/30 dark:bg-transparent">
            <h3 class="text-base font-bold text-gray-800 dark:text-white/90">📖 Daftar Kosakata</h3>
            <p class="text-xs text-gray-500 mt-1">{{ count($article->vocabulary_list) }} entri kosakata</p>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-white/[0.02]">
                  <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Kanji / Kata</th>
                  <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Romaji</th>
                  <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Arti</th>
                  @if(collect($article->vocabulary_list)->contains(fn($v) => !empty($v['contoh'])))
                    <th class="px-6 py-3 text-left font-semibold text-gray-500 dark:text-gray-400">Contoh</th>
                  @endif
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach($article->vocabulary_list as $vocab)
                  <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                    <td class="px-6 py-3 font-bold text-gray-800 dark:text-white text-lg">{{ $vocab['kata'] ?? '-' }}</td>
                    <td class="px-6 py-3 text-gray-500 italic dark:text-gray-400">{{ $vocab['romaji'] ?? '-' }}</td>
                    <td class="px-6 py-3 text-gray-800 dark:text-gray-300">{{ $vocab['arti'] ?? '-' }}</td>
                    @if(collect($article->vocabulary_list)->contains(fn($v) => !empty($v['contoh'])))
                      <td class="px-6 py-3 text-gray-500 dark:text-gray-400 font-medium">{{ $vocab['contoh'] ?? '' }}</td>
                    @endif
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      @endif

      {{-- ============================================= --}}
      {{-- SECTION: MEDIA TAMBAHAN (Gambar, Audio, YouTube) --}}
      {{-- Posisi: setelah Kosakata, sebelum Kuis --}}
      {{-- ============================================= --}}
      @if(($article->additional_images && count($article->additional_images) > 0) || $article->audio_file || $article->youtube_url)
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 bg-indigo-50/30 dark:bg-transparent">
            <h3 class="text-base font-bold text-gray-800 dark:text-white/90">📎 Media Tambahan</h3>
            <p class="text-xs text-gray-500 mt-1">Semua media yang telah ditambahkan ke artikel ini.</p>
          </div>
          <div class="p-6 space-y-8">

            {{-- === Galeri Foto === --}}
            @if($article->additional_images && count($article->additional_images) > 0)
              <div>
                <div class="flex items-center gap-2 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center text-sm">🖼️</span>
                  <div>
                    <h4 class="text-sm font-bold text-gray-800 dark:text-white">Galeri Foto</h4>
                    <p class="text-xs text-gray-500">{{ count($article->additional_images) }} gambar terlampir</p>
                  </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                  @foreach($article->additional_images as $index => $imgPath)
                    <div class="group relative overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 aspect-[4/3] cursor-pointer"
                      x-data="{ showFull: false }">
                      {{-- Thumbnail --}}
                      <img src="{{ asset('storage/' . $imgPath) }}"
                        alt="Foto tambahan {{ $index + 1 }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                        @click="showFull = true">
                      {{-- Overlay info on hover --}}
                      <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent px-3 py-2.5 opacity-0 group-hover:opacity-100 transition-opacity">
                        <p class="text-[10px] text-white font-mono truncate">{{ basename($imgPath) }}</p>
                        <p class="text-[9px] text-white/60 mt-0.5">Klik untuk perbesar</p>
                      </div>
                      {{-- Fullscreen Modal --}}
                      <div x-show="showFull" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                        class="fixed inset-0 z-[999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4"
                        @click.self="showFull = false" @keydown.escape.window="showFull = false"
                        style="display: none;">
                        <div class="relative max-w-4xl w-full">
                          <img src="{{ asset('storage/' . $imgPath) }}"
                            alt="Foto tambahan {{ $index + 1 }}"
                            class="w-full h-auto max-h-[85vh] object-contain rounded-xl shadow-2xl">
                          <div class="mt-3 text-center">
                            <p class="text-sm text-white/80 font-mono">{{ basename($imgPath) }}</p>
                          </div>
                          <button @click="showFull = false"
                            class="absolute -top-3 -right-3 w-9 h-9 bg-white dark:bg-gray-800 text-gray-800 dark:text-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-lg leading-none">
                            ✕
                          </button>
                        </div>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endif

            {{-- === Audio Player === --}}
            @if($article->audio_file)
              <div>
                <div class="flex items-center gap-2 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-500/20 flex items-center justify-center text-sm">🎵</span>
                  <div>
                    <h4 class="text-sm font-bold text-gray-800 dark:text-white">
                      {{ $article->audio_label ?: 'Audio' }}
                    </h4>
                    <p class="text-xs text-gray-500 font-mono">{{ basename($article->audio_file) }}</p>
                  </div>
                </div>
                <div class="rounded-xl border border-purple-200 dark:border-purple-500/30 bg-purple-50 dark:bg-purple-500/5 p-4">
                  <audio controls class="w-full" preload="metadata">
                    <source src="{{ asset('storage/' . $article->audio_file) }}" type="audio/mpeg">
                    <source src="{{ asset('storage/' . $article->audio_file) }}" type="audio/wav">
                    <source src="{{ asset('storage/' . $article->audio_file) }}" type="audio/ogg">
                    Browser Anda tidak mendukung pemutar audio.
                  </audio>
                  <div class="mt-2 flex items-center justify-between">
                    <p class="text-[10px] text-purple-500/70">Klik tombol play ▶ untuk mendengarkan</p>
                    <a href="{{ asset('storage/' . $article->audio_file) }}" download
                      class="text-[10px] text-purple-600 dark:text-purple-400 hover:underline font-medium">
                      ⬇ Download
                    </a>
                  </div>
                </div>
              </div>
            @endif

            {{-- === YouTube Embed === --}}
            @if($article->youtube_url)
              @php
                // Extract YouTube video ID
                preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $article->youtube_url, $matches);
                $ytId = $matches[1] ?? null;
              @endphp
              <div>
                <div class="flex items-center gap-2 mb-4">
                  <span class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-500/20 flex items-center justify-center text-sm">▶️</span>
                  <div>
                    <h4 class="text-sm font-bold text-gray-800 dark:text-white">Video YouTube</h4>
                    <a href="{{ $article->youtube_url }}" target="_blank" class="text-xs text-brand-500 hover:underline truncate block max-w-xs">{{ $article->youtube_url }}</a>
                  </div>
                </div>
                @if($ytId)
                  <div class="rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 aspect-video">
                    <iframe src="https://www.youtube.com/embed/{{ $ytId }}"
                      class="w-full h-full"
                      frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                      allowfullscreen>
                    </iframe>
                  </div>
                @else
                  <div class="rounded-xl border border-yellow-200 bg-yellow-50 dark:border-yellow-500/30 dark:bg-yellow-500/10 p-4">
                    <p class="text-xs text-yellow-700 dark:text-yellow-400">⚠️ URL YouTube tidak valid. Pastikan formatnya benar.</p>
                  </div>
                @endif
              </div>
            @endif

          </div>
        </div>
      @endif

      {{-- Kuis Review --}}
      @if($article->type === 'bahasa' && $article->quiz_questions && count($article->quiz_questions) > 0)
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] overflow-hidden">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800 bg-emerald-50/30 dark:bg-transparent">
            <h3 class="text-base font-bold text-gray-800 dark:text-white/90">🧠 Kuis Review</h3>
            <p class="text-xs text-gray-500 mt-1">
              {{ count($article->quiz_questions) }} soal — <span class="text-emerald-600 dark:text-emerald-400 font-semibold">kunci jawaban berwarna hijau</span>
            </p>
          </div>
          <div class="p-6 space-y-6">
            @foreach($article->quiz_questions as $index => $quiz)
              <div class="p-5 rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50/30 dark:bg-white/[0.02]">
                <p class="font-bold text-gray-800 dark:text-white mb-4 text-base">
                  Soal #{{ $index + 1 }}: {{ $quiz['question'] }}
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                  @foreach($quiz['options'] as $oIndex => $opt)
                    @php $isCorrect = (int)$quiz['answer'] === $oIndex; @endphp
                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border transition-colors
                      {{ $isCorrect
                        ? 'border-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 dark:border-emerald-500/40'
                        : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-white/[0.02]' }}">
                      <span class="flex-shrink-0 flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold
                        {{ $isCorrect
                          ? 'bg-emerald-500 text-white'
                          : 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-400' }}">
                        {{ chr(65 + $oIndex) }}
                      </span>
                      <span class="text-sm {{ $isCorrect
                        ? 'font-bold text-emerald-700 dark:text-emerald-300'
                        : 'text-gray-700 dark:text-gray-300' }}">
                        {{ $opt }}
                      </span>
                      @if($isCorrect)
                        <span class="ml-auto text-emerald-500 dark:text-emerald-400">
                          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                          </svg>
                        </span>
                      @endif
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

    </div>

    {{-- =============== SIDEBAR INFO =============== --}}
    <div class="xl:col-span-4 space-y-6">

      {{-- Meta Info Card --}}
      <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Informasi Artikel</h4>
        <div class="space-y-3">
          <div class="flex items-start justify-between gap-3 text-sm">
            <span class="text-gray-500">Penulis</span>
            <span class="font-medium text-gray-800 dark:text-white text-right">{{ $article->user?->name ?? 'Admin' }}</span>
          </div>
          <div class="flex items-start justify-between gap-3 text-sm">
            <span class="text-gray-500">Dibuat</span>
            <span class="font-medium text-gray-800 dark:text-white text-right">{{ $article->created_at->format('d M Y, H:i') }}</span>
          </div>
          <div class="flex items-start justify-between gap-3 text-sm">
            <span class="text-gray-500">Diperbarui</span>
            <span class="font-medium text-gray-800 dark:text-white text-right">{{ $article->updated_at->format('d M Y, H:i') }}</span>
          </div>
          @if($article->published_at)
            <div class="flex items-start justify-between gap-3 text-sm">
              <span class="text-gray-500">Dipublikasikan</span>
              <span class="font-medium text-gray-800 dark:text-white text-right">{{ $article->published_at->format('d M Y, H:i') }}</span>
            </div>
          @endif
          <hr class="my-2 dark:border-gray-800">
          <div class="text-sm">
            <p class="text-gray-500 mb-1.5">Slug:</p>
            <code class="block w-full px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-xs text-brand-500 break-all">{{ $article->slug }}</code>
          </div>
          <div class="text-sm">
            <p class="text-gray-500 mb-1.5">URL Publik kelak:</p>
            <code class="block w-full px-3 py-2 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-800 text-xs text-gray-500 break-all">
              /{{ $article->type === 'bahasa' ? 'bahasa' : 'artikel' }}/{{ $article->slug }}
            </code>
          </div>
        </div>
      </div>

      {{-- Media Checklist Card --}}
      <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Checklist Media</h4>
        <div class="space-y-4">

          {{-- Cover Image --}}
          <div>
            <div class="flex items-center gap-3 text-sm">
              <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ $article->cover_image ? 'bg-green-100 dark:bg-green-500/20 text-green-600' : 'bg-gray-100 dark:bg-gray-800 text-gray-400' }}">🖼️</span>
              <div class="flex-1 min-w-0">
                <p class="{{ $article->cover_image ? 'text-gray-800 dark:text-white' : 'text-gray-400' }}">Cover Image</p>
                @if($article->cover_image)
                  <p class="text-[10px] text-gray-400 font-mono truncate">{{ basename($article->cover_image) }}</p>
                @endif
              </div>
              @if($article->cover_image)
                <span class="text-xs font-bold text-green-600 dark:text-green-400">✓</span>
              @else
                <span class="text-xs text-gray-400">—</span>
              @endif
            </div>
            {{-- Cover Image Thumbnail --}}
            @if($article->cover_image)
              <div class="mt-2 ml-11">
                <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 w-full h-24">
                  <img src="{{ asset('storage/' . $article->cover_image) }}"
                    alt="Cover thumbnail"
                    class="w-full h-full object-cover">
                </div>
              </div>
            @endif
          </div>

          {{-- Additional Images --}}
          <div>
            <div class="flex items-center gap-3 text-sm">
              <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ $article->additional_images && count($article->additional_images) > 0 ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600' : 'bg-gray-100 dark:bg-gray-800 text-gray-400' }}">🗂️</span>
              <div class="flex-1 min-w-0">
                <p class="{{ $article->additional_images && count($article->additional_images) > 0 ? 'text-gray-800 dark:text-white' : 'text-gray-400' }}">Foto Tambahan</p>
              </div>
              @if($article->additional_images && count($article->additional_images) > 0)
                <span class="text-xs font-bold text-blue-600 dark:text-blue-400">{{ count($article->additional_images) }} foto</span>
              @else
                <span class="text-xs text-gray-400">—</span>
              @endif
            </div>
            {{-- Image Thumbnails Grid --}}
            @if($article->additional_images && count($article->additional_images) > 0)
              <div class="mt-2 ml-11 grid grid-cols-3 gap-1.5">
                @foreach($article->additional_images as $idx => $imgPath)
                  <div class="rounded-md overflow-hidden border border-gray-200 dark:border-gray-700 aspect-square cursor-pointer group"
                    x-data="{ showModal: false }">
                    <img src="{{ asset('storage/' . $imgPath) }}"
                      alt="Foto {{ $idx + 1 }}"
                      class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-200"
                      @click="showModal = true">
                    {{-- Fullscreen Modal --}}
                    <div x-show="showModal" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                      class="fixed inset-0 z-[999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4"
                      @click.self="showModal = false" @keydown.escape.window="showModal = false"
                      style="display: none;">
                      <div class="relative max-w-4xl w-full">
                        <img src="{{ asset('storage/' . $imgPath) }}"
                          alt="Foto {{ $idx + 1 }}"
                          class="w-full h-auto max-h-[85vh] object-contain rounded-xl shadow-2xl">
                        <div class="mt-3 text-center">
                          <p class="text-sm text-white/80 font-mono">{{ basename($imgPath) }}</p>
                        </div>
                        <button @click="showModal = false"
                          class="absolute -top-3 -right-3 w-9 h-9 bg-white dark:bg-gray-800 text-gray-800 dark:text-white rounded-full flex items-center justify-center shadow-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-lg leading-none">
                          ✕
                        </button>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>

          {{-- Audio --}}
          <div>
            <div class="flex items-center gap-3 text-sm">
              <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ $article->audio_file ? 'bg-purple-100 dark:bg-purple-500/20 text-purple-600' : 'bg-gray-100 dark:bg-gray-800 text-gray-400' }}">🎵</span>
              <div class="flex-1 min-w-0">
                <p class="{{ $article->audio_file ? 'text-gray-800 dark:text-white' : 'text-gray-400' }}">
                  {{ $article->audio_label ?: 'Audio' }}
                </p>
                @if($article->audio_file)
                  <p class="text-[10px] text-gray-400 font-mono truncate">{{ basename($article->audio_file) }}</p>
                @endif
              </div>
              @if($article->audio_file)
                <span class="text-xs font-bold text-purple-600 dark:text-purple-400">✓</span>
              @else
                <span class="text-xs text-gray-400">—</span>
              @endif
            </div>
            {{-- Mini Audio Player --}}
            @if($article->audio_file)
              <div class="mt-2 ml-11">
                <div class="rounded-lg border border-purple-200 dark:border-purple-500/30 bg-purple-50 dark:bg-purple-500/5 p-2.5">
                  <audio controls class="w-full h-8" style="height: 32px;" preload="metadata">
                    <source src="{{ asset('storage/' . $article->audio_file) }}" type="audio/mpeg">
                    <source src="{{ asset('storage/' . $article->audio_file) }}" type="audio/wav">
                    <source src="{{ asset('storage/' . $article->audio_file) }}" type="audio/ogg">
                  </audio>
                </div>
              </div>
            @endif
          </div>

          {{-- YouTube --}}
          <div>
            <div class="flex items-center gap-3 text-sm">
              <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ $article->youtube_url ? 'bg-red-100 dark:bg-red-500/20 text-red-600' : 'bg-gray-100 dark:bg-gray-800 text-gray-400' }}">▶️</span>
              <div class="flex-1 min-w-0">
                <p class="{{ $article->youtube_url ? 'text-gray-800 dark:text-white' : 'text-gray-400' }}">YouTube</p>
                @if($article->youtube_url)
                  <p class="text-[10px] text-gray-400 truncate">{{ $article->youtube_url }}</p>
                @endif
              </div>
              @if($article->youtube_url)
                <span class="text-xs font-bold text-red-600 dark:text-red-400">✓</span>
              @else
                <span class="text-xs text-gray-400">—</span>
              @endif
            </div>
            {{-- Mini YouTube Preview --}}
            @if($article->youtube_url)
              @php
                preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $article->youtube_url, $ytMatches);
                $ytThumbId = $ytMatches[1] ?? null;
              @endphp
              @if($ytThumbId)
                <div class="mt-2 ml-11">
                  <a href="{{ $article->youtube_url }}" target="_blank" class="block relative rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 aspect-video group">
                    <img src="https://img.youtube.com/vi/{{ $ytThumbId }}/mqdefault.jpg"
                      alt="YouTube thumbnail"
                      class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200">
                    {{-- Play button overlay --}}
                    <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/30 transition-colors">
                      <div class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                      </div>
                    </div>
                  </a>
                </div>
              @endif
            @endif
          </div>

        </div>
      </div>

      {{-- Quick Actions Card --}}
      <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h4 class="text-xs font-bold uppercase tracking-widest text-gray-400 mb-4">Aksi Cepat</h4>
        <div class="space-y-3">
          <form method="POST" action="{{ route('admin.articles.toggleStatus', $article) }}">
            @csrf @method('PATCH')
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition-colors
              {{ $article->status === 'published'
                ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200 dark:bg-yellow-500/10 dark:text-yellow-400 dark:hover:bg-yellow-500/20'
                : 'bg-emerald-500 text-white hover:bg-emerald-600' }}">
              {{ $article->status === 'published' ? '⚠️ Kembalikan ke Draft' : '✅ Publikasikan Sekarang' }}
            </button>
          </form>
          <a href="{{ route('admin.articles.edit', $article) }}"
            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-brand-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-600 transition-colors">
            ✏️ Edit Artikel
          </a>
          <a href="{{ route('admin.articles.index') }}"
            class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-gray-100 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700 transition-colors">
            ← Kembali ke Daftar
          </a>
        </div>
      </div>

    </div>
  </div>
@endsection
