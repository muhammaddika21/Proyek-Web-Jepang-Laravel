@extends('layouts.admin')

@push('styles')
{{-- Quill Snow Theme --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
  /* Quill editor dark mode support */
  .dark .ql-toolbar {
    background-color: #1d2939;
    border-color: #374151 !important;
  }
  .dark .ql-container {
    background-color: #111827;
    border-color: #374151 !important;
    color: rgba(255,255,255,0.9);
  }
  .dark .ql-toolbar .ql-stroke { stroke: #9ca3af; }
  .dark .ql-toolbar .ql-fill { fill: #9ca3af; }
  .dark .ql-toolbar .ql-picker-label { color: #9ca3af; }
  .dark .ql-toolbar button:hover .ql-stroke,
  .dark .ql-toolbar button.ql-active .ql-stroke { stroke: #ffffff; }
  .dark .ql-toolbar button:hover .ql-fill,
  .dark .ql-toolbar button.ql-active .ql-fill { fill: #ffffff; }
  .dark .ql-editor.ql-blank::before { color: rgba(255,255,255,0.3); }
  .dark .ql-picker-options { background-color: #1d2939; border-color: #374151; }
  .dark .ql-picker-item { color: #9ca3af; }
  .ql-editor { min-height: 320px; font-size: 14px; line-height: 1.8; }
  .ql-toolbar.ql-snow { border-radius: 0.5rem 0.5rem 0 0; }
  .ql-container.ql-snow { border-radius: 0 0 0.5rem 0.5rem; }

  /* Quill furigana/Japanese font support */
  .ql-editor {
    font-family: 'Noto Sans JP', -apple-system, sans-serif;
  }

  /* Media Upload Area */
  .media-drop-zone { transition: all 0.2s ease; }
  .media-drop-zone.drag-over {
    border-color: #448646;
    background-color: rgba(68, 134, 70, 0.08);
  }
  .media-drop-zone.has-file {
    border-color: #448646;
    background-color: rgba(68, 134, 70, 0.05);
  }
  .file-preview-item { animation: fadeIn 0.3s ease; }
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
  }
</style>
@endpush

@section('content')

  {{-- Breadcrumb --}}
  <div class="mb-6">
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-3">
      <a href="{{ route('admin.articles.index') }}" class="hover:text-brand-500">Kelola Artikel</a>
      <span>›</span>
      <span class="text-gray-800 dark:text-white/90 font-medium">Edit Artikel Bahasa</span>
    </div>
    <h2 class="text-xl font-bold text-gray-800 dark:text-white/90 sm:text-2xl">🎌 Edit: {{ $article->title }}</h2>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pembelajaran gaya Tae Kim — konten + tabel referensi + audio + kuis review.</p>
  </div>

  <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" id="bahasa-edit-form">
    @csrf
    @method('PUT')
    <input type="hidden" name="type" value="bahasa">

    <div class="grid grid-cols-1 xl:grid-cols-10 gap-6">

      {{-- =================== KOLOM KIRI (70%) =================== --}}
      <div class="xl:col-span-7 space-y-6">

        {{-- ===== SECTION A: Info Dasar ===== --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
          x-data="{
            title: '{{ old('title', addslashes($article->title)) }}',
            slug: '{{ old('slug', $article->slug) }}',
            autoSlug: false,
            generateSlug(text) {
              return text.toLowerCase()
                .replace(/[àáâãäå]/g, 'a').replace(/[èéêë]/g, 'e').replace(/[ìíîï]/g, 'i')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            }
          }">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">📌 Informasi Dasar</h3>
          </div>
          <div class="p-6 space-y-5">
            <div>
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Judul Artikel</label>
              <input type="text" name="title" x-model="title"
                @input="if(autoSlug) slug = generateSlug(title)"
                placeholder="Misal: Kata Tunjuk dalam Bahasa Jepang"
                class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
            </div>
            <div>
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Slug (URL)
                <span class="text-xs text-gray-400 font-normal ml-1" x-show="autoSlug">— auto-generate dari judul</span>
              </label>
              <input type="text" name="slug" x-model="slug"
                @input="autoSlug = false"
                placeholder="kata-tunjuk-bahasa-jepang"
                class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 font-mono">
              <p class="text-[10px] text-gray-400 mt-1" x-show="slug">Akan tampil di: <span class="text-brand-500">ukmnihon.com/bahasa/<span x-text="slug"></span></span></p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kategori Bahasa</label>
                <select name="category_id"
                  class="shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden">
                  <option value="">Pilih...</option>
                  @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Level Kemahiran</label>
                <select name="kemahiran_level"
                  class="shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden">
                  <option value="">Pilih...</option>
                  <option value="pemula"   {{ old('kemahiran_level', $article->kemahiran_level) === 'pemula'   ? 'selected' : '' }}>🌱 Pemula</option>
                  <option value="menengah" {{ old('kemahiran_level', $article->kemahiran_level) === 'menengah' ? 'selected' : '' }}>🌿 Menengah</option>
                  <option value="mahir"    {{ old('kemahiran_level', $article->kemahiran_level) === 'mahir'    ? 'selected' : '' }}>🌳 Mahir</option>
                </select>
              </div>
            </div>
          </div>
        </div>{{-- END Section A --}}

        {{-- ===== SECTION B: Konten Pembelajaran (Quill.js) ===== --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">📖 Konten Pembelajaran</h3>
            <p class="text-xs text-gray-500 mt-1">Tulis penjelasan materi, grammar, contoh kalimat. Mendukung furigana dan karakter Jepang.</p>
          </div>
          <div class="p-6">
            {{-- Hidden textarea untuk menyimpan konten HTML ke server --}}
            <textarea name="content" id="content-bahasa-input" style="display:none;">{{ old('content', $article->grammar_explanation) }}</textarea>
            {{-- Quill Editor Container --}}
            <div id="quill-editor-bahasa"></div>
          </div>
        </div>{{-- END Section B --}}

        {{-- ===== SECTION C: Tabel Kosakata / Karakter ===== --}}
        @php
          $vocabData = old('vocabulary_list') ?? ($article->vocabulary_list ? collect($article->vocabulary_list)->map(fn($v) => [
            'kanji' => $v['kata'] ?? '',
            'furigana' => $v['romaji'] ?? '',
            'meaning' => $v['arti'] ?? '',
            'example' => $v['contoh'] ?? ''
          ])->toArray() : [['kanji' => '', 'furigana' => '', 'meaning' => '', 'example' => '']]);
        @endphp
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
          x-data="{
            rows: {{ json_encode(array_values($vocabData)) }},
            addRow() {
              this.rows.push({ kanji: '', furigana: '', meaning: '', example: '' });
            },
            removeRow(index) {
              if (this.rows.length > 1) this.rows.splice(index, 1);
            }
          }">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">📋 Tabel Kosakata / Referensi</h3>
            <p class="text-xs text-gray-500 mt-1">Tabel karakter, kosakata, atau pola kalimat. Bisa ditambah/dihapus.</p>
          </div>
          <div class="p-6">
            <div class="overflow-x-auto">
              <table class="w-full text-sm">
                <thead>
                  <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                    <th class="pb-3 pr-3 font-medium text-gray-500 dark:text-gray-400 min-w-[120px]">Kanji / Karakter</th>
                    <th class="pb-3 pr-3 font-medium text-gray-500 dark:text-gray-400 min-w-[120px]">Furigana / Romaji</th>
                    <th class="pb-3 pr-3 font-medium text-gray-500 dark:text-gray-400 min-w-[120px]">Arti (Indonesia)</th>
                    <th class="pb-3 pr-3 font-medium text-gray-500 dark:text-gray-400 min-w-[180px]">Contoh Kalimat</th>
                    <th class="pb-3 w-10"></th>
                  </tr>
                </thead>
                <tbody>
                  <template x-for="(row, index) in rows" :key="index">
                    <tr class="border-b border-gray-100 dark:border-gray-800">
                      <td class="py-2 pr-2">
                        <input x-model="row.kanji" type="text" placeholder="これ"
                          :name="'vocabulary_list[' + index + '][kata]'"
                          class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 focus:border-brand-300 focus:ring-1 focus:ring-brand-500/10 focus:outline-hidden" style="font-size: 16px;">
                      </td>
                      <td class="py-2 pr-2">
                        <input x-model="row.furigana" type="text" placeholder="kore"
                          :name="'vocabulary_list[' + index + '][romaji]'"
                          class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 focus:border-brand-300 focus:ring-1 focus:ring-brand-500/10 focus:outline-hidden">
                      </td>
                      <td class="py-2 pr-2">
                        <input x-model="row.meaning" type="text" placeholder="ini"
                          :name="'vocabulary_list[' + index + '][arti]'"
                          class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 focus:border-brand-300 focus:ring-1 focus:ring-brand-500/10 focus:outline-hidden">
                      </td>
                      <td class="py-2 pr-2">
                        <input x-model="row.example" type="text" placeholder="これは本です"
                          :name="'vocabulary_list[' + index + '][contoh]'"
                          class="w-full rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 focus:border-brand-300 focus:ring-1 focus:ring-brand-500/10 focus:outline-hidden">
                      </td>
                      <td class="py-2">
                        <button type="button" @click="removeRow(index)" class="text-red-400 hover:text-red-500 p-1">
                          <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
            <button type="button" @click="addRow()"
              class="mt-4 flex items-center gap-2 text-sm font-medium text-brand-500 hover:text-brand-600 transition-colors">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
              Tambah Baris
            </button>
          </div>
        </div>{{-- END Section C --}}

        {{-- ===== SECTION D: Media (Audio, Gambar, Video, YouTube) ===== --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
          x-data="{
            mediaType: 'audio',
            audioFile: null,
            imageFiles: [],
            videoFile: null,
            formatBytes(bytes) {
              if (bytes < 1024) return bytes + ' B';
              if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
              return (bytes / 1048576).toFixed(1) + ' MB';
            },
            handleAudioChange(e) {
              const f = e.target.files[0];
              if (f) this.audioFile = { name: f.name, size: f.size };
            },
            handleImageDrop(e) {
              const files = Array.from(e.dataTransfer?.files || e.target.files || []);
              files.forEach(f => {
                if (f.type.startsWith('image/') && this.imageFiles.length < 5) {
                  const reader = new FileReader();
                  reader.onload = ev => this.imageFiles.push({ name: f.name, size: f.size, preview: ev.target.result });
                  reader.readAsDataURL(f);
                }
              });
            },
            handleVideoChange(e) {
              const f = e.target.files[0];
              if (f) this.videoFile = { name: f.name, size: f.size };
            },
            removeImage(i) { this.imageFiles.splice(i, 1); }
          }">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">📎 Media Tambahan</h3>
            <p class="text-xs text-gray-500 mt-1">Upload gambar, video, audio, atau embed YouTube.</p>
          </div>
          <div class="p-6">

            {{-- Existing media info --}}
            @if($article->audio_file || $article->youtube_url || ($article->additional_images && count($article->additional_images) > 0))
            <div class="mb-5 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50 p-4">
              <p class="text-xs font-medium text-gray-600 dark:text-gray-300 mb-2">📂 Media saat ini:</p>
              <div class="space-y-1.5">
                @if($article->audio_file)
                  <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <span>🎧</span>
                    <span>Audio: {{ basename($article->audio_file) }}</span>
                  </p>
                @endif
                @if($article->youtube_url)
                  <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <span>▶️</span>
                    <span>YouTube: {{ $article->youtube_url }}</span>
                  </p>
                @endif
                @if($article->additional_images && count($article->additional_images) > 0)
                  <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <span>🖼️</span>
                    <span>{{ count($article->additional_images) }} gambar tersimpan</span>
                  </p>
                @endif
              </div>
              <p class="text-[10px] text-gray-400 mt-2">Upload file baru untuk mengganti media yang sudah ada.</p>
            </div>
            @endif

            <div class="flex gap-2 mb-5 flex-wrap">
              <button type="button" @click="mediaType = 'audio'"
                :class="mediaType === 'audio' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="px-4 py-2 text-xs font-semibold rounded-lg transition-all">🎵 Audio / MP3</button>
              <button type="button" @click="mediaType = 'image'"
                :class="mediaType === 'image' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="px-4 py-2 text-xs font-semibold rounded-lg transition-all">🖼️ Gambar</button>
              <button type="button" @click="mediaType = 'video'"
                :class="mediaType === 'video' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="px-4 py-2 text-xs font-semibold rounded-lg transition-all">🎬 Video</button>
              <button type="button" @click="mediaType = 'youtube'"
                :class="mediaType === 'youtube' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="px-4 py-2 text-xs font-semibold rounded-lg transition-all">▶️ YouTube</button>
            </div>

            {{-- Audio --}}
            <div x-show="mediaType === 'audio'" x-transition>
              <label
                class="media-drop-zone flex items-center justify-center w-full h-36 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-pointer hover:border-brand-400 transition-colors"
                :class="audioFile ? 'has-file' : ''"
                for="audio-upload-bahasa-edit">
                <input type="file" id="audio-upload-bahasa-edit" name="media_audio" accept="audio/mpeg,audio/wav,audio/ogg"
                  class="sr-only" @change="handleAudioChange($event)">
                <div class="text-center" x-show="!audioFile">
                  <span class="text-3xl mb-2 block">🎧</span>
                  <p class="text-sm text-gray-500 dark:text-gray-400">Upload audio baru — <span class="text-brand-500 font-medium">klik untuk pilih</span></p>
                  <p class="text-[10px] text-gray-400 mt-1">MP3 / WAV — Maks 20MB</p>
                </div>
                <div x-show="audioFile" class="flex items-center gap-3 px-4">
                  <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-brand-500/10 shrink-0">
                    <span class="text-2xl">🎧</span>
                  </div>
                  <div class="text-left min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90 truncate" x-text="audioFile?.name"></p>
                    <p class="text-xs text-gray-500" x-text="formatBytes(audioFile?.size || 0)"></p>
                    <button type="button" @click.prevent="audioFile = null; document.getElementById('audio-upload-bahasa-edit').value = ''"
                      class="text-xs text-red-500 hover:text-red-600 mt-1">Hapus</button>
                  </div>
                </div>
              </label>
              <div class="mt-3">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Label Audio</label>
                <input type="text" name="audio_label" placeholder="Misal: Percakapan di Restoran"
                  value="{{ old('audio_label', $article->audio_label) }}"
                  class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
              </div>
            </div>

            {{-- Image --}}
            <div x-show="mediaType === 'image'" x-transition>
              @if($article->additional_images && count($article->additional_images) > 0)
              <div class="mb-3">
                <p class="text-xs font-medium text-gray-600 dark:text-gray-300 mb-2">Gambar tersimpan:</p>
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                  @foreach($article->additional_images as $imgPath)
                    <div class="aspect-square rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                      <img src="{{ asset('storage/' . $imgPath) }}" class="w-full h-full object-cover" alt="Gambar artikel">
                    </div>
                  @endforeach
                </div>
              </div>
              @endif
              <label
                class="media-drop-zone flex flex-col items-center justify-center w-full min-h-[140px] rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-pointer hover:border-brand-400 transition-colors"
                :class="imageFiles.length > 0 ? 'has-file' : ''"
                @dragover.prevent="$el.classList.add('drag-over')"
                @dragleave.prevent="$el.classList.remove('drag-over')"
                @drop.prevent="$el.classList.remove('drag-over'); handleImageDrop($event)"
                for="image-upload-bahasa-edit">
                <input type="file" id="image-upload-bahasa-edit" name="media_images[]" multiple accept="image/*"
                  class="sr-only" @change="handleImageDrop($event)">
                <div class="text-center py-4" x-show="imageFiles.length === 0">
                  <svg class="mx-auto w-10 h-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 13.5V6.75A2.25 2.25 0 0015.75 4.5h-13.5A2.25 2.25 0 000 6.75v10.5A2.25 2.25 0 002.25 19.5h15" />
                  </svg>
                  <p class="text-sm text-gray-500 dark:text-gray-400">Tambah gambar baru — <span class="text-brand-500 font-medium">klik untuk upload</span></p>
                  <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, WebP — Maks 5MB per file</p>
                </div>
                <div x-show="imageFiles.length > 0" class="w-full p-3">
                  <div class="grid grid-cols-3 sm:grid-cols-5 gap-2 mb-2">
                    <template x-for="(img, i) in imageFiles" :key="i">
                      <div class="relative file-preview-item group aspect-square rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                        <img :src="img.preview" class="w-full h-full object-cover">
                        <button type="button" @click.prevent="removeImage(i)"
                          class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs leading-none">✕</button>
                      </div>
                    </template>
                    <label for="image-upload-bahasa-edit" class="aspect-square rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center cursor-pointer hover:border-brand-400 transition-colors" x-show="imageFiles.length < 5">
                      <span class="text-2xl text-gray-400">+</span>
                    </label>
                  </div>
                  <p class="text-[10px] text-gray-400 text-center" x-text="imageFiles.length + ' gambar baru dipilih'"></p>
                </div>
              </label>
            </div>

            {{-- Video --}}
            <div x-show="mediaType === 'video'" x-transition>
              <label
                class="media-drop-zone flex items-center justify-center w-full h-36 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-pointer hover:border-brand-400 transition-colors"
                :class="videoFile ? 'has-file' : ''"
                for="video-upload-bahasa-edit">
                <input type="file" id="video-upload-bahasa-edit" name="media_video" accept="video/mp4,video/webm"
                  class="sr-only" @change="handleVideoChange($event)">
                <div class="text-center" x-show="!videoFile">
                  <span class="text-3xl mb-2 block">🎬</span>
                  <p class="text-sm text-gray-500 dark:text-gray-400">Upload video baru — <span class="text-brand-500 font-medium">klik untuk pilih</span></p>
                  <p class="text-[10px] text-gray-400 mt-1">MP4 / WebM — Maks 50MB</p>
                </div>
                <div x-show="videoFile" class="flex items-center gap-3 px-4">
                  <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-brand-500/10 shrink-0">
                    <span class="text-2xl">🎬</span>
                  </div>
                  <div class="text-left min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90 truncate" x-text="videoFile?.name"></p>
                    <p class="text-xs text-gray-500" x-text="formatBytes(videoFile?.size || 0)"></p>
                    <button type="button" @click.prevent="videoFile = null; document.getElementById('video-upload-bahasa-edit').value = ''"
                      class="text-xs text-red-500 hover:text-red-600 mt-1">Hapus</button>
                  </div>
                </div>
              </label>
            </div>

            {{-- YouTube --}}
            <div x-show="mediaType === 'youtube'" x-transition>
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Link YouTube</label>
              <div class="flex items-center gap-2">
                <span class="flex items-center justify-center w-11 h-11 rounded-lg bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 shrink-0">
                  <svg class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </span>
                <input type="url" name="youtube_url" placeholder="https://www.youtube.com/watch?v=..."
                  value="{{ old('youtube_url', $article->youtube_url) }}"
                  class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
              </div>
              <p class="text-xs text-gray-400 mt-1.5">Video akan ditanamkan (embed) di halaman artikel.</p>
            </div>
          </div>
        </div>{{-- END Section D --}}

        {{-- ===== SECTION E: Kuis Review Interaktif ===== --}}
        @php
          $quizData = old('quiz_questions') ?? ($article->quiz_questions ? collect($article->quiz_questions)->map(fn($q) => [
            'question' => $q['question'] ?? '',
            'options' => $q['options'] ?? ['', '', '', ''],
            'correctAnswer' => $q['answer'] ?? 0
          ])->toArray() : [['question' => '', 'options' => ['', '', '', ''], 'correctAnswer' => 0]]);
        @endphp
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
          x-data="{
            quizzes: {{ json_encode(array_values($quizData)) }},
            addQuiz() {
              this.quizzes.push({
                question: '',
                options: ['', '', '', ''],
                correctAnswer: 0
              });
            },
            removeQuiz(index) {
              if (this.quizzes.length > 1) this.quizzes.splice(index, 1);
            },
            addOption(qIndex) {
              this.quizzes[qIndex].options.push('');
            },
            removeOption(qIndex, oIndex) {
              if (this.quizzes[qIndex].options.length > 2) {
                this.quizzes[qIndex].options.splice(oIndex, 1);
              }
            }
          }">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">🧠 Kuis Review</h3>
            <p class="text-xs text-gray-500 mt-1">Soal latihan interaktif di akhir artikel. Pilihan ganda.</p>
          </div>
          <div class="p-6 space-y-6">
            <template x-for="(quiz, qIndex) in quizzes" :key="qIndex">
              <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-5 bg-gray-50/50 dark:bg-white/[0.02]">
                {{-- Quiz Header --}}
                <div class="flex items-center justify-between mb-4">
                  <h4 class="text-sm font-bold text-gray-800 dark:text-white/90">
                    Soal #<span x-text="qIndex + 1"></span>
                  </h4>
                  <button type="button" @click="removeQuiz(qIndex)" class="text-red-400 hover:text-red-500 text-xs font-medium">
                    Hapus Soal
                  </button>
                </div>

                {{-- Pertanyaan --}}
                <div class="mb-4">
                  <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Pertanyaan</label>
                  <textarea x-model="quiz.question" rows="2" placeholder="Misal: Apa arti dari これ?"
                    :name="'quiz_questions[' + qIndex + '][question]'"
                    class="shadow-theme-xs w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden"></textarea>
                </div>

                {{-- Hidden input untuk jawaban benar --}}
                <input type="hidden" :name="'quiz_questions[' + qIndex + '][answer]'" :value="quiz.correctAnswer">

                {{-- Pilihan Jawaban --}}
                <div class="space-y-3">
                  <label class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-400">Pilihan Jawaban</label>
                  <template x-for="(option, oIndex) in quiz.options" :key="oIndex">
                    <div class="flex items-center gap-3">
                      {{-- Radio untuk tandai jawaban benar --}}
                      <input type="radio" :name="'correct_' + qIndex" :value="oIndex"
                        x-model.number="quiz.correctAnswer"
                        class="text-green-500 focus:ring-green-500"
                        title="Tandai sebagai jawaban benar">
                      {{-- Input opsi --}}
                      <input x-model="quiz.options[oIndex]" type="text"
                        :name="'quiz_questions[' + qIndex + '][options][' + oIndex + ']'"
                        :placeholder="'Opsi ' + String.fromCharCode(65 + oIndex)"
                        class="flex-1 rounded-lg border border-gray-300 bg-transparent px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 focus:border-brand-300 focus:ring-1 focus:ring-brand-500/10 focus:outline-hidden">
                      {{-- Hapus opsi --}}
                      <button type="button" @click="removeOption(qIndex, oIndex)"
                        class="text-gray-400 hover:text-red-400 transition-colors"
                        x-show="quiz.options.length > 2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                      </button>
                    </div>
                  </template>
                  <button type="button" @click="addOption(qIndex)"
                    class="text-xs text-brand-500 hover:text-brand-600 font-medium">
                    + Tambah Opsi
                  </button>
                </div>
                <p class="mt-3 text-[10px] text-gray-400">🟢 Klik radio di kiri untuk menandai jawaban yang benar.</p>
              </div>
            </template>

            {{-- Tombol Tambah Soal --}}
            <button type="button" @click="addQuiz()"
              class="w-full flex items-center justify-center gap-2 py-3 rounded-xl border-2 border-dashed border-brand-300 dark:border-brand-700 text-brand-500 hover:bg-brand-50 dark:hover:bg-brand-500/5 transition-colors font-medium text-sm">
              <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
              Tambah Soal Lagi
            </button>
          </div>
        </div>{{-- END Section E --}}

      </div>

      {{-- =================== KOLOM KANAN (30%) =================== --}}
      <div class="xl:col-span-3 space-y-6">

        {{-- Status Info --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
          <label class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-400">Status Publikasi</label>
          <p class="text-xs text-gray-500 dark:text-gray-400">
            Status ditentukan berdasarkan tombol yang Anda klik di bawah:
          </p>
          <div class="mt-3 space-y-2">
            <div class="flex items-center gap-2">
              <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold bg-yellow-50 text-yellow-600 dark:bg-yellow-500/15 dark:text-yellow-400">Draft</span>
              <span class="text-xs text-gray-500">→ Klik "Simpan Draft"</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold bg-green-50 text-green-600 dark:bg-green-500/15 dark:text-green-400">Published</span>
              <span class="text-xs text-gray-500">→ Klik "Publish"</span>
            </div>
          </div>
          <div class="mt-3 pt-3 border-t border-gray-200 dark:border-gray-700">
            <p class="text-xs text-gray-500">Status saat ini:
              <span class="font-semibold {{ $article->status === 'published' ? 'text-green-500' : 'text-yellow-500' }}">{{ ucfirst($article->status) }}</span>
            </p>
          </div>
        </div>

        {{-- Thumbnail --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5"
          x-data="{ thumbPreview: {{ $article->cover_image ? '\'' . asset('storage/' . $article->cover_image) . '\'' : 'null' }} }">
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Thumbnail / Cover</label>
          <label for="cover-image-bahasa-edit"
            class="relative flex items-center justify-center w-full rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-pointer hover:border-brand-400 transition-colors overflow-hidden"
            :class="thumbPreview ? 'h-44' : 'h-32'">
            <input type="file" id="cover-image-bahasa-edit" name="cover_image" accept="image/*" class="sr-only"
              @change="const f=$event.target.files[0]; if(f){const r=new FileReader();r.onload=e=>thumbPreview=e.target.result;r.readAsDataURL(f)}">
            <img x-show="thumbPreview" :src="thumbPreview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
            <div class="relative z-10 text-center py-4" x-show="!thumbPreview">
              <svg class="mx-auto w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
              </svg>
              <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Drag & drop atau <span class="text-brand-500">klik</span></p>
            </div>
            <button x-show="thumbPreview" type="button"
              @click.prevent="thumbPreview = null; document.getElementById('cover-image-bahasa-edit').value = ''"
              class="absolute top-2 right-2 z-20 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs leading-none">✕</button>
          </label>
          <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, WebP — Maks 2MB</p>
        </div>

        {{-- Excerpt --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Ringkasan Pendek</label>
          <textarea name="excerpt" rows="3" placeholder="Penjelasan singkat 1-2 kalimat..."
            class="shadow-theme-xs w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden">{{ old('excerpt', $article->excerpt) }}</textarea>
        </div>

        {{-- Estimasi Waktu --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Estimasi Waktu Baca</label>
          <input type="text" name="read_time" placeholder="5 menit"
            value="{{ old('read_time', $article->read_time) }}"
            class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
        </div>

        {{-- Info Kuis --}}
        <div class="rounded-xl border border-blue-200 bg-blue-50 dark:border-blue-500/30 dark:bg-blue-500/10 p-4">
          <div class="flex items-start gap-2">
            <span class="text-blue-500 mt-0.5">ℹ️</span>
            <div>
              <p class="text-xs font-medium text-blue-800 dark:text-blue-300">Kuis akan muncul di akhir artikel</p>
              <p class="text-[10px] text-blue-600/70 dark:text-blue-400/70 mt-1">Pembaca harus menyelesaikan kuis sebelum dianggap "selesai" membaca artikel.</p>
            </div>
          </div>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-3">
          <a href="{{ route('admin.articles.index') }}"
            class="flex-1 text-center rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
            Batal
          </a>
          <button type="submit" name="action" value="draft"
            class="flex-1 rounded-lg border border-gray-300 dark:border-gray-700 px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-colors">
            Simpan Draft
          </button>
          <button type="submit" name="action" value="publish"
            class="flex-1 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
            Publish
          </button>
        </div>
      </div>

    </div>
  </form>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const quill = new Quill('#quill-editor-bahasa', {
      theme: 'snow',
      placeholder: 'Tulis penjelasan materi di sini...',
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'script': 'sub'}, { 'script': 'super' }],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
          [{ 'indent': '-1'}, { 'indent': '+1' }],
          ['blockquote', 'code-block'],
          ['link', 'image'],
          [{ 'align': [] }],
          ['clean']
        ]
      }
    });

    // Sync Quill content ke hidden textarea saat submit
    const form = document.getElementById('bahasa-edit-form');
    form.addEventListener('submit', function() {
      document.getElementById('content-bahasa-input').value = quill.root.innerHTML;
    });

    // Populate konten yang sudah ada
    const existingContent = {!! json_encode(old('content', $article->grammar_explanation ?? '')) !!};
    if (existingContent) {
      quill.root.innerHTML = existingContent;
    }
  });
</script>
@endpush
