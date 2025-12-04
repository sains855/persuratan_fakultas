<?php

namespace App\Http\Controllers\Frontend;

use App\Models\KeteranganBeasiswa;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class KeteranganBeasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $keteranganBeasiswas = KeteranganBeasiswa::with('mahasiswa')->get();

        return response()->json([
            'success' => true,
            'message' => 'Data keterangan beasiswa berhasil diambil',
            'data' => $keteranganBeasiswas
        ], 200);
    }

    /**
     * Show the form for creating a new resource (form cek NIM)
     */
    public function create()
    {
        $title = "Form Cek NIM - Keterangan Beasiswa";

        return view('frontend.keteranganbeasiswa.detail', compact('title'));
    }

    /**
     * Proses pengecekan NIM
     */
    public function cekNim(Request $request)
    {
        $request->validate([
            'nim' => 'required|string'
        ], [
            'nim.required' => 'NIM harus diisi'
        ]);

        $nim = $request->nim;

        // Arahkan ke detail (baik NIM ditemukan atau tidak)
        return redirect()->route('frontend.keteranganbeasiswa.detail', ['nim' => $nim]);
    }

    /**
     * Tampilkan halaman detail dengan form keterangan beasiswa atau form mahasiswa baru
     */
    public function detail($nim)
    {
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
        $nimDitemukan = false;
        $showMahasiswaForm = false;
        $sudahTerisi = false;
        $keteranganBeasiswa = null;

        if ($mahasiswa) {
            // Cek apakah mahasiswa sudah memiliki keterangan beasiswa
            $keteranganBeasiswa = KeteranganBeasiswa::where('mahasiswa_nim', $nim)->first();

            if ($keteranganBeasiswa) {
                // Cek status beasiswa (case-insensitive dan trim whitespace)
                $statusBeasiswa = strtolower(trim($keteranganBeasiswa->status_beasiswa));

                // Jika status adalah "menerima beasiswa", tampilkan view-only
                if ($statusBeasiswa === 'menerima beasiswa') {
                    return view('frontend.keteranganbeasiswa.detail', [
                        'title' => 'Data Keterangan Beasiswa',
                        'mahasiswa' => $mahasiswa,
                        'nim' => $nim,
                        'nimDitemukan' => false,
                        'showMahasiswaForm' => false,
                        'sudahTerisi' => true,
                        'keteranganBeasiswa' => $keteranganBeasiswa
                    ]);
                }
                // Jika status "belum menerima beasiswa", tampilkan form untuk update
                $nimDitemukan = true;
            } else {
                // Mahasiswa ada, tapi belum ada keterangan beasiswa
                $nimDitemukan = true;
            }
        } else {
            // NIM tidak ditemukan, tampilkan form input mahasiswa
            $showMahasiswaForm = true;
        }

        $title = $nimDitemukan ? "Form Keterangan Beasiswa" : "Form Data Mahasiswa Baru";

        return view('frontend.keteranganbeasiswa.detail', compact(
            'mahasiswa',
            'nim',
            'nimDitemukan',
            'showMahasiswaForm',
            'sudahTerisi',
            'keteranganBeasiswa',
            'title'
        ));
    }

    /**
     * Simpan data mahasiswa baru
     */
    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|max:20|unique:mahasiswas,nim',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tgl_lahir' => 'required|date|before:today',
            'Fakultas' => 'required|string|max:255',
            'Prodi_jurusan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'No_Hp' => 'required|string|digits_between:10,15',
            'email' => 'required|email|unique:mahasiswas,email',
        ], [
            'nim.required' => 'NIM harus diisi.',
            'nim.unique' => 'NIM sudah terdaftar dalam sistem.',
            'nama.required' => 'Nama mahasiswa harus diisi.',
            'tempat_lahir.required' => 'Tempat lahir harus diisi.',
            'tgl_lahir.required' => 'Tanggal lahir harus diisi.',
            'tgl_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',
            'Fakultas.required' => 'Fakultas harus dipilih.',
            'Prodi_jurusan.required' => 'Program Studi/Jurusan harus dipilih.',
            'alamat.required' => 'Alamat harus diisi.',
            'No_Hp.required' => 'Nomor HP harus diisi.',
            'No_Hp.digits_between' => 'Nomor HP harus antara 10-15 digit.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar dalam sistem.',
        ]);

        try {
            // Simpan data mahasiswa baru
            $mahasiswa = Mahasiswa::create([
                'nim' => $request->nim,
                'nama' => $request->nama,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'Fakultas' => $request->Fakultas,
                'Prodi_jurusan' => $request->Prodi_jurusan,
                'alamat' => $request->alamat,
                'No_Hp' => $request->No_Hp,
                'email' => $request->email,
            ]);

            Log::info('Data mahasiswa baru berhasil disimpan untuk keterangan beasiswa', [
                'nim' => $mahasiswa->nim,
                'nama' => $mahasiswa->nama,
                'email' => $mahasiswa->email
            ]);

            // Redirect ke detail dengan NIM yang baru disimpan
            return redirect()->route('frontend.keteranganbeasiswa.detail', ['nim' => $mahasiswa->nim])
                ->with('success_mahasiswa', 'Data mahasiswa berhasil disimpan. Silakan lanjutkan mengisi form keterangan beasiswa.');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan data mahasiswa untuk keterangan beasiswa', [
                'error' => $e->getMessage(),
                'nim' => $request->nim
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_nim' => 'required|string|exists:mahasiswas,nim',
            'status_beasiswa' => 'required|string|max:255',
            'keterangan_beasiswa' => 'required|string'
        ], [
            'mahasiswa_nim.required' => 'NIM mahasiswa wajib diisi',
            'mahasiswa_nim.exists' => 'NIM mahasiswa tidak ditemukan',
            'status_beasiswa.required' => 'Status beasiswa wajib diisi',
            'keterangan_beasiswa.required' => 'Keterangan beasiswa wajib diisi'
        ]);

        try {
            // Cek apakah mahasiswa sudah memiliki keterangan beasiswa
            $existingKeterangan = KeteranganBeasiswa::where('mahasiswa_nim', $request->mahasiswa_nim)->first();

            if ($existingKeterangan) {
                $statusBeasiswa = strtolower(trim($existingKeterangan->status_beasiswa));

                // Jika statusnya "menerima beasiswa", tidak boleh update
                if ($statusBeasiswa === 'menerima beasiswa') {
                    return back()->with('error', 'Data tidak dapat diubah karena mahasiswa sudah menerima beasiswa')
                        ->withInput();
                }

                // Jika statusnya "belum menerima beasiswa", lakukan update
                $existingKeterangan->update([
                    'status_beasiswa' => $request->status_beasiswa,
                    'keterangan_beasiswa' => $request->keterangan_beasiswa
                ]);

                Log::info('Keterangan beasiswa berhasil diupdate', [
                    'nim' => $request->mahasiswa_nim,
                    'status_lama' => $statusBeasiswa,
                    'status_baru' => $request->status_beasiswa
                ]);

                return redirect()->route('frontend.keteranganbeasiswa.detail', ['nim' => $request->mahasiswa_nim])
                    ->with('success', 'Data keterangan beasiswa berhasil diperbarui!');
            }

            // Jika belum ada data, buat baru
            $keteranganBeasiswa = KeteranganBeasiswa::create([
                'mahasiswa_nim' => $request->mahasiswa_nim,
                'status_beasiswa' => $request->status_beasiswa,
                'keterangan_beasiswa' => $request->keterangan_beasiswa
            ]);

            Log::info('Keterangan beasiswa berhasil dibuat', [
                'nim' => $request->mahasiswa_nim,
                'status' => $request->status_beasiswa
            ]);

            return redirect()->route('frontend.keteranganbeasiswa.detail', ['nim' => $request->mahasiswa_nim])
                ->with('success', 'Data keterangan beasiswa berhasil disimpan!');
        } catch (\Exception $e) {
            Log::error('Error saat menyimpan keterangan beasiswa', [
                'error' => $e->getMessage(),
                'nim' => $request->mahasiswa_nim
            ]);

            return back()->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $keteranganBeasiswa = KeteranganBeasiswa::with('mahasiswa')->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Data keterangan beasiswa ditemukan',
                'data' => $keteranganBeasiswa
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data keterangan beasiswa tidak ditemukan'
            ], 404);
        }
    }

    /**
     * Get keterangan beasiswa by mahasiswa NIM
     */
    public function getByNim($nim)
    {
        try {
            $keteranganBeasiswas = KeteranganBeasiswa::with('mahasiswa')
                ->where('mahasiswa_nim', $nim)
                ->get();

            if ($keteranganBeasiswas->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan untuk NIM tersebut'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data keterangan beasiswa berhasil diambil',
                'data' => $keteranganBeasiswas
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
