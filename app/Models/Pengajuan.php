<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // --- Relasi yang sudah ada ---
    public function masyarakat()
    {
        return $this->belongsTo(Masyarakat::class, 'nik', 'nik');
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

    public function kematian()
    {
        return $this->hasOne(Kematian::class);
    }

    public function pindahPenduduk()
    {
        return $this->hasOne(PindahPenduduk::class);
    }

    public function domisiliUsahaYayasan()
    {
        return $this->hasOne(DomisiliUsahaYayasan::class);
    }

    public function usaha()
    {
        return $this->hasOne(Usaha::class);
    }

    public function keramaian()
    {
        return $this->hasOne(Keramaian::class);
    }


    // =======================================================
    // ▼▼▼ METHOD RELASI YANG HILANG TELAH SAYA TAMBAHKAN DI SINI ▼▼▼
    // =======================================================
    /**
     * Mendefinisikan relasi one-to-one ke TempatTinggalSementara.
     */
    public function tempatTinggalSementara()
    {
        // Asumsi nama modelnya adalah TempatTinggalSementara
        return $this->hasOne(TempatTinggalSementara::class);
    }
    // =======================================================
    // ▲▲▲ PENAMBAHAN SELESAI ▲▲▲
    // =======================================================
}

