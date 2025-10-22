<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // --- Relasi yang sudah ada ---
    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function pelayanan()
    {
        return $this->belongsTo(Pelayanan::class);
    }

    public function dokumenPersyaratan()
    {
        return $this->hasMany(DokumenPersyaratan::class);
    }

    public function verifikasiByAparatur($aparatur_id)
    {
        return $this->hasMany(Verifikasi::class)->where('aparatur_id', $aparatur_id);
    }
}

