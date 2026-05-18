<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $table = 'divisi';

    protected $fillable = ['nama', 'slug', 'deskripsi', 'urutan'];

    public function anggota()
    {
        return $this->hasMany(AnggotaDivisi::class, 'divisi_id')->orderBy('urutan')->orderBy('id');
    }

    public function ketuaDivisi()
    {
        return $this->hasOne(AnggotaDivisi::class, 'divisi_id')->where('jabatan', 'Ketua Divisi');
    }
}
