<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KeteranganBeasiswa; // Asumsi nama model Anda
use App\Models\Mahasiswa; // Asumsi nama model Mahasiswa
use Illuminate\Support\Facades\Redirect;

class KeteranganController extends Controller
{
    /**
     * Menampilkan daftar keterangan beasiswa.
     */
    public function index(Request $request)
    {
        $query = KeteranganBeasiswa::query();
        $title = 'Keterangan Beasiswa';

        // Logika pencarian
        if ($search = $request->query('q')) {
            $query->where('mahasiswa_nim', 'like', "%{$search}%")
                  ->orWhere('status_beasiswa', 'like', "%{$search}%")
                  ->orWhere('keterangan_beasiswa', 'like', "%{$search}%");
        }

        // Ambil data dengan paginasi
        $beasiswa = $query->latest()->paginate(10); // 10 data per halaman

        return view('backend.keterangan.index', [
            'title' => $title,
            'beasiswa' => $beasiswa,
        ]);
    }

    /**
     * Menghapus data dari database.
     */
    public function delete(KeteranganBeasiswa $keteranganBeasiswa)
    {
        $keteranganBeasiswa->delete();

        return Redirect::route('keterangan_beasiswa.index')
            ->with('success', 'Data Keterangan Beasiswa Mahasiswa berhasil dihapus!');
    }
}
