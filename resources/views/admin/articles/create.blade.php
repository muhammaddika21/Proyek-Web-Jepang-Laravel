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
  .ql-editor { min-height: 280px; font-size: 14px; line-height: 1.7; }
  .ql-toolbar.ql-snow { border-radius: 0.5rem 0.5rem 0 0; }
  .ql-container.ql-snow { border-radius: 0 0 0.5rem 0.5rem; }

  /* Media Upload Area */
  .media-drop-zone {
    transition: all 0.2s ease;
  }
  .media-drop-zone.drag-over {
    border-color: #448646;
    background-color: rgba(68, 134, 70, 0.08);
  }
  .media-drop-zone.has-file {
    border-color: #448646;
    background-color: rgba(68, 134, 70, 0.05);
  }
  .file-preview-item {
    animation: fadeIn 0.3s ease;
  }
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
      <a href="/admin/articles" class="hover:text-brand-500">Kelola Artikel</a>
      <span>›</span>
      <span class="text-gray-800 dark:text-white/90 font-medium">Buat Artikel Umum</span>
    </div>
    <h2 class="text-xl font-bold text-gray-800 dark:text-white/90 sm:text-2xl">🏯 Buat Artikel Umum</h2>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Untuk konten Budaya, Event, atau Pengetahuan Umum tentang Jepang.</p>
  </div>

  <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" id="article-form">
    @csrf
    <input type="hidden" name="type" value="umum">

    <div class="grid grid-cols-1 xl:grid-cols-10 gap-6">

      {{-- =================== KOLOM KIRI (70%) =================== --}}
      <div class="xl:col-span-7 space-y-6">

        {{-- Section: Info Dasar --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
          x-data="{
            title: '',
            slug: '',
            autoSlug: true,
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
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Informasi Dasar</h3>
          </div>
          <div class="p-6 space-y-5">
            <div>
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Judul Artikel</label>
              <input type="text" name="title" x-model="title"
                @input="if(autoSlug) slug = generateSlug(title)"
                placeholder="Misal: Festival Hanami di Taman Ueno"
                class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
            </div>
            <div>
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Slug (URL)
                <span class="text-xs text-gray-400 font-normal ml-1" x-show="autoSlug">— auto-generate dari judul</span>
              </label>
              <input type="text" name="slug" x-model="slug"
                @input="autoSlug = false"
                placeholder="festival-hanami-taman-ueno"
                class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 font-mono">
              <p class="text-[10px] text-gray-400 mt-1" x-show="slug">Akan tampil di: <span class="text-brand-500">ukmnihon.com/artikel/<span x-text="slug"></span></span></p>
            </div>
          </div>
        </div>

        {{-- Section: Rich Text Editor (Quill.js) --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">📝 Konten Artikel</h3>
            <p class="text-xs text-gray-500 mt-1">Tulis isi artikel dengan editor rich text. Mendukung format, link, gambar, dan list.</p>
          </div>
          <div class="p-6">
            {{-- Hidden textarea untuk menyimpan konten HTML ke server --}}
            <textarea name="content" id="content-input" style="display:none;"></textarea>
            {{-- Quill Editor Container --}}
            <div id="quill-editor-umum" class="rounded-lg overflow-hidden border border-gray-300 dark:border-gray-700"></div>
          </div>
        </div>

        {{-- Section: Media Upload --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03]"
          x-data="{
            mediaType: 'image',
            imageFiles: [],
            videoFile: null,
            audioFile: null,
            formatBytes(bytes) {
              if (bytes < 1024) return bytes + ' B';
              if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
              return (bytes / 1048576).toFixed(1) + ' MB';
            },
            handleImageDrop(e) {
              const files = Array.from(e.dataTransfer?.files || e.target.files || []);
              files.forEach(f => {
                if (f.type.startsWith('image/') && this.imageFiles.length < 5) {
                  const reader = new FileReader();
                  reader.onload = ev => this.imageFiles.push({ name: f.name, size: f.size, preview: ev.target.result, file: f });
                  reader.readAsDataURL(f);
                }
              });
            },
            handleVideoChange(e) {
              const f = e.target.files[0];
              if (f) this.videoFile = { name: f.name, size: f.size };
            },
            handleAudioChange(e) {
              const f = e.target.files[0];
              if (f) this.audioFile = { name: f.name, size: f.size };
            },
            removeImage(i) { this.imageFiles.splice(i, 1); }
          }">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">📎 Media Tambahan</h3>
            <p class="text-xs text-gray-500 mt-1">Sisipkan gambar, video, audio, atau link YouTube.</p>
          </div>
          <div class="p-6">
            {{-- Tab Media --}}
            <div class="flex gap-2 mb-5 flex-wrap">
              <button type="button" @click="mediaType = 'image'"
                :class="mediaType === 'image' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center gap-1.5">
                🖼️ Gambar
              </button>
              <button type="button" @click="mediaType = 'video'"
                :class="mediaType === 'video' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center gap-1.5">
                🎬 Video
              </button>
              <button type="button" @click="mediaType = 'youtube'"
                :class="mediaType === 'youtube' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center gap-1.5">
                ▶️ YouTube
              </button>
              <button type="button" @click="mediaType = 'audio'"
                :class="mediaType === 'audio' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center gap-1.5">
                🎵 Audio / MP3
              </button>
            </div>

            {{-- Upload Area: Image --}}
            <div x-show="mediaType === 'image'" x-transition>
              <label
                class="media-drop-zone flex flex-col items-center justify-center w-full min-h-[140px] rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-pointer hover:border-brand-400 transition-colors"
                :class="imageFiles.length > 0 ? 'has-file' : ''"
                @dragover.prevent="$el.classList.add('drag-over')"
                @dragleave.prevent="$el.classList.remove('drag-over')"
                @drop.prevent="$el.classList.remove('drag-over'); handleImageDrop($event)"
                for="image-upload">
                <input type="file" id="image-upload" name="media_images[]" multiple accept="image/jpeg,image/png,image/webp,image/gif"
                  class="sr-only" @change="handleImageDrop($event)">
                <div class="text-center py-4" x-show="imageFiles.length === 0">
                  <svg class="mx-auto w-10 h-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 13.5V6.75A2.25 2.25 0 0015.75 4.5h-13.5A2.25 2.25 0 000 6.75v10.5A2.25 2.25 0 002.25 19.5h15" />
                  </svg>
                  <p class="text-sm text-gray-500 dark:text-gray-400">Drag & drop gambar atau <span class="text-brand-500 font-medium">klik untuk upload</span></p>
                  <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, WebP — Maks 5MB per file, hingga 5 gambar</p>
                </div>
                {{-- Image previews --}}
                <div x-show="imageFiles.length > 0" class="w-full p-3">
                  <div class="grid grid-cols-3 sm:grid-cols-5 gap-2 mb-2">
                    <template x-for="(img, i) in imageFiles" :key="i">
                      <div class="relative file-preview-item group aspect-square rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700">
                        <img :src="img.preview" class="w-full h-full object-cover">
                        <button type="button" @click.prevent="removeImage(i)"
                          class="absolute top-1 right-1 w-5 h-5 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs leading-none">✕</button>
                      </div>
                    </template>
                    <label for="image-upload" class="aspect-square rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center cursor-pointer hover:border-brand-400 transition-colors" x-show="imageFiles.length < 5">
                      <span class="text-2xl text-gray-400">+</span>
                    </label>
                  </div>
                  <p class="text-[10px] text-gray-400 text-center" x-text="imageFiles.length + ' gambar dipilih'"></p>
                </div>
              </label>
            </div>

            {{-- Upload Area: Video --}}
            <div x-show="mediaType === 'video'" x-transition>
              <label
                class="media-drop-zone flex items-center justify-center w-full h-40 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-pointer hover:border-brand-400 transition-colors"
                :class="videoFile ? 'has-file' : ''"
                for="video-upload">
                <input type="file" id="video-upload" name="media_video" accept="video/mp4,video/webm,video/ogg"
                  class="sr-only" @change="handleVideoChange($event)">
                <div class="text-center" x-show="!videoFile">
                  <svg class="mx-auto w-10 h-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m15.75 10.5 4.72-4.72a.75.75 0 0 1 1.28.53v11.38a.75.75 0 0 1-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25h-9A2.25 2.25 0 0 0 2.25 7.5v9a2.25 2.25 0 0 0 2.25 2.25Z" />
                  </svg>
                  <p class="text-sm text-gray-500 dark:text-gray-400">Upload video — <span class="text-brand-500 font-medium">klik untuk pilih</span></p>
                  <p class="text-[10px] text-gray-400 mt-1">MP4, WebM — Maks 50MB</p>
                </div>
                <div x-show="videoFile" class="flex items-center gap-3 px-4">
                  <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-brand-500/10 shrink-0">
                    <span class="text-2xl">🎬</span>
                  </div>
                  <div class="text-left min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90 truncate" x-text="videoFile?.name"></p>
                    <p class="text-xs text-gray-500" x-text="formatBytes(videoFile?.size || 0)"></p>
                    <button type="button" @click.prevent="videoFile = null; $el.closest('label').querySelector('input').value = ''"
                      class="text-xs text-red-500 hover:text-red-600 mt-1">Hapus</button>
                  </div>
                </div>
              </label>
            </div>

            {{-- Input: YouTube --}}
            <div x-show="mediaType === 'youtube'" x-transition>
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Link YouTube</label>
              <div class="flex items-center gap-2">
                <span class="flex items-center justify-center w-11 h-11 rounded-lg bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20 shrink-0">
                  <svg class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </span>
                <input type="url" name="youtube_url" placeholder="https://www.youtube.com/watch?v=..."
                  class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
              </div>
              <p class="text-xs text-gray-400 mt-1.5">Video akan ditanamkan (embed) secara otomatis di halaman artikel.</p>
            </div>

            {{-- Upload Area: Audio --}}
            <div x-show="mediaType === 'audio'" x-transition>
              <label
                class="media-drop-zone flex items-center justify-center w-full h-36 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-pointer hover:border-brand-400 transition-colors"
                :class="audioFile ? 'has-file' : ''"
                for="audio-upload">
                <input type="file" id="audio-upload" name="media_audio" accept="audio/mpeg,audio/wav,audio/ogg"
                  class="sr-only" @change="handleAudioChange($event)">
                <div class="text-center" x-show="!audioFile">
                  <span class="text-3xl mb-2 block">🎵</span>
                  <p class="text-sm text-gray-500 dark:text-gray-400">Upload audio — <span class="text-brand-500 font-medium">MP3, WAV, OGG</span></p>
                  <p class="text-[10px] text-gray-400 mt-1">Maks 20MB</p>
                </div>
                <div x-show="audioFile" class="flex items-center gap-3 px-4">
                  <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-brand-500/10 shrink-0">
                    <span class="text-2xl">🎧</span>
                  </div>
                  <div class="text-left min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-white/90 truncate" x-text="audioFile?.name"></p>
                    <p class="text-xs text-gray-500" x-text="formatBytes(audioFile?.size || 0)"></p>
                    <button type="button" @click.prevent="audioFile = null; $el.closest('label').querySelector('input').value = ''"
                      class="text-xs text-red-500 hover:text-red-600 mt-1">Hapus</button>
                  </div>
                </div>
              </label>
              <div class="mt-3">
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Label Audio</label>
                <input type="text" name="audio_label" placeholder="Misal: Lagu Sakura Sakura"
                  class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
              </div>
            </div>
          </div>
        </div>

      </div>

      {{-- =================== KOLOM KANAN (30%) =================== --}}
      <div class="xl:col-span-3 space-y-6">

        {{-- Status --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
          <label class="mb-3 block text-sm font-medium text-gray-700 dark:text-gray-400">Status Publikasi</label>
          <div class="space-y-2">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="status" value="published" checked class="text-brand-500 focus:ring-brand-500">
              <span class="text-sm text-gray-800 dark:text-white/90">Published</span>
            </label>
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="radio" name="status" value="draft" class="text-brand-500 focus:ring-brand-500">
              <span class="text-sm text-gray-800 dark:text-white/90">Draft</span>
            </label>
          </div>
        </div>

        {{-- Kategori --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kategori</label>
          <select name="category_id"
            class="shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden">
            <option value="">Pilih Kategori...</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>

        {{-- Thumbnail --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5"
          x-data="{ thumbPreview: null }"
          @drop.prevent="
            const f = $event.dataTransfer.files[0];
            if (f?.type.startsWith('image/')) {
              const r = new FileReader();
              r.onload = e => thumbPreview = e.target.result;
              r.readAsDataURL(f);
            }
          "
          @dragover.prevent>
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Thumbnail / Cover</label>
          <label for="cover-image"
            class="relative flex items-center justify-center w-full rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-pointer hover:border-brand-400 transition-colors overflow-hidden"
            :class="thumbPreview ? 'h-44' : 'h-32'">
            <input type="file" id="cover-image" name="cover_image" accept="image/*" class="sr-only"
              @change="const f=$event.target.files[0]; if(f){const r=new FileReader();r.onload=e=>thumbPreview=e.target.result;r.readAsDataURL(f)}">
            <img x-show="thumbPreview" :src="thumbPreview" class="absolute inset-0 w-full h-full object-cover rounded-xl">
            <div class="relative z-10 text-center py-4" x-show="!thumbPreview">
              <svg class="mx-auto w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
              </svg>
              <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Drag & drop atau <span class="text-brand-500">klik</span></p>
            </div>
            <button x-show="thumbPreview" type="button"
              @click.prevent="thumbPreview = null; document.getElementById('cover-image').value = ''"
              class="absolute top-2 right-2 z-20 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs leading-none">✕</button>
          </label>
          <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, WebP — Maks 2MB</p>
        </div>

        {{-- Excerpt --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/[0.03] p-5">
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Ringkasan Pendek</label>
          <textarea name="excerpt" rows="3" placeholder="Tulis deskripsi singkat untuk SEO..."
            class="shadow-theme-xs w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden"></textarea>
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
    // Detect dark mode
    const isDark = document.documentElement.classList.contains('dark');

    const quill = new Quill('#quill-editor-umum', {
      theme: 'snow',
      placeholder: 'Tulis isi artikel di sini...',
      modules: {
        toolbar: [
          [{ 'header': [1, 2, 3, false] }],
          ['bold', 'italic', 'underline', 'strike'],
          [{ 'color': [] }, { 'background': [] }],
          [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
          [{ 'indent': '-1'}, { 'indent': '+1' }],
          ['blockquote', 'code-block'],
          ['link', 'image'],
          ['clean']
        ]
      }
    });

    // Sync konten Quill ke hidden textarea saat form di-submit
    const form = document.getElementById('article-form');
    form.addEventListener('submit', function() {
      document.getElementById('content-input').value = quill.root.innerHTML;
    });

    // Populate dari old() jika ada validasi error
    @if(old('content'))
      quill.root.innerHTML = {!! json_encode(old('content')) !!};
    @endif
  });
</script>
@endpush
