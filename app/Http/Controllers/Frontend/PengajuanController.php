<?php
// File: app/Http/Controllers/Frontend/PengajuanController.php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DokumenPersyaratan;
use App\Models\Mahasiswa;
use App\Models\Pelayanan;
use App\Models\Pengajuan;
use App\Services\FcmService;
use Illuminate\Http\Request;
use App\Models\KeteranganBeasiswa;
use App\Models\OrangTua;
use App\Models\Alumni;
use App\Models\Ttd;
use Illuminate\Support\Facades\Log;

class PengajuanController extends Controller
{
    protected $fcmService;

    public function __construct(FcmService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

    /**
     * Tampilkan halaman form cek NIM
     */
    public function index($id)
    {
        $pelayanan = Pelayanan::findOrFail($id);
        $title = "Form Cek NIM";

        return view('frontend.pengajuan.index', compact('title', 'pelayanan', 'id'));
    }

    /**
     * Proses pengecekan NIM dan validasi khusus
     */
    public function cek(Request $request, $id)
    {
        $request->validate([
            'nim' => 'required|string'
        ]);

        $pelayanan = Pelayanan::findOrFail($id);
        $nim = $request->nim;

        // Cek apakah NIM ada di database
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        // ✅ VALIDASI KHUSUS: Surat Keterangan Tidak Sedang Menerima Beasiswa
        if ($pelayanan->nama === "Surat Keterangan Tidak Sedang Menerima Beasiswa") {
            $keteranganBeasiswa = KeteranganBeasiswa::where('mahasiswa_nim', $nim)->first();

            // Jika mahasiswa tercatat menerima beasiswa, tolak pengajuan
            if ($keteranganBeasiswa && $keteranganBeasiswa->status_beasiswa === "Menerima Beasiswa") {
                return back()->with('error', 'Anda sedang menerima beasiswa, tidak dapat mengajukan surat ini.');
            }
        }

        // ✅ ARAHKAN KE DETAIL (baik NIM ditemukan atau tidak)
        return redirect()->route('pengajuan.detail', ['id' => $id, 'nim' => $nim]);
    }

    /**
     * Tampilkan halaman detail pengajuan dengan form lengkap
     */
    public function detail($id, $nim = null)
    {
        $pelayanan = Pelayanan::findOrFail($id);
        $mahasiswa = null;
        $orangTua = null;
        $alumni = null;
        $ttd = null;
        $nimDitemukan = false;
        $showAlumniForm = false;
        $showOrangTuaForm = false;

        if ($nim) {
            $mahasiswa = Mahasiswa::where('nim', $nim)->first();

            if ($mahasiswa) {
                $nimDitemukan = true;

                // Load relasi sesuai kebutuhan surat
                switch ($pelayanan->nama) {
                    case "Surat Keterangan Aktif Kuliah":
                        $orangTua = OrangTua::where('mahasiswa_nim', $nim)->first();
                        $ttd = Ttd::first();

                        // ✅ JIKA DATA ORANG TUA BELUM ADA, TAMPILKAN FORM INPUT ORANG TUA
                        if (!$orangTua) {
                            $showOrangTuaForm = true;
                        }
                        break;

                    case "Surat Keterangan Alumni":
                        $alumni = Alumni::where('mahasiswa_nim', $nim)->first();
                        $ttd = Ttd::first();

                        // ✅ JIKA DATA ALUMNI BELUM ADA, TAMPILKAN FORM INPUT ALUMNI
                        if (!$alumni) {
                            $showAlumniForm = true;
                        }
                        break;

                    case "Surat Keterangan Mahasiswa Prestasi":
                    case "Surat Keterangan Berkelakuan Baik":
                    case "Surat Keterangan Tidak Sedang Bekerja":
                        // Hanya perlu data mahasiswa
                        break;

                    case "Surat Keterangan Tidak Sedang Menerima Beasiswa":
                        // Sudah divalidasi di method cek()
                        break;
                }
            }
        }

        return view('frontend.pengajuan.detail', compact(
            'pelayanan',
            'mahasiswa',
            'orangTua',
            'alumni',
            'ttd',
            'nimDitemukan',
            'showAlumniForm',
            'showOrangTuaForm'
        ));
    }

    /**
     * Simpan data orang tua (untuk Surat Keterangan Aktif Kuliah)
     * Disesuaikan dengan struktur migration orang_tuas
     */
    public function storeOrangTua(Request $request)
    {
        $request->validate([
            'nim' => 'required|exists:mahasiswas,nim',
            'nama' => 'required|string|max:255',
            'pekerjaaan' => 'required|string|max:255',
            'NIP_NOPensiun_NRP' => 'nullable|string|max:255',
            'pangkat' => 'nullable|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'nullable|string|digits_between:10,15',
        ], [
            'nim.required' => 'NIM mahasiswa harus diisi.',
            'nim.exists' => 'NIM tidak ditemukan dalam database.',
            'nama.required' => 'Nama orang tua harus diisi.',
            'pekerjaaan.required' => 'Pekerjaan orang tua harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'no_hp.digits_between' => 'Nomor HP harus antara 10-15 digit.',
        ]);

        try {
            // Cek apakah data orang tua sudah ada
            $existingOrangTua = OrangTua::where('mahasiswa_nim', $request->nim)->first();

            if ($existingOrangTua) {
                return back()->with('error', 'Data orang tua sudah tersimpan sebelumnya. Gunakan tombol edit untuk mengubah data.');
            }

            // Validasi NIP/No Pensiun/NRP jika diisi, harus unik
            if ($request->NIP_NOPensiun_NRP) {
                $existingNIP = OrangTua::where('NIP_NOPensiun_NRP', $request->NIP_NOPensiun_NRP)->first();
                if ($existingNIP) {
                    return back()->with('error', 'NIP/No. Pensiun/NRP sudah terdaftar.')->withInput();
                }
            }

            // Simpan data orang tua
            OrangTua::create([
                'mahasiswa_nim' => $request->nim,
                'nama' => $request->nama,
                'pekerjaaan' => $request->pekerjaaan,
                'NIP_NOPensiun_NRP' => $request->NIP_NOPensiun_NRP,
                'pangkat' => $request->pangkat,
                'instansi' => $request->instansi,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);

            Log::info('Data orang tua berhasil disimpan', [
                'nim' => $request->nim,
                'nama' => $request->nama,
                'pekerjaaan' => $request->pekerjaaan
            ]);

            return back()->with('success_orangtua', 'Data orang tua berhasil disimpan. Silakan lanjutkan mengisi form pengajuan.');

        } catch (\Exception $e) {
            Log::error('Error saat menyimpan data orang tua', [
                'error' => $e->getMessage(),
                'nim' => $request->nim
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                         ->withInput();
        }
    }

    /**
     * Update data orang tua
     */
    public function updateOrangTua(Request $request, $nim)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'pekerjaaan' => 'required|string|max:255',
            'NIP_NOPensiun_NRP' => 'nullable|string|max:255',
            'pangkat' => 'nullable|string|max:255',
            'instansi' => 'nullable|string|max:255',
            'alamat' => 'required|string',
            'no_hp' => 'nullable|string|digits_between:10,15',
        ], [
            'nama.required' => 'Nama orang tua harus diisi.',
            'pekerjaaan.required' => 'Pekerjaan orang tua harus diisi.',
            'alamat.required' => 'Alamat harus diisi.',
            'no_hp.digits_between' => 'Nomor HP harus antara 10-15 digit.',
        ]);

        try {
            $orangTua = OrangTua::where('mahasiswa_nim', $nim)->firstOrFail();

            // Validasi NIP/No Pensiun/NRP jika diisi dan diubah, harus tetap unik
            if ($request->NIP_NOPensiun_NRP && $request->NIP_NOPensiun_NRP !== $orangTua->NIP_NOPensiun_NRP) {
                $existingNIP = OrangTua::where('NIP_NOPensiun_NRP', $request->NIP_NOPensiun_NRP)->first();
                if ($existingNIP) {
                    return back()->with('error', 'NIP/No. Pensiun/NRP sudah terdaftar oleh orang tua lain.')->withInput();
                }
            }

            $orangTua->update([
                'nama' => $request->nama,
                'pekerjaaan' => $request->pekerjaaan,
                'NIP_NOPensiun_NRP' => $request->NIP_NOPensiun_NRP,
                'pangkat' => $request->pangkat,
                'instansi' => $request->instansi,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);

            Log::info('Data orang tua berhasil diupdate', [
                'nim' => $nim,
                'nama' => $request->nama
            ]);

            return back()->with('success_orangtua', 'Data orang tua berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Error saat update data orang tua', [
                'error' => $e->getMessage(),
                'nim' => $nim
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                         ->withInput();
        }
    }

    /**
     * Simpan data alumni (untuk Surat Keterangan Alumni)
     */
    public function storeAlumni(Request $request)
    {
        $request->validate([
            'nim' => 'required|exists:mahasiswas,nim',
            'no_ijazah' => 'required|string|max:100',
            'tahun_studi_mulai' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'tahun_studi_selesai' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'tgl_yudisium' => 'required|date|before_or_equal:today',
        ]);

        // Validasi tambahan: tahun selesai harus >= tahun mulai
        if ($request->tahun_studi_selesai < $request->tahun_studi_mulai) {
            return back()->with('error', 'Tahun studi selesai tidak boleh lebih awal dari tahun studi mulai.')
                         ->withInput();
        }

        try {
            // Cek apakah data alumni sudah ada
            $existingAlumni = Alumni::where('mahasiswa_nim', $request->nim)->first();

            if ($existingAlumni) {
                return back()->with('error', 'Data alumni sudah tersimpan sebelumnya. Gunakan tombol edit untuk mengubah data.');
            }

            // Validasi nomor ijazah harus unik
            $existingIjazah = Alumni::where('no_ijazah', $request->no_ijazah)->first();
            if ($existingIjazah) {
                return back()->with('error', 'Nomor ijazah sudah terdaftar.')->withInput();
            }

            // Simpan data alumni
            Alumni::create([
                'mahasiswa_nim' => $request->nim,
                'no_ijazah' => $request->no_ijazah,
                'tahun_studi_mulai' => $request->tahun_studi_mulai,
                'tahun_studi_selesai' => $request->tahun_studi_selesai,
                'tgl_yudisium' => $request->tgl_yudisium,
            ]);

            Log::info('Data alumni berhasil disimpan', [
                'nim' => $request->nim,
                'no_ijazah' => $request->no_ijazah
            ]);

            return back()->with('success_alumni', 'Data alumni berhasil disimpan. Silakan lanjutkan mengisi form pengajuan.');

        } catch (\Exception $e) {
            Log::error('Error saat menyimpan data alumni', [
                'error' => $e->getMessage(),
                'nim' => $request->nim
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                         ->withInput();
        }
    }

    /**
     * Update data alumni
     */
    public function updateAlumni(Request $request, $nim)
    {
        $request->validate([
            'no_ijazah' => 'required|string|max:100',
            'tahun_studi_mulai' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'tahun_studi_selesai' => 'required|integer|digits:4|min:1900|max:' . date('Y'),
            'tgl_yudisium' => 'required|date|before_or_equal:today',
        ]);

        // Validasi tambahan: tahun selesai harus >= tahun mulai
        if ($request->tahun_studi_selesai < $request->tahun_studi_mulai) {
            return back()->with('error', 'Tahun studi selesai tidak boleh lebih awal dari tahun studi mulai.')
                         ->withInput();
        }

        try {
            $alumni = Alumni::where('mahasiswa_nim', $nim)->firstOrFail();

            // Validasi nomor ijazah jika diubah, harus tetap unik
            if ($request->no_ijazah !== $alumni->no_ijazah) {
                $existingIjazah = Alumni::where('no_ijazah', $request->no_ijazah)->first();
                if ($existingIjazah) {
                    return back()->with('error', 'Nomor ijazah sudah terdaftar oleh alumni lain.')->withInput();
                }
            }

            $alumni->update([
                'no_ijazah' => $request->no_ijazah,
                'tahun_studi_mulai' => $request->tahun_studi_mulai,
                'tahun_studi_selesai' => $request->tahun_studi_selesai,
                'tgl_yudisium' => $request->tgl_yudisium,
            ]);

            Log::info('Data alumni berhasil diupdate', [
                'nim' => $nim,
                'no_ijazah' => $request->no_ijazah
            ]);

            return back()->with('success_alumni', 'Data alumni berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Error saat update data alumni', [
                'error' => $e->getMessage(),
                'nim' => $nim
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                         ->withInput();
        }
    }

    /**
     * Simpan data mahasiswa baru (jika NIM belum terdaftar)
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

            Log::info('Data mahasiswa baru berhasil disimpan', [
                'nim' => $mahasiswa->nim,
                'nama' => $mahasiswa->nama,
                'email' => $mahasiswa->email
            ]);

            return back()->with('success_mahasiswa', 'Data mahasiswa berhasil disimpan. Silakan lanjutkan mengisi form pengajuan.');

        } catch (\Exception $e) {
            Log::error('Error saat menyimpan data mahasiswa', [
                'error' => $e->getMessage(),
                'nim' => $request->nim
            ]);

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                         ->withInput();
        }
    }

    /**
     * Simpan pengajuan surat
     */
    public function store(Request $request)
    {
        $pelayanan = Pelayanan::findOrFail($request->pelayanan_id);

        // ✅ VALIDASI DASAR
        $rules = [
            'pelayanan_id' => 'required|exists:pelayanans,id',
            'nim' => 'required|string',
            'no_hp' => 'required|string|digits_between:10,15',
            'dokumen' => 'required|array',
            'dokumen.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        // ✅ VALIDASI BERDASARKAN JENIS SURAT
        switch ($pelayanan->nama) {
            case "Surat Keterangan Aktif Kuliah":
                $rules['nim'] = 'required|exists:mahasiswas,nim';
                // ✅ PASTIKAN DATA ORANG TUA SUDAH TERISI
                $orangTua = OrangTua::where('mahasiswa_nim', $request->nim)->first();
                if (!$orangTua) {
                    return back()->with('error', 'Data orang tua belum lengkap. Silakan isi data orang tua terlebih dahulu sebelum mengajukan surat.');
                }
                break;

            case "Surat Keterangan Alumni":
                $rules['nim'] = 'required|exists:mahasiswas,nim';
                // ✅ PASTIKAN DATA ALUMNI SUDAH TERISI
                $alumni = Alumni::where('mahasiswa_nim', $request->nim)->first();
                if (!$alumni) {
                    return back()->with('error', 'Data alumni belum lengkap. Silakan isi data alumni terlebih dahulu sebelum mengajukan surat.');
                }
                break;

            case "Surat Keterangan Mahasiswa Prestasi":
            case "Surat Keterangan Berkelakuan Baik":
            case "Surat Keterangan Tidak Sedang Bekerja":
                $rules['nim'] = 'required|exists:mahasiswas,nim';
                break;

            case "Surat Keterangan Tidak Sedang Menerima Beasiswa":
                $rules['nim'] = 'required|exists:mahasiswas,nim';
                // Double check beasiswa
                $keteranganBeasiswa = KeteranganBeasiswa::where('mahasiswa_nim', $request->nim)->first();
                if ($keteranganBeasiswa && $keteranganBeasiswa->status_beasiswa === "Menerima Beasiswa") {
                    return back()->with('error', 'Anda sedang menerima beasiswa, tidak dapat mengajukan surat ini.');
                }
                break;
        }

        // Validasi data
        $data = $request->validate($rules);

        try {
            // ✅ BUAT PENGAJUAN
            $pengajuan = Pengajuan::create([
                'nim' => $data['nim'],
                'pelayanan_id' => $data['pelayanan_id'],
                'no_hp' => $data['no_hp'],
                'status' => 'Pending',
            ]);

            // ✅ UPLOAD DOKUMEN PERSYARATAN
            foreach ($data['dokumen'] as $persyaratanId => $file) {
                if ($request->hasFile("dokumen.$persyaratanId")) {
                    $file = $request->file("dokumen.$persyaratanId");
                    $filename = $data['nim'] . '-' . $persyaratanId . '-' . time() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/dokumen', $filename);
                    $path = 'storage/dokumen/' . $filename;

                    DokumenPersyaratan::create([
                        'pengajuan_id' => $pengajuan->id,
                        'nim' => $data['nim'],
                        'pelayanan_id' => $data['pelayanan_id'],
                        'persyaratan_id' => $persyaratanId,
                        'dokumen' => $path,
                    ]);
                }
            }

            // ✅ AMBIL DATA UNTUK NOTIFIKASI
            $mahasiswa = Mahasiswa::where('nim', $data['nim'])->first();
            $pengajuNama = $mahasiswa ? $mahasiswa->nama : 'Pengaju Tidak Dikenal';
            $pelayananNama = $pelayanan->nama ?? 'Layanan';

            // ✅ KIRIM NOTIFIKASI KE ADMIN
            $this->fcmService->sendToAllAdmins(
                '📝 Pengajuan Baru!',
                "Pengajuan {$pelayananNama} dari {$pengajuNama}",
                [
                    'type' => 'new_pengajuan',
                    'pengajuan_id' => (string) $pengajuan->id,
                    'pelayanan_id' => (string) $pengajuan->pelayanan_id,
                    'pelayanan_nama' => $pelayananNama,
                    'pengaju_nama' => $pengajuNama,
                    'pengaju_nim' => $pengajuan->nim,
                ]
            );

            Log::info('Pengajuan berhasil dibuat', [
                'pengajuan_id' => $pengajuan->id,
                'nim' => $pengajuan->nim,
                'pelayanan' => $pelayananNama
            ]);

            return redirect()->back()->with('success', 'Berhasil mengajukan permohonan. Silakan tunggu proses verifikasi.');

        } catch (\Exception $e) {
            Log::error('Error saat membuat pengajuan', [
                'error' => $e->getMessage(),
                'nim' => $request->nim,
                'pelayanan_id' => $request->pelayanan_id
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
