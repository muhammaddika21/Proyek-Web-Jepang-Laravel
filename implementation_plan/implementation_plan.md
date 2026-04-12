# Perbaikan Admin Dashboard: Edit Artikel, Preview Media, Sorting, dan Kategori

## Ringkasan Masalah & Solusi

Ada 5 masalah utama yang perlu diperbaiki berdasarkan permintaan Anda:

### 1. ❌ BUG: Klik judul artikel → malah buat artikel baru (bukan edit)
**Penyebab:** Method `edit()` di controller sudah benar mengirim `$article` ke view, tapi form di `create.blade.php` dan `create-bahasa.blade.php` selalu menggunakan `action="{{ route('admin.articles.store') }}"` (route POST baru). Saat mode edit, seharusnya form diarahkan ke route `PUT /articles/{id}` (`admin.articles.update`).

**Solusi:** Tambahkan deteksi `@if(isset($article))` di kedua view untuk:
- Ubah form `action` ke route `update` + tambah `@method('PUT')`
- Auto-populate semua field (judul, slug, kategori, excerpt, konten Quill, kosakata, kuis)
- Ubah judul halaman dari "Buat Artikel" → "Edit Artikel"

---

### 2. 🖼️ Preview Artikel: Tampilkan media tambahan (gambar, audio, YouTube)
**Kondisi sekarang:** `show.blade.php` sudah punya section galeri foto dan audio player, tapi bagian YouTube belum ada, dan media ringkasan di sidebar belum menampilkan file yang sebenarnya.

**Solusi:** Update `show.blade.php`:
- Pastikan galeri foto menampilkan gambar-gambar `additional_images`
- Audio player memutar file `audio_file`
- Tambahkan embed YouTube jika `youtube_url` ada (perlu kolom baru di migration)
- Di sidebar "Ringkasan Media", tunjukkan thumbnail kecil jika ada file

---

### 3. 📂 Dropdown Kategori di Kelola Artikel → Pisah Bahasa & Umum
**Kondisi sekarang:** Dropdown kategori sudah menggunakan `<optgroup>` yang memisahkan "📘 Bahasa Jepang" dan "🏯 Umum" — ini sudah benar.

**Solusi:** Sesuai screenshot, dropdown ini sudah berfungsi. Saya akan pastikan tetap rapi.

---

### 4. 🔄 Perbaiki Sorting Terbaru / Terlama
**Penyebab:** Di `index()` controller, `$query->latest()` dipanggil DI AWAL (line 20) dan kemudian dipanggil lagi di block `match` (line 47). Jadi ada dua `orderBy`, yang pertama selalu menang.

**Solusi:** Hapus `->latest()` di awal query, biarkan sorting diatur hanya dari block `match`.

---

### 5. 🏗️ Layout Create Bahasa: Pertahankan kolom kiri-kanan
**Kondisi sekarang:** Layout sudah `grid-cols-10` (7 kiri + 3 kanan) — ini sudah benar, ada sidebar di kanan.

**Solusi:** Tidak perlu diubah layout-nya, sudah correct.

---

## Database: Migration Baru

#### [MODIFY] [2024_01_01_001003_update_articles_add_media_fields.php](file:///c:/stis/NON%20KULIAH/Project/Web%20dev/CODELARAVELBARU/nihon-learn-laravel/database/migrations/2024_01_01_001003_update_articles_add_media_fields.php)
- Tambah kolom `youtube_url` (string, nullable) untuk embed video YouTube

---

## Proposed Changes

### Backend (Controller)

#### [MODIFY] [ArticleController.php](file:///c:/stis/NON%20KULIAH/Project/Web%20dev/CODELARAVELBARU/nihon-learn-laravel/app/Http/Controllers/Admin/ArticleController.php)
1. **Fix sorting bug**: Hapus `->latest()` di awal query `index()`
2. **Fix `update()` method**: Tambah handling `additional_images`, `audio_file`, `kemahiran_level`, `youtube_url` (saat ini masih pakai `jlpt_level`)
3. **Fix `edit()` method**: Pastikan data lama ter-populate ke form

#### [MODIFY] [Article.php](file:///c:/stis/NON%20KULIAH/Project/Web%20dev/CODELARAVELBARU/nihon-learn-laravel/app/Models/Article.php)
- Tambah `youtube_url` ke `$fillable`

---

### Views

#### [MODIFY] [create.blade.php](file:///c:/stis/NON%20KULIAH/Project/Web%20dev/CODELARAVELBARU/nihon-learn-laravel/resources/views/admin/articles/create.blade.php)
- Deteksi mode edit: ubah form action, tambah `@method('PUT')`, populate field lama

#### [MODIFY] [create-bahasa.blade.php](file:///c:/stis/NON%20KULIAH/Project/Web%20dev/CODELARAVELBARU/nihon-learn-laravel/resources/views/admin/articles/create-bahasa.blade.php)
- Deteksi mode edit: ubah form action, tambah `@method('PUT')`, populate semua field (termasuk kosakata dan kuis dari data JSON)

#### [MODIFY] [show.blade.php](file:///c:/stis/NON%20KULIAH/Project/Web%20dev/CODELARAVELBARU/nihon-learn-laravel/resources/views/admin/articles/show.blade.php)
- Tambahkan YouTube embed
- Perbaiki tampilan galeri dan audio
- Sidebar "Ringkasan Media" lebih interaktif

---

## Verification Plan

### Manual Verification
1. **Buat artikel bahasa baru** → isi semua field + upload gambar + upload audio → simpan → cek preview
2. **Edit artikel yang sudah ada** → pastikan semua data lama ter-populate → ubah judul → simpan → cek judul berubah
3. **Cek sorting** → Buat 2 artikel (satu hari ini, satu kemarin). Filter "Terbaru" harus menampilkan yang hari ini di atas. Filter "Terlama" harus membalik urutannya.
