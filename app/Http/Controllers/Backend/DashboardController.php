<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Pelayanan;
use App\Models\Pengajuan;
use App\Models\Mahasiswa;
use App\Models\Aparatur;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = "Dashboard";

        $jumlahPelayanan = Pelayanan::count();
        $jumlahPengajuan = Pengajuan::count();
        $jumlahMasyarakat = Mahasiswa::count();
        $jumlahAparatur = Aparatur::count();

        $totalLakiLaki = Mahasiswa::where('jk', 'Laki-laki')->count();
        $totalPerempuan = Mahasiswa::where('jk', 'Perempuan')->count();

        return view('backend.dashboard.index', compact('title', 'jumlahPelayanan', 'jumlahPengajuan', 'jumlahMasyarakat', 'jumlahAparatur', 'totalLakiLaki', 'totalPerempuan'));
    }
}
