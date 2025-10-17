<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use App\Models\Pelayanan;
use App\Models\Aparatur;
use App\Models\Berita;
use App\Models\Mahasiswa;// Tambahkan ini
use Illuminate\Http\Request;
use Carbon\Carbon; // Tambahkan ini untuk mempermudah perhitungan usia

class BerandaController extends Controller
{
    public function index()
    {
        // Ambil data-data statis seperti biasa
        $pelayanan = Pelayanan::whereIn('id', [7, 10, 13])->get();
        $aparatur = Aparatur::orderBy('posisi', 'asc')->paginate(4);


        // -------------------------------------------------------------
        // Logika untuk mengambil data demografi dari tabel Mahasiswas
        // -------------------------------------------------------------
        $totalPenduduk = Mahasiswa::count();

        // Data Jenis Kelamin

        return view('frontend.beranda.index', [
            'pelayanan' => $pelayanan,
            'aparatur' => $aparatur,
            'totalPenduduk' => $totalPenduduk,
        ]);
    }
}
