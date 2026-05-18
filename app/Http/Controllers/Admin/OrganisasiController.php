<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengurusInti;
use App\Models\Divisi;
use App\Models\AnggotaDivisi;
use Illuminate\Http\Request;

class OrganisasiController extends Controller
{
    // =============================================
    // PENGURUS INTI
    // =============================================

    /** Halaman utama organisasi: tampilkan ketua, wakil, dan semua divisi */
    public function index()
    {
        $pengurusInti = PengurusInti::orderBy('id')->get();
        $divisi       = Divisi::with('anggota')->orderBy('urutan')->get();

        return view('admin.organisasi.index', compact('pengurusInti', 'divisi'));
    }

    /** Form edit pengurus inti (ketua / wakil) */
    public function editPengurus(PengurusInti $pengurus)
    {
        return view('admin.organisasi.edit-pengurus', compact('pengurus'));
    }

    /** Update pengurus inti */
    public function updatePengurus(Request $request, PengurusInti $pengurus)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nim'  => 'nullable|string|max:20',
        ], [
            'nama.required' => 'Nama wajib diisi.',
        ]);

        $pengurus->update($validated);

        return redirect()->route('admin.organisasi.index')
            ->with('success', "Data {$pengurus->jabatan} berhasil diperbarui.");
    }

    // =============================================
    // DIVISI — KETUA DIVISI
    // =============================================

    /** Form edit ketua divisi */
    public function editKetuaDivisi(Divisi $divisi)
    {
        $ketua = $divisi->ketuaDivisi;
        return view('admin.organisasi.edit-ketua-divisi', compact('divisi', 'ketua'));
    }

    /** Update ketua divisi */
    public function updateKetuaDivisi(Request $request, Divisi $divisi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nim'  => 'nullable|string|max:20',
        ], [
            'nama.required' => 'Nama wajib diisi.',
        ]);

        $ketua = $divisi->ketuaDivisi;
        if ($ketua) {
            $ketua->update($validated);
        } else {
            $divisi->anggota()->create(array_merge($validated, [
                'jabatan' => 'Ketua Divisi',
                'urutan'  => 0,
            ]));
        }

        return redirect()->route('admin.organisasi.index')
            ->with('success', "Ketua {$divisi->nama} berhasil diperbarui.");
    }

    // =============================================
    // ANGGOTA DIVISI
    // =============================================

    /** Halaman kelola anggota satu divisi */
    public function anggota(Divisi $divisi)
    {
        $anggota = $divisi->anggota()->where('jabatan', '!=', 'Ketua Divisi')->get();
        return view('admin.organisasi.anggota', compact('divisi', 'anggota'));
    }

    /** Form tambah anggota */
    public function createAnggota(Divisi $divisi)
    {
        return view('admin.organisasi.create-anggota', compact('divisi'));
    }

    /** Simpan anggota baru */
    public function storeAnggota(Request $request, Divisi $divisi)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nim'  => 'nullable|string|max:20',
        ], [
            'nama.required' => 'Nama anggota wajib diisi.',
        ]);

        $divisi->anggota()->create(array_merge($validated, [
            'jabatan' => 'Anggota',
            'urutan'  => $divisi->anggota()->max('urutan') + 1,
        ]));

        return redirect()->route('admin.organisasi.anggota', $divisi)
            ->with('success', "Anggota berhasil ditambahkan ke {$divisi->nama}.");
    }

    /** Form edit anggota */
    public function editAnggota(Divisi $divisi, AnggotaDivisi $anggota)
    {
        return view('admin.organisasi.edit-anggota', compact('divisi', 'anggota'));
    }

    /** Update anggota */
    public function updateAnggota(Request $request, Divisi $divisi, AnggotaDivisi $anggota)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'nim'  => 'nullable|string|max:20',
        ], [
            'nama.required' => 'Nama anggota wajib diisi.',
        ]);

        $anggota->update($validated);

        return redirect()->route('admin.organisasi.anggota', $divisi)
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /** Hapus anggota */
    public function destroyAnggota(Divisi $divisi, AnggotaDivisi $anggota)
    {
        $anggota->delete();

        return redirect()->route('admin.organisasi.anggota', $divisi)
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
