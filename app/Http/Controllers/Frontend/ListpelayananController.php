<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pelayanan;
use Illuminate\Http\Request;

class ListpelayananController extends Controller
{
    public function index()
{
    $title = 'List Pelayanan';

    // Id/layanan yang harusnya offline
    $offlineNames = [
        'Surat Pengantar Nikah',
        'Pengurusan Kartu Keluarga (KK)',
        'Pengurusan KTP',
        'Surat Keterangan Ahli Waris',
        'Surat Keterangan Hak Tanah'
    ];

    // Online = semua kecuali daftar offline
    $pelayanan = Pelayanan::whereNotIn('nama', $offlineNames)->get();

    return view('frontend.list-pelayanan.index', compact('title', 'pelayanan'));
}

}
