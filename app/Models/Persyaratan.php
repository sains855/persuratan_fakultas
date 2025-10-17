<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persyaratan extends Model
{
    protected $fillable = [
        'nama',
        'keterangan',
    ];
}
