<?php

namespace App\Http\Controllers;

use App\Models\PengurusInti;
use App\Models\Divisi;

class KepengurusanController extends Controller
{
    public function index()
    {
        $pengurusInti = PengurusInti::orderBy('id')->get();
        $divisi       = Divisi::with(['anggota' => function ($q) {
            $q->orderBy('jabatan', 'desc')->orderBy('urutan');
        }])->orderBy('urutan')->get();

        return view('pages.kepengurusan', compact('pengurusInti', 'divisi'));
    }
}
