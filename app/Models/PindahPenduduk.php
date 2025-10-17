<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PindahPenduduk extends Model
{
    use HasFactory;

    protected $table = 'pindah_penduduk'; // nama tabel

    protected $fillable = [
        'pengajuan_id',
        'desa_kelurahan',
        'kecamatan',
        'kab_kota',
        'provinsi',
        'tanggal_pindah',
        'alasan_pindah',
        'pengikut',
    ];

    // relasi ke pengajuan
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }
}
