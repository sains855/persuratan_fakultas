<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    protected $fillable = [
        'pelayanan_id',
        'nim',
    ];

    public function pelayanan()
    {
        return $this->hasMany(Pelayanan::class, 'pelayanan_id', 'id');
    }
    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class, 'mahasiswa_nim', 'nim');
    }
}
