<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswas'; // opsional, tapi bagus untuk eksplisit

    protected $primaryKey = 'nim';
    public $incrementing = false; // <- penting!
    protected $keyType = 'string'; // <- penting!

    protected $guarded = []; // nim bisa ikut diisi, atau pakai $fillable kalau mau lebih spesifik

    public function dokumenPersyaratan()
    {
        return $this->hasMany(DokumenPersyaratan::class, 'nim');
    }

    public function keteranganBeasiswa()
    {
        return $this->belongsTo(KeteranganBeasiswa::class, 'mahasiswa_nim', 'id');
    }

    public function alumni()
    {
        return $this->belongsTo(Alumni::class, 'mahasiswa_nim', 'id');
    }
}
