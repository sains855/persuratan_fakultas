<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPersyaratan extends Model
{
    protected $guarded = ['id'];

    public function persyaratan()
    {
        return $this->belongsTo(Persyaratan::class, 'persyaratan_id');
    }
}
