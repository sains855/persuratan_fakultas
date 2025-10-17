<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permohonan; // Ganti dengan nama model Permohonan Anda
use App\Models\Pelayanan; // Ganti dengan nama model Pelayanan Anda
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Pengajuan Surat';

        // Ambil semua jenis pelayanan untuk filter dropdown
        $semua_pelayanan = Pelayanan::orderBy('nama_layanan', 'asc')->get();

        // Query dasar untuk mengambil permohonan
        $query = Permohonan::with('mahasiswa', 'pelayanan')
                            ->where('status', 'Baru') // Hanya tampilkan yang perlu diverifikasi
                            ->latest(); // Urutkan dari yang terbaru

        // Terapkan filter jika ada
        if ($request->has('id_pelayanan') && $request->id_pelayanan != '') {
            $query->where('id_pelayanan', $request->id_pelayanan);
        }

        $daftar_permohonan = $query->paginate(10); // Tampilkan 10 per halaman

        return view('backend.permohonan.index', compact(
            'title',
            'daftar_permohonan',
            'semua_pelayanan'
        ));
    }

    // Nanti Anda akan membuat method show(), proses(), dll. di sini
}
