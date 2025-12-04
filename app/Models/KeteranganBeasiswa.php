<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KeteranganBeasiswa extends Model
{
    protected $guarded = ['id'];

    public function Mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_nim', 'nim');
    }
}
