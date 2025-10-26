<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $guarded = ['id'];
    protected $primaryKey = 'nim';

    public function dokumenPersyaratan()
    {
        return $this->hasMany(DokumenPersyaratan::class, 'nim');
    }

    public function keteranganBeasiswa()
    {
        return $this->belongsTo(KeteranganBeasiswa::class, 'mahasiswa_nim', 'id');
    }
    public function Alumni()
    {
        return $this->belongsTo(Alumni::class, 'mahasiswa_nim', 'id');
    }
}
