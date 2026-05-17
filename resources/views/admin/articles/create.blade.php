@extends('layouts.admin')

@push('styles')
{{-- Quill Snow Theme --}}
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
  /* ==========================================
     Quill RTE - NihonLearn Dark Mode Theming
     ========================================== */
  /* Toolbar dark */
  .dark .ql-toolbar.ql-snow {
    background-color: #1a2e24 !important;
    border-color: #2d4a38 !important;
    border-bottom-color: #2d4a38 !important;
    border-radius: 0.5rem 0.5rem 0 0;
  }
  /* Editor container dark */
  .dark .ql-container.ql-snow {
    background-color: #162b1e !important;
    border-color: #2d4a38 !important;
    color: rgba(232, 240, 234, 0.92) !important;
    border-radius: 0 0 0.5rem 0.5rem;
  }
  /* Editor inner area dark */
  .dark .ql-editor {
    background-color: #162b1e !important;
    color: rgba(232, 240, 234, 0.92) !important;
  }
  /* Placeholder */
  .dark .ql-editor.ql-blank::before {
    color: rgba(176, 196, 180, 0.5) !important;
    font-style: italic;
  }
  /* Toolbar SVG stroke icons */
  .dark .ql-toolbar .ql-stroke {
    stroke: #80b68b !important;
  }
  .dark .ql-toolbar .ql-fill {
    fill: #80b68b !important;
  }
  .dark .ql-toolbar .ql-picker-label,
  .dark .ql-toolbar .ql-picker-label::before {
    color: #80b68b !important;
  }
  /* Hover / active state */
  .dark .ql-toolbar button:hover .ql-stroke,
  .dark .ql-toolbar button.ql-active .ql-stroke { stroke: #8fd6b0 !important; }
  .dark .ql-toolbar button:hover .ql-fill,
  .dark .ql-toolbar button.ql-active .ql-fill { fill: #8fd6b0 !important; }
  .dark .ql-toolbar button:hover,
  .dark .ql-toolbar button.ql-active { background-color: rgba(68,134,70,0.18) !important; border-radius: 4px; }
  /* Picker background */
  .dark .ql-picker-label {
    background-color: rgba(26, 46, 36, 0.8) !important;
    border-color: #2d4a38 !important;
    border-radius: 4px;
  }
  .dark .ql-picker-options {
    background-color: #1a2e24 !important;
    border-color: #2d4a38 !important;
    box-shadow: 0 8px 24px rgba(0,0,0,0.45) !important;
  }
  .dark .ql-picker-item { color: #80b68b !important; }
  .dark .ql-picker-item:hover,
  .dark .ql-picker-item.ql-selected { color: #8fd6b0 !important; background: rgba(68,134,70,0.12) !important; }

  /* Editor base sizing */
  .ql-editor { min-height: 280px; font-size: 14px; line-height: 1.75; }
  .ql-toolbar.ql-snow { border-radius: 0.5rem 0.5rem 0 0; }
  .ql-container.ql-snow { border-radius: 0 0 0.5rem 0.5rem; }
  /* Light mode border */
  .ql-toolbar.ql-snow { border-color: #d1d5db !important; }
  .ql-container.ql-snow { border-color: #d1d5db !important; }

  /* Media Upload Area */
  .media-drop-zone { transition: all 0.2s ease; }
  .media-drop-zone.drag-over { border-color: #448646; background-color: rgba(68, 134, 70, 0.08); }
  .media-drop-zone.has-file { border-color: #448646; background-color: rgba(68, 134, 70, 0.05); }
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
      <a href="/admin/articles" class="hover:text-brand-500">Kelola Artikel</a>
      <span>›</span>
      <span class="text-gray-800 dark:text-white/90 font-medium">{{ isset($article) ? 'Edit Artikel' : 'Buat Artikel Umum' }}</span>
    </div>
    <h2 class="text-xl font-bold text-gray-800 dark:text-white/90 sm:text-2xl">🏯 {{ isset($article) ? 'Edit Artikel: ' . $article->title : 'Buat Artikel Umum' }}</h2>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Untuk konten Budaya, Event, atau Pengetahuan Umum tentang Jepang.</p>
  </div>

  <form action="{{ isset($article) ? route('admin.articles.update', $article) : route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" id="article-form">
    @csrf
    @if(isset($article)) @method('PUT') @endif
    <input type="hidden" name="type" value="umum">

    <div class="grid grid-cols-1 xl:grid-cols-10 gap-6">

      {{-- =================== KOLOM KIRI (70%) =================== --}}
      <div class="xl:col-span-7 space-y-6">

        {{-- Section: Info Dasar --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24]"
          x-data="{
            title: '{{ old('title', isset($article) ? $article->title : '') }}',
            slug: '{{ old('slug', isset($article) ? $article->slug : '') }}',
            autoSlug: {{ isset($article) ? 'false' : 'true' }},
            generateSlug(text) {
              return text.toLowerCase()
                .replace(/[àáâãäå]/g, 'a').replace(/[èéêë]/g, 'e').replace(/[ìíîï]/g, 'i')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-|-$/g, '');
            }
          }">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-[#24463a]">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Informasi Dasar</h3>
          </div>
          <div class="p-6 space-y-5">
            <div>
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Judul Artikel</label>
              <input type="text" name="title" x-model="title"
                @input="if(autoSlug) slug = generateSlug(title)"
                placeholder="Misal: Festival Hanami di Taman Ueno"
                class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-[#24463a] dark:bg-[#1a2e24] dark:text-white/90 dark:placeholder:text-white/30">
            </div>
            <div>
              <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Slug (URL)
                <span class="text-xs text-gray-400 font-normal ml-1" x-show="autoSlug">— auto-generate dari judul</span>
              </label>
              <input type="text" name="slug" x-model="slug"
                @input="autoSlug = false"
                placeholder="festival-hanami-taman-ueno"
                class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-[#24463a] dark:bg-[#1a2e24] dark:text-white/90 dark:placeholder:text-white/30 font-mono">
              <p class="text-[10px] text-gray-400 mt-1" x-show="slug">Akan tampil di: <span class="text-brand-500">ukmnihon.com/artikel/<span x-text="slug"></span></span></p>
            </div>
          </div>
        </div>

        {{-- Section: Rich Text Editor (Quill.js) --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24]">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-[#24463a]">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">📝 Konten Artikel</h3>
            <p class="text-xs text-gray-500 mt-1">Tulis isi artikel dengan editor rich text. Mendukung format, link, gambar, dan list.</p>
          </div>
          <div class="p-6">
            {{-- Hidden textarea untuk menyimpan konten HTML ke server --}}
            <textarea name="content" id="content-input" style="display:none;">{{ old('content', isset($article) ? $article->content : '') }}</textarea>
            {{-- Quill Editor Container --}}
            <div id="quill-editor-umum" class="rounded-lg overflow-hidden border border-gray-300 dark:border-[#24463a]"></div>
          </div>
        </div>

        {{-- Section: Media Upload --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24]"
          x-data="{
            mediaType: 'image',
            imageFiles: [],
            savedImages: {{ json_encode(isset($article) && $article->additional_images ? $article->additional_images : []) }},
            videoFile: null,
            audioFile: null,
            formatBytes(bytes) {
              if (bytes < 1024) return bytes + ' B';
              if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
              return (bytes / 1048576).toFixed(1) + ' MB';
            },
            addImages(fileList) {
              const maxNew = 5 - this.savedImages.length;
              Array.from(fileList).forEach(f => {
                if (f.type.startsWith('image/') && this.imageFiles.length < maxNew) {
                  const reader = new FileReader();
                  reader.onload = ev => {
                    this.imageFiles.push({ name: f.name, size: f.size, preview: ev.target.result, file: f });
                    this.syncFilesToInput();
                  };
                  reader.readAsDataURL(f);
                }
              });
            },
            syncFilesToInput() {
              /* Sync semua file objects ke real file input menggunakan DataTransfer API */
              const input = document.getElementById('image-upload-real');
              if (!input) return;
              const dt = new DataTransfer();
              this.imageFiles.forEach(item => { if (item.file) dt.items.add(item.file); });
              input.files = dt.files;
            },
            removeImage(i) {
              this.imageFiles.splice(i, 1);
              this.syncFilesToInput();
            },
            handleVideoChange(e) {
              const f = e.target.files[0];
              if (f) this.videoFile = { name: f.name, size: f.size };
            },
            handleAudioChange(e) {
              const f = e.target.files[0];
              if (f) this.audioFile = { name: f.name, size: f.size };
            },
            async deleteSavedImage(index) {
              if (!confirm('Hapus gambar [gambar' + (index + 1) + ']?')) return;
              try {
                const res = await fetch('{{ isset($article) ? route('admin.articles.deleteMedia', $article) : '' }}', {
                  method: 'DELETE',
                  headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                  body: JSON.stringify({ type: 'image', index: index })
                });
                const data = await res.json();
                if (data.success) { this.savedImages.splice(index, 1); }
                else { alert('Gagal menghapus gambar'); }
              } catch (e) { alert('Error: ' + e.message); }
            }
          }">
          <div class="px-6 py-5 border-b border-gray-200 dark:border-[#24463a]">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">📎 Media Tambahan</h3>
            <p class="text-xs text-gray-500 mt-1">Sisipkan gambar, video, audio, atau link YouTube.</p>
          </div>
          <div class="p-6">
            {{-- Tab Media --}}
            <div class="flex gap-2 mb-5 flex-wrap">
              <button type="button" @click="mediaType = 'image'"
                :class="mediaType === 'image' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 dark:bg-[#24463a] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center gap-1.5">
                🖼️ Gambar
              </button>
              <button type="button" @click="mediaType = 'video'"
                :class="mediaType === 'video' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 dark:bg-[#24463a] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center gap-1.5">
                🎬 Video
              </button>
              <button type="button" @click="mediaType = 'youtube'"
                :class="mediaType === 'youtube' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 dark:bg-[#24463a] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center gap-1.5">
                ▶️ YouTube
              </button>
              <button type="button" @click="mediaType = 'audio'"
                :class="mediaType === 'audio' ? 'bg-brand-500 text-white shadow-sm' : 'bg-gray-100 text-gray-600 dark:bg-[#24463a] dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="px-4 py-2 text-xs font-semibold rounded-lg transition-all flex items-center gap-1.5">
                🎵 Audio / MP3
              </button>
            </div>

            {{-- Upload Area: Image --}}
            <div x-show="mediaType === 'image'" x-transition>

              {{-- REAL File Input (hidden) — dikontrol lewat DataTransfer API --}}
              <input type="file" id="image-upload-real" name="additional_images[]" multiple
                accept="image/jpeg,image/png,image/webp,image/gif" class="sr-only"
                @change="addImages($event.target.files)">

              {{-- Saved images (edit mode) --}}
              <div class="mb-4" x-show="savedImages.length > 0">
                <p class="text-xs font-medium text-gray-600 dark:text-gray-300 mb-2">Gambar tersimpan:</p>
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
                  <template x-for="(imgPath, idx) in savedImages" :key="'saved-'+idx">
                    <div class="relative group rounded-lg overflow-hidden border border-gray-200 dark:border-[#24463a]">
                      <div class="aspect-square">
                        <img :src="'/storage/' + imgPath" class="w-full h-full object-cover" alt="Gambar artikel">
                      </div>
                      <button type="button" @click.prevent="deleteSavedImage(idx)"
                        class="absolute top-1 right-1 w-6 h-6 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all text-xs leading-none shadow-lg">✕</button>
                      <div class="text-center py-1 bg-gray-100 dark:bg-[#24463a]">
                        <span class="text-[10px] font-mono font-bold text-brand-600 dark:text-brand-400" x-text="'[gambar' + (idx + 1) + ']'"></span>
                      </div>
                    </div>
                  </template>
                </div>
              </div>

              {{-- Drop Zone --}}
              <div
                class="media-drop-zone flex flex-col items-center justify-center w-full min-h-[140px] rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-[#24463a]/50 hover:border-brand-400 transition-colors cursor-pointer"
                :class="imageFiles.length > 0 ? 'has-file' : ''"
                @dragover.prevent="$el.classList.add('drag-over')"
                @dragleave.prevent="$el.classList.remove('drag-over')"
                @drop.prevent="$el.classList.remove('drag-over'); addImages($event.dataTransfer.files)"
                @click="$refs.filePickerTrigger.click()">

                {{-- Trigger click on real input --}}
                <span x-ref="filePickerTrigger" class="hidden" @click.stop="document.getElementById('image-upload-real').click()"></span>

                <div class="text-center py-4" x-show="imageFiles.length === 0">
                  <svg class="mx-auto w-10 h-10 text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M18 13.5V6.75A2.25 2.25 0 0015.75 4.5h-13.5A2.25 2.25 0 000 6.75v10.5A2.25 2.25 0 002.25 19.5h15" />
                  </svg>
                  <p class="text-sm text-gray-500 dark:text-gray-400">Drag & drop gambar atau <span class="text-brand-500 font-medium">klik untuk pilih</span></p>
                  <p class="text-[10px] text-gray-400 mt-1">JPG, PNG, WebP — Maks 5MB per file, hingga 5 gambar</p>
                </div>

                {{-- Preview Grid --}}
                <div x-show="imageFiles.length > 0" class="w-full p-3" @click.stop>
                  <div class="grid grid-cols-3 sm:grid-cols-5 gap-2 mb-2">
                    <template x-for="(img, i) in imageFiles" :key="i">
                      <div class="relative file-preview-item group rounded-lg overflow-hidden border border-gray-200 dark:border-[#24463a]">
                        <div class="aspect-square">
                          <img :src="img.preview" class="w-full h-full object-cover" :alt="img.name">
                        </div>
                        <button type="button" @click.stop.prevent="removeImage(i)"
                          class="absolute top-1 right-1 w-5 h-5 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity text-xs leading-none z-10">✕</button>
                        <div class="text-center py-1 bg-gray-100 dark:bg-[#24463a]">
                          <span class="text-[10px] font-mono font-bold text-brand-600 dark:text-brand-400"
                            x-text="'[gambar' + (savedImages.length + i + 1) + ']'"></span>
                        </div>
                      </div>
                    </template>
                    {{-- Add More (+) Button --}}
                    <button type="button"
                      x-show="(savedImages.length + imageFiles.length) < 5"
                      @click.stop="document.getElementById('image-upload-real').click()"
                      class="aspect-square rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 flex flex-col items-center justify-center hover:border-brand-400 gap-1 transition-colors">
                      <span class="text-2xl text-gray-400 leading-none">+</span>
                      <span class="text-[9px] text-gray-400">Tambah</span>
                    </button>
                  </div>
                  <p class="text-[10px] text-gray-400 text-center"
                    x-text="imageFiles.length + ' gambar dipilih — klik + untuk tambah atau klik gambar ✕ untuk hapus'"></p>
                </div>
              </div>

              {{-- Helper note --}}
              <div class="mt-3 rounded-lg border border-blue-200 bg-blue-50 dark:border-blue-500/30 dark:bg-blue-500/10 px-4 py-3"
                x-show="savedImages.length > 0 || imageFiles.length > 0">
                <p class="text-[11px] text-blue-700 dark:text-blue-300">
                  💡 <strong>Tip:</strong> Salin label seperti <code class="bg-blue-100 dark:bg-blue-500/20 px-1 rounded text-[10px] font-mono">[gambar1]</code> ke dalam editor konten untuk menyisipkan gambar di posisi tersebut.
                </p>
              </div>
            </div>

            {{-- Upload Area: Video --}}
            <div x-show="mediaType === 'video'" x-transition>
              <label
                class="media-drop-zone flex items-center justify-center w-full h-40 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-[#24463a]/50 cursor-pointer hover:border-brand-400 transition-colors"
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
                  class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-[#24463a] dark:bg-[#1a2e24] dark:text-white/90 dark:placeholder:text-white/30">
              </div>
              <p class="text-xs text-gray-400 mt-1.5">Video akan ditanamkan (embed) secara otomatis di halaman artikel.</p>
            </div>

            {{-- Upload Area: Audio --}}
            <div x-show="mediaType === 'audio'" x-transition>
              <label
                class="media-drop-zone flex items-center justify-center w-full h-36 rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-[#24463a]/50 cursor-pointer hover:border-brand-400 transition-colors"
                :class="audioFile ? 'has-file' : ''"
                for="audio-upload">
                <input type="file" id="audio-upload" name="audio_file" accept="audio/mpeg,audio/wav,audio/ogg"
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
                  class="shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-[#24463a] dark:bg-[#1a2e24] dark:text-white/90 dark:placeholder:text-white/30">
              </div>
            </div>
          </div>
        </div>

      </div>

      {{-- =================== KOLOM KANAN (30%) =================== --}}
      <div class="xl:col-span-3 space-y-6">

        {{-- Status Info --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24] p-5">
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
          @if(isset($article))
          <div class="mt-3 pt-3 border-t border-gray-200 dark:border-[#24463a]">
            <p class="text-xs text-gray-500">Status saat ini:
              <span class="font-semibold {{ $article->status === 'published' ? 'text-green-500' : 'text-yellow-500' }}">{{ ucfirst($article->status) }}</span>
            </p>
          </div>
          @endif
        </div>

        {{-- Kategori Bertingkat --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24] p-5"
          x-data="{
            parentId: '{{ old('parent_category', isset($article) && $article->category && $article->category->parent_id ? $article->category->parent_id : '') }}',
            categoryId: '{{ old('category_id', isset($article) ? $article->category_id : '') }}',
            parentCategories: @js($parentCategories),
            get subcategories() {
              if (!this.parentId) return [];
              const parent = this.parentCategories.find(p => p.id == this.parentId);
              return parent ? parent.children : [];
            }
          }">
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kategori Utama <span class="text-red-500">*</span></label>
          <select x-model="parentId" @change="categoryId = ''" data-role="parent-category"
            class="shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-[#24463a] dark:bg-[#1a2e24] dark:text-white/90 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden mb-3">
            <option value="">Pilih Kategori...</option>
            <template x-for="parent in parentCategories" :key="parent.id">
              <option :value="parent.id" x-text="parent.name"></option>
            </template>
          </select>

          <div x-show="parentId" x-transition>
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Subkategori <span class="text-red-500">*</span></label>
            <select name="category_id" x-model="categoryId"
              class="shadow-theme-xs h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-[#24463a] dark:bg-[#1a2e24] dark:text-white/90 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden">
              <option value="">Pilih Subkategori...</option>
              <template x-for="sub in subcategories" :key="sub.id">
                <option :value="sub.id" x-text="sub.name"></option>
              </template>
            </select>
          </div>

          @error('category_id')
            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Thumbnail --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24] p-5"
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
            class="relative flex items-center justify-center w-full rounded-xl border-2 border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-[#24463a]/50 cursor-pointer hover:border-brand-400 transition-colors overflow-hidden"
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
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-[#24463a] dark:bg-[#1a2e24] p-5">
          <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Ringkasan Pendek</label>
          <textarea name="excerpt" rows="3" placeholder="Tulis deskripsi singkat untuk SEO..."
            class="shadow-theme-xs w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:border-[#24463a] dark:bg-[#1a2e24] dark:text-white/90 placeholder:text-gray-400 dark:placeholder:text-white/30 focus:border-brand-300 focus:ring-3 focus:ring-brand-500/10 focus:outline-hidden">{{ old('excerpt', isset($article) ? $article->excerpt : '') }}</textarea>
        </div>

        {{-- Validation Error Toast (hidden by default) --}}
        <div id="form-error-toast" style="display:none;"
          class="fixed bottom-6 right-6 z-50 max-w-sm w-full rounded-2xl bg-red-600 text-white shadow-2xl p-4 flex gap-3 items-start animate-slide-in">
          <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
          </svg>
          <div class="flex-1">
            <p class="font-semibold text-sm mb-1">⚠️ Tidak bisa menyimpan artikel</p>
            <ul id="form-error-list" class="text-xs text-red-100 space-y-0.5 list-disc list-inside"></ul>
          </div>
          <button onclick="document.getElementById('form-error-toast').style.display='none'" class="text-red-200 hover:text-white shrink-0">✕</button>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-3">
          <a href="{{ route('admin.articles.index') }}"
            class="flex-1 text-center rounded-lg border border-gray-300 dark:border-[#24463a] px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
            Batal
          </a>
          <button type="submit" name="action" value="draft" id="btn-draft"
            class="flex-1 rounded-lg border border-gray-300 dark:border-[#24463a] px-4 py-2.5 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-colors">
            Simpan Draft
          </button>
          <button type="submit" name="action" value="publish" id="btn-publish"
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
<style>
  @keyframes slide-in {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .animate-slide-in { animation: slide-in 0.3s ease; }
  .field-error {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239,68,68,0.15) !important;
  }
</style>
<script>
  document.addEventListener('DOMContentLoaded', function () {
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

    // Populate dari old()
    @if(old('content') || (isset($article) && $article->content))
      quill.root.innerHTML = {!! json_encode(old('content', isset($article) ? $article->content : '')) !!};
    @endif

    function showErrorToast(errors) {
      const toast = document.getElementById('form-error-toast');
      const list = document.getElementById('form-error-list');
      list.innerHTML = errors.map(e => `<li>${e}</li>`).join('');
      toast.style.display = 'flex';
      setTimeout(() => { toast.style.display = 'none'; }, 6000);
    }

    function markError(el) {
      if (!el) return;
      el.classList.add('field-error');
      el.addEventListener('input', () => el.classList.remove('field-error'), { once: true });
      el.addEventListener('change', () => el.classList.remove('field-error'), { once: true });
    }

    const form = document.getElementById('article-form');
    form.addEventListener('submit', function(e) {
      // Sync Quill ke textarea
      document.getElementById('content-input').value = quill.root.innerHTML;

      const titleEl  = form.querySelector('input[name="title"]');
      const content  = quill.getText().trim();
      // Parent category select (AlpineJS x-model)
      const parentEl = form.querySelector('select[data-role="parent-category"]');
      // Subkategori select (has name="category_id")
      const subCatEl = form.querySelector('select[name="category_id"]');

      // Read Alpine-managed value correctly
      const parentVal = parentEl ? parentEl.value : '';
      const subCatVal = subCatEl ? subCatEl.value : '';

      const errors = [];
      const errEls = [];

      if (!titleEl.value.trim()) {
        errors.push('Judul artikel wajib diisi.');
        errEls.push(titleEl);
      }
      if (!content || content.length < 2) {
        errors.push('Konten artikel wajib diisi (tulis di editor).');
        // Highlight Quill container
        document.querySelector('.ql-container')?.classList.add('field-error');
        setTimeout(() => document.querySelector('.ql-container')?.classList.remove('field-error'), 4000);
      }
      if (!parentVal) {
        errors.push('Kategori utama wajib dipilih.');
        if (parentEl) errEls.push(parentEl);
      }
      if (!subCatVal) {
        errors.push('Subkategori wajib dipilih.');
        if (subCatEl) errEls.push(subCatEl);
      }

      if (errors.length > 0) {
        e.preventDefault();
        errEls.forEach(markError);
        showErrorToast(errors);
        // Scroll ke field pertama yang error
        errEls[0]?.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
      }
    });
  });
</script>
@endpush
