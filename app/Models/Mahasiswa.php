<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Mahasiswa extends Model
{
    protected $table = 'mahasiswas';

    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    public function dokumenPersyaratan()
    {
        return $this->hasMany(DokumenPersyaratan::class, 'nim', 'nim');
    }

    public function orangTua()
    {
        return $this->hasOne(OrangTua::class, 'mahasiswa_nim', 'nim');
    }

    public function alumni()
    {
        return $this->hasOne(Alumni::class, 'mahasiswa_nim', 'nim');
    }
}
