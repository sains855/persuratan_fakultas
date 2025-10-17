<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PelayananPersyaratan extends Model
{
    protected $fillable = [
        'pelayanan_id',
        'persyaratan_id',
    ];

    public function pelayanan()
    {
        return $this->hasMany(Pelayanan::class, 'pelayanan_id', 'id');
    }
    public function persyaratan()
    {
        return $this->belongsTo(Persyaratan::class, 'persyaratan_id', 'id');
    }
}
