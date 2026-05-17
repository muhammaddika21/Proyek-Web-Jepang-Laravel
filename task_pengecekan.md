# ✅ Task Pengecekan Manual — Update Terbaru (24 April 2026)

Panduan ini mencakup semua perubahan terbaru. Centang setiap item setelah memverifikasi.

---

## 1. Navbar

- [ ] **Lebar container navbar** — Buka halaman apapun di desktop lebar. Pastikan navbar kini terlihat sedikit lebih lebar dari sebelumnya (max-width sudah naik +90px menjadi 1290px).
- [ ] **Burger icon di pojok kanan** — Perkecil browser ke ukuran mobile (< 768px). Pastikan icon hamburger (☰) berada di **pojok kanan atas**, bukan di kiri. Klik burger, pastikan menu dropdown muncul dengan benar.

---

## 2. Halaman Home — Section "Kegiatan & Budaya"

- [ ] **Urutan card** — Scroll ke bagian *Kegiatan & Budaya*. Pastikan urutan card dari kiri ke kanan adalah:
  1. **Kegiatan Terbaru** (📰)
  2. **Event** (🎎) ← sekarang di posisi ke-2
  3. **Budaya** (🎌) ← sekarang di posisi ke-3
  4. Anime, Manga & Game (🎮)

---

## 3. Halaman Daftar Artikel (Index) — Budaya & Kegiatan

### A. Filter Bar / Container Kategori
- [ ] **Lebar filter bar** — Pastikan filter bar lebih lebar dari sebelumnya (sekarang 90% layar, max 1100px) sehingga tombol kategori tidak terjepit.
- [ ] **Kategori di tengah** — Tombol-tombol kategori (misal: *Event*, *Kegiatan Terbaru*) harus benar-benar berada **di tengah** container filter bar dan di tengah layar.
- [ ] **Responsif mobile** — Di ukuran HP, pastikan filter bar menjadi vertikal (search di atas, tombol kategori wrap di bawah) dan masih rapi, tidak terpotong.

### B. Card Placeholder (Tanpa Thumbnail)
- [ ] **Gradient premium** — Jika ada artikel tanpa `cover_image`, pastikan card menampilkan **gradient warna penuh** (hijau/merah/oranye sesuai section) dengan watermark kanji besar dan label teks di bawah — bukan kotak kosong pucat.

### C. Section Heading Kategori
- [ ] **Heading centered** — Judul section (misal: *Event*, *Kegiatan Terbaru*) dan jumlah artikel harus **sejajar vertikal** (items-center).

---

## 4. Halaman Detail Artikel (Show Page) — Bahasa, Budaya, Kegiatan

### A. Judul Artikel
- [ ] **Judul di tengah** — Buka artikel apapun. Pastikan:
  - Badge level/kategori → centered
  - Judul H1 → centered
  - Info "Oleh ... • X min baca • tanggal" → centered
  - Semua berada di **tengah header**, bukan rata kiri.

### B. Background Prev/Next Navigation
- [ ] **Warna background** — Scroll ke bagian paling bawah artikel (section "Sebelumnya / Berikutnya"). Pastikan:
  - Warna background section ini adalah **krem (#f8f7ef)** ← sama dengan warna body/halaman
  - **Bukan putih (bg-gray-50)** yang kontras

### C. Sidebar Bahasa — Tips Belajar DIHAPUS
- [ ] **Bahasa only** — Buka halaman artikel **Bahasa**. Pastikan sidebar kanan hanya berisi:
  - Link "Kembali ke Daftar Materi"
  - Card "Info Artikel" (Level, Kategori, Waktu Baca, Tanggal)
  - **TIDAK ADA** kotak "Tips Belajar" (bulat hijau dengan checklist)
- [ ] **Budaya & Kegiatan tetap ada** — Buka artikel **Budaya** atau **Kegiatan**. Pastikan sidebar masih memiliki kotak "Tips Belajar" / "Tips Kegiatan" yang sesuai.

### D. Preview Gambar Setelah Dihapus
- [ ] **Cover image dihapus** — Jika Anda menghapus `cover_image` dari artikel via admin, buka ulang halaman artikel tersebut di sisi publik (client). Pastikan:
  - Header artikel menampilkan **gradient** (bukan gambar lama yang di-cache)
  - Card di halaman index juga menampilkan **gradient placeholder**, bukan gambar lama
  - Jika masih muncul gambar lama, coba **hard refresh** (Ctrl+Shift+R)

---

## 5. Verifikasi Backend (Syntax & Struktur)

Status pengecekan otomatis:

| File | @extends | @section | @endsection | @push/@endpush | Status |
|------|----------|----------|-------------|----------------|--------|
| bahasa/show.blade.php | ✅ | ✅ | ✅ | ✅ | **OK** |
| budaya/show.blade.php | ✅ | ✅ | ✅ | ✅ | **OK** |
| kegiatan/show.blade.php | ✅ | ✅ | ✅ | ✅ | **OK** |
| home.blade.php | ✅ | ✅ | ✅ | ✅ | **OK** |
| navbar.blade.php | — | — | — | — | **OK** |
| bahasa/index.blade.php | ✅ | ✅ | ✅ | ✅ | **OK** |
| budaya/index.blade.php | ✅ | ✅ | ✅ | ✅ | **OK** |
| kegiatan/index.blade.php | ✅ | ✅ | ✅ | ✅ | **OK** |

### Langkah Verifikasi Tambahan
- [ ] Jalankan `php artisan view:cache` — Pastikan output `Blade templates cached successfully` tanpa error.
- [ ] Jalankan `php artisan route:list` — Pastikan semua route bahasa/budaya/kegiatan tidak ada yang conflict.
- [ ] Buka masing-masing halaman di browser — Pastikan tidak ada **blank page** atau **500 error**.

---

## Ringkasan Perubahan yang Diuji

| # | Perubahan | File yang Terpengaruh |
|---|-----------|----------------------|
| 1 | Judul artikel di-center | bahasa/budaya/kegiatan `show.blade.php` |
| 2 | Background prev/next → #f8f7ef | bahasa/budaya/kegiatan `show.blade.php` |
| 3 | Filter bar lebih lebar & responsive | budaya/kegiatan `index.blade.php` |
| 4 | Burger icon pojok kanan + navbar +90px | `navbar.blade.php` |
| 5 | Gradient card placeholder | bahasa/budaya/kegiatan `index.blade.php` |
| 6 | Kategori tombol centered | budaya/kegiatan `index.blade.php` |
| 7 | Urutan card: Keg.Terbaru→Event→Budaya | `home.blade.php` |
| 8 | Hapus Tips Belajar sidebar bahasa | bahasa `show.blade.php` |

---

> 💡 **Tip**: Lakukan hard refresh (Ctrl+Shift+R) di browser setelah perubahan agar CSS/cache terbaru ter-load.
