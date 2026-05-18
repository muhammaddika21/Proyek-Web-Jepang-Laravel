<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaDivisi extends Model
{
    protected $table = 'anggota_divisi';

    protected $fillable = ['divisi_id', 'nama', 'nim', 'jabatan', 'foto', 'urutan'];

    public function divisi()
    {
        return $this->belongsTo(Divisi::class, 'divisi_id');
    }
}
