<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\KeteranganBeasiswa;
use Illuminate\Http\Request;

class KeteranganBeasiswaController extends Controller
{
    public function index()
    {
        $title = "Keterangan Beasiswa";

        $keteranganbeasiswa = KeteranganBeasiswa::orderBy('posisi', 'asc')->get();

        return view('frontend.keterangan.index', compact('title', 'aparatur'));
    }
}
