<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ttd extends Model
{
    // Nama tabel (opsional, tapi disarankan eksplisit)
    protected $table = 'ttds';

    // Kolom yang bisa diisi melalui mass assignment
    protected $fillable = [
        'nip',
        'nama',
        'jabatan',
        'pangkat_golruang',
        'fakultas',
        'foto',
        'posisi',
    ];
}
