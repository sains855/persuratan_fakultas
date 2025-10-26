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
use Illuminate\Support\Facades\Log;

class PengajuanController extends Controller
{
    protected $fcmService; // ✅ TAMBAHKAN INI

    // ✅ TAMBAHKAN CONSTRUCTOR
    public function __construct(FcmService $fcmService)
    {
        $this->fcmService = $fcmService;
    }

    public function index($id)
    {
        $pelayanan = Pelayanan::find($id);
        $title = "Form Cek nim";
        // Kalau layanan = Tempat Tinggal Sementara → langsung ke detail
        if ($pelayanan && $pelayanan->nama === "Surat Keterangan Tempat Tinggal Sementara") {
            return redirect()->route('pengajuan.detail', [
                'id' => $id,
                'nim' => null // nanti di form detail diisi manual
            ]);
        }

        // Kalau layanan lain → tetap ke form cek nim
        return view('pengajuan.detail', compact('title', 'id'));
    }

    public function cek(Request $request, $id)
    {
        $pelayanan = Pelayanan::findOrFail($id);
        $KeteranganBeasiswa = KeteranganBeasiswa::where('Mahasiswa_nim', $request->nim)->first();
        $nim = Mahasiswa::where('nim', $request->nim)->value('nim');
        if (!$nim) {
            return back()->with('error', 'nim tidak ditemukan, Silahkan daftar ke kelurahan tipulu');
        }

        if ($pelayanan->nama === "Surat Keterangan Belum Menerima Beasiswa") {
            if ($KeteranganBeasiswa->status !== "Menerima Beasiswa") {
            return back()->with('error', 'Anda sudah menerima Beasiswa, tidak bisa mengajukan surat ini.');
        }
    }

        return redirect()->route('pengajuan.detail', ['id' => $id, 'nim' => $nim]);
    }

    public function detail($id, $nim = null)
    {
        $pelayanan = Pelayanan::findOrFail($id);

        if ($nim) {
            $Mahasiswa = Mahasiswa::where('nim', $nim)->first();

            if (!$Mahasiswa) {
                return redirect()->back()->with('error', 'Data penduduk tidak ditemukan.');
            }
        } else {
            $Mahasiswa = null;
        }

        return view('frontend.pengajuan.detail', compact('pelayanan', 'Mahasiswa'));
    }


    public function store(Request $request)
    {
        $pelayanan = Pelayanan::find($request->pelayanan_id);

        $rules = [
            'pelayanan_id' => 'required',
            'no_hp' => 'required|string|digits_between:10,15',
            'keperluan' => 'nullable|string',
            'dokumen' => 'required|array',
            'dokumen.*' => 'file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];

        // Jika pelayanan = Surat Keterangan Tempat Tinggal Sementara
        if ($pelayanan && $pelayanan->nama === "Surat Keterangan Tempat Tinggal Sementara") {
            $rules['nim'] = 'required|digits:16';
            $rules = array_merge($rules, [
                'nim'              => 'required|string',
                'nama'             => 'required|string',
                'tgl_lahir'        => 'required|date',
                'tempat_lahir'     => 'required|string',
                ''
            ]);
        } else {
            // Layanan biasa -> nim harus ada di tabel Mahasiswa
            $rules['nim'] = 'required|exists:Mahasiswas,nim';
            $Mahasiswa = Mahasiswa::where('nim', $rules['nim'])->first();
        }

        $data = $request->validate($rules);

        try {
            $pengajuan = Pengajuan::create([
                'nim' => $data['nim'],
                'pelayanan_id' => $data['pelayanan_id'],
                'no_hp' => $data['no_hp'],
                'keperluan' => $data['keperluan'] ?? null,
            ]);

            // ✅ SIMPAN DATA KE TABEL KEMATIANS JIKA PELAYANAN SURAT KEMATIAN
            if ($pelayanan && $pelayanan->nama === "Surat Keterangan Kematian") {
                $request->validate([
                    'nama'           => 'required|string',
                    'jenis_kelamin'  => 'required|string',
                    'umur'           => 'required|integer',
                    'alamat'         => 'required|string',
                    'hari'           => 'required|string',
                    'tanggal_meninggal'        => 'required|date',
                    'tempat_meninggal' => 'required|string',
                    'penyebab'       => 'required|string',
                ]);
            }

            // ✅ SIMPAN DATA KE TABEL PINDAH_PENDUDUK JIKA PELAYANAN SURAT PINDAH
            elseif ($pelayanan && $pelayanan->nama === "Surat Keterangan Pindah Penduduk") {
                $request->validate([
                    'desa_kelurahan' => 'required|string',
                    'kecamatan'      => 'required|string',
                    'kab_kota'      => 'required|string',
                    'provinsi'       => 'required|string',
                    'tanggal_pindah' => 'required|date',
                    'alasan_pindah'  => 'nullable|string',
                    'pengikut'       => 'nullable|integer', // kalau jumlah orang
                ]);

            } elseif ($pelayanan && $pelayanan->nama === "Surat Keterangan Domisili Usaha dan Yayasan") {
                $request->validate([
                    'nama_usaha' => 'required|string',
                    'alamat_usaha' => 'required|string',
                    'jenis_kegiatan_usaha' => 'required|string',
                    'penanggung_jawab' => 'required|string',
                ]);

            } elseif ($pelayanan && $pelayanan->nama === "Surat Keterangan Memiliki Usaha (SKU)") {
                $request->validate([
                    'nama_usaha' => 'required|string',
                    'tahun_berdiri' => 'required|date_format:Y',
                ]);

            } elseif ($pelayanan && $pelayanan->nama === "Surat Izin Keramaian") {
                $request->validate([
                    'nama_acara'      => 'required|string',
                    'penyelenggara'   => 'nullable|string',
                    'deskripsi_acara' => 'nullable|string',
                    'tanggal'         => 'required|date',
                    'tempat'          => 'required|string',
                    'pukul'           => 'nullable|string',
                ]);
            } elseif ($pelayanan && $pelayanan->nama === "Surat Keterangan Tempat Tinggal Sementara") {
                $request->validate([
                    'nama'             => 'required|string',
                    'nim'              => 'required|string',
                    'alamat_sementara' => 'required|string',
                    'jenis_kelamin'    => 'required|string',
                    'RT'               => 'required|integer',
                    'RW'               => 'required|integer',
                    'tgl_lahir'        => 'required|date',
                    'tempat_lahir'     => 'required|string',
                    'agama'            => 'required|string',
                    'status'           => 'required|string',
                    'pekerjaan'        => 'required|string',
                ]);
            }



            // Upload dokumen persyaratan
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

            // ✅ KIRIM NOTIFIKASI KE ADMIN
            $pengajuNama = '';
            if ($pelayanan && $pelayanan->nama === "Surat Keterangan Tempat Tinggal Sementara") {
                // Untuk layanan ini, nama diambil langsung dari input form yang sudah divalidasi
                $pengajuNama = $data['nama'];
            } else {
                // Untuk layanan lain, ambil dari relasi 'Mahasiswa' yang ada di model Pengajuan.
                // Ini lebih andal karena model $pengajuan sudah pasti ada.
                $pengajuNama = optional($pengajuan->Mahasiswa)->nama;
            }

            // Sediakan nilai fallback (pengganti) jika nama tetap kosong karena alasan apapun
            $namaUntukNotif = $pengajuNama ?? 'Pengaju Tidak Dikenal';
            $pelayananNama = optional($pelayanan)->nama ?? 'Layanan';

            // ✅ KIRIM NOTIFIKASI KE ADMIN DENGAN DATA YANG SUDAH AMAN
            $this->fcmService->sendToAllAdmins(
                '📝 Pengajuan Baru!',
                "Pengajuan {$pelayananNama} dari {$namaUntukNotif}",
                [
                    'type' => 'new_pengajuan',
                    'pengajuan_id' => (string) $pengajuan->id,
                    'pelayanan_id' => (string) $pengajuan->pelayanan_id,
                    'pelayanan_nama' => $pelayananNama,
                    'pengaju_nama' => $namaUntukNotif,
                    'pengaju_nim' => $pengajuan->nim,
                ]
            );

            Log::info('Pengajuan berhasil dibuat', [
                'pengajuan_id' => $pengajuan->id,
                'nim' => $pengajuan->nim,
                'pelayanan' => $pelayananNama
            ]);

            return redirect()->back()->with('success', 'Berhasil mengajukan permohonan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
