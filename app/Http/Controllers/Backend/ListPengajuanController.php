<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Ttd;
use App\Models\DokumenPersyaratan;
use App\Models\Pengajuan;
use App\Models\Persyaratan;
use App\Models\Verifikasi;
use App\Models\Mahasiswa;
use App\Models\OrangTua;
use App\Models\Alumni;
use App\Models\KeteranganBeasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

Carbon::setLocale('id');

class ListPengajuanController extends Controller
{
    public function index()
    {
        $title = "List Pengajuan";

        // ✅ PERBAIKAN: Sesuaikan dengan relasi yang ada di PengajuanController
        $pengajuan = Pengajuan::with([
            'pelayanan',
            'mahasiswa',
            'mahasiswa.orangTua',
            'mahasiswa.alumni',
            'dokumenPersyaratan.persyaratan'
        ])->orderByDesc('id')->get();

        $ttds = Ttd::get(['id', 'nama']);

        return view('backend.list-pengajuan.index', compact('title', 'pengajuan', 'ttds'));
    }

    public function verifikasi(Request $request, $id)
    {
        try {
            $status = $request->input('status', 'Ditolak');
            $alasan = $request->input('alasan');

            // Cari data verifikasi lama (dari ttd yang sama)
            $ttdId = $user->ttd_id ?? 4;
            $verifikasi = Verifikasi::where('pengajuan_id', $id)
                ->where('aparatur_id', Auth::user()->ttd_id ?? 4)
                ->first();

            if ($verifikasi) {
                // Jika sudah pernah diverifikasi → update ulang
                $verifikasi->update([
                    'status' => $status . ' oleh ' . Auth::user()->username,
                    'alasan' => $alasan,
                ]);
            } else {
                // Jika belum pernah diverifikasi → buat baru
                Verifikasi::create([
                    'pengajuan_id' => $id,
                    'status' => $status . ' oleh ' . Auth::user()->username,
                    'alasan' => $alasan,
                    'aparatur_id' => $ttdId,
                ]);
            }

            return back()->with('success', 'Berhasil ' . strtolower($status) . ' data');
        } catch (\Throwable $th) {
            Log::error('Gagal verifikasi data: ' . $th->getMessage());
            return back()->with('error', 'SYSTEM ERROR: ' . $th->getMessage() . ' (Line: ' . $th->getLine() . ')');
        }
    }

    private function isMobileAppRequest(Request $request)
    {
        return $request->hasHeader('X-Requested-With') &&
            $request->header('X-Requested-With') === 'XMLHttpRequest' &&
            (str_contains($request->userAgent() ?? '', 'MEAMBO-Mobile-App') ||
                str_contains($request->header('User-Agent') ?? '', 'MEAMBO-Mobile-App'));
    }

    public function handleCetakStream(Request $request, $id)
    {
        return $this->generatePdf($request, $id, 'stream');
    }

    public function handleCetakDownload(Request $request, $id)
    {
        return $this->generatePdf($request, $id, 'download');
    }

    /**
     * Method private terpusat untuk men-generate PDF.
     * ✅ SUDAH DISESUAIKAN DENGAN TEMPLATE BARU (FMIPA UHO)
     */
    private function generatePdf(Request $request, $id, $action)
    {
        try {
            Log::info("Memulai proses generate PDF", [
                'id' => $id,
                'action' => $action
            ]);

            // Validasi input
            $request->validate([
                'tgl_cetak' => 'required|date',
                // Pastikan nama input di view/js adalah 'ttd_id', bukan 'aparatur_id'
                'ttd_id' => 'required|exists:ttds,id',
            ]);

            // Ambil data pengajuan full relasi
            $pengajuan = Pengajuan::with([
                'pelayanan',
                'mahasiswa',
                'mahasiswa.orangTua',
                'mahasiswa.alumni',
            ])->findOrFail($id);

            $ttd = Ttd::findOrFail($request->ttd_id);
            $mahasiswa = $pengajuan->mahasiswa;
            $pelayananNama = $pengajuan->pelayanan->nama;

            // 1. Data Dasar (Wajib Ada)
            $dataForView = [
                'judul' => $pelayananNama,
                'tahun' => Carbon::parse($request->tgl_cetak)->format('Y'),
                'tanggal' => Carbon::parse($request->tgl_cetak)->isoFormat('D MMMM Y'),
                'jabatan' => ucwords(strtolower($ttd->jabatan)),
                'ttd' => ucwords(strtolower($ttd->nama)), // Nama Penanda Tangan
                'ttd_nip' => $ttd->nip,
                'ttd_pangkat' => $ttd->pangkat ?? null, // Tambahkan kolom pangkat di tabel ttds jika ada

                // Data Kop Surat (Sesuai gambar FMIPA)
                'telepon' => '(0401) 3191929',
            ];

            // 2. Data Mahasiswa
            if ($mahasiswa) {
                $dataForView['nama'] = ucwords(strtolower($mahasiswa->nama));
                $dataForView['nim'] = $mahasiswa->nim;
                $dataForView['tempat_lahir'] = ucwords(strtolower($mahasiswa->tempat_lahir));
                $dataForView['tanggal_lahir'] = Carbon::parse($mahasiswa->tgl_lahir)->isoFormat('D MMMM Y');
                $dataForView['jenis_kelamin'] = ucwords(strtolower($mahasiswa->jenis_kelamin));
                $dataForView['agama'] = ucwords(strtolower($mahasiswa->agama));
                $dataForView['prodi'] = ucwords(strtolower($mahasiswa->Prodi_jurusan ?? '-'));
                $dataForView['semester'] = $mahasiswa->semester;
                $dataForView['alamat'] = $mahasiswa->alamat;

                // Tambahan Data Baru yang dibutuhkan Template
                $dataForView['no_hp'] = $pengajuan->no_hp ?? $mahasiswa->No_Hp ?? '-';
                $dataForView['email'] = $mahasiswa->email ?? '-';
                $dataForView['ipk'] = $mahasiswa->ipk ?? '-'; // Pastikan ada kolom ipk di tabel mahasiswas

                // Opsional: IPK Terbilang (Bisa dibuat helper function)
                $dataForView['ipk_terbilang'] = $this->terbilangKoma($mahasiswa->ipk ?? 0);
            }

            // 3. Data Khusus: Surat Keterangan Aktif Kuliah
            // Template baru butuh NIP Ayah, Pangkat, Instansi
            if ($pelayananNama === "Surat Keterangan Aktif Kuliah" && $mahasiswa->orangTua) {
                $ortu = $mahasiswa->orangTua;
                $dataForView['nama_orangtua'] = ucwords(strtolower($ortu->nama_ayah));
                $dataForView['pekerjaan_orangtua'] = ucwords(strtolower($ortu->pekerjaan_ayah));
                $dataForView['nip_orangtua'] = $ortu->nip_ayah ?? '-';
                $dataForView['pangkat_orangtua'] = $ortu->pangkat_ayah ?? '-';
                $dataForView['instansi_orangtua'] = $ortu->instansi_ayah ?? '-';
                $dataForView['no_orangtua'] = $ortu->no_hp_ayah ?? '-';
                $dataForView['alamat_orangtua'] = $ortu->alamat_ayah ?? $mahasiswa->alamat;


                // Semester Romawi & Tahun Akademik (Manual atau dari Database)
                $dataForView['semester_romawi'] = $this->toRoman($mahasiswa->semester);
                $tahunIni = date('Y');
                $dataForView['tahun_akademik'] = $tahunIni . '/' . ($tahunIni + 1);
            }

            // 4. Data Khusus: Surat Keterangan Alumni
            // Mapping nama variabel agar sesuai dengan Template Blade
            if ($pelayananNama === "Surat Keterangan Alumni" && $mahasiswa->alumni) {
                $alumni = $mahasiswa->alumni;
                $dataForView['no_ijazah'] = $alumni->no_ijazah;
                $dataForView['tahun_masuk'] = $alumni->tahun_studi_mulai; // Ubah key jadi tahun_masuk
                $dataForView['tahun_lulus'] = $alumni->tahun_studi_selesai; // Ubah key jadi tahun_lulus
                $dataForView['tgl_yudisium'] = Carbon::parse($alumni->tgl_yudisium)->isoFormat('D MMMM Y');
            }

            // 5. Data Khusus: Mahasiswa Prestasi
            if ($pelayananNama === "Surat Keterangan Mahasiswa Prestasi") {
                // Ambil tahun masuk dari NIM (misal F1G120... berarti 2020) atau dari database
                $angkatan = '20' . substr($mahasiswa->nim, 4, 2);
                $dataForView['tahun_masuk'] = $angkatan;
            }

            // Replace Placeholder Keterangan
            if (isset($pengajuan->pelayanan->keterangan_surat)) {
                $keterangan = $pengajuan->pelayanan->keterangan_surat;
                $keterangan = str_replace(
                    ['{{ $keperluan }}'],
                    ['<b>' . ucwords(strtolower($pengajuan->keperluan ?? '....')) . '</b>'],
                    $keterangan
                );
                $dataForView['keterangan_surat'] = $keterangan;
            }

            // Load View PDF
            $pdf = PDF::loadView('backend.surat.template-surat', $dataForView);

            // Set Paper Size F4 (Sesuai CSS template)
            // 21.59cm x 33.02cm
            $pdf->setPaper([0, 0, 612.00, 936.00], 'portrait');

            if ($action === 'download') {
                return $pdf->download('surat_' . $pengajuan->id . '.pdf');
            } else {
                return $pdf->stream('surat_' . $pengajuan->id . '.pdf');
            }
        } catch (\Exception $e) {
            Log::error('Gagal generate PDF: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    // Helper: Mengubah Angka ke Romawi (Untuk Semester)
    private function toRoman($number)
    {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }

    // Helper: Terbilang IPK (Contoh: 3.50 -> Tiga Koma Lima Nol)
    private function terbilangKoma($nilai)
    {
        $nilai = number_format((float)$nilai, 2, '.', ''); // Pastikan 2 desimal
        $angka = [
            '0' => 'Nol',
            '1' => 'Satu',
            '2' => 'Dua',
            '3' => 'Tiga',
            '4' => 'Empat',
            '5' => 'Lima',
            '6' => 'Enam',
            '7' => 'Tujuh',
            '8' => 'Delapan',
            '9' => 'Sembilan'
        ];

        $text = "";
        $chars = str_split($nilai);
        foreach ($chars as $char) {
            if ($char == '.') {
                $text .= " Koma";
            } else {
                $text .= " " . $angka[$char];
            }
        }
        return trim($text);
    }

    public function stream(Request $request, $persyaratan_id, $pengajuan_id)
    {
        try {
            if ($this->isMobileAppRequest($request)) {
                Log::info('Akses dari mobile app diizinkan untuk stream dokumen', [
                    'persyaratan_id' => $persyaratan_id,
                    'pengajuan_id' => $pengajuan_id,
                    'ip' => $request->ip(),
                ]);
            }

            $path = DokumenPersyaratan::where('persyaratan_id', $persyaratan_id)
                ->where('pengajuan_id', $pengajuan_id)
                ->value('dokumen');

            if (!$path) {
                if ($this->isMobileAppRequest($request)) {
                    return response()->json([
                        'error' => 'Not Found',
                        'message' => 'Dokumen tidak ditemukan di database.'
                    ], 404);
                }
                abort(404, 'Dokumen tidak ditemukan.');
            }

            $persyaratan = Persyaratan::find($persyaratan_id);
            $fullPath = public_path($path);

            if (!file_exists($fullPath)) {
                if ($this->isMobileAppRequest($request)) {
                    return response()->json([
                        'error' => 'Not Found',
                        'message' => 'File tidak ditemukan di server.'
                    ], 404);
                }
                abort(404, 'File tidak ditemukan.');
            }

            $filename = optional($persyaratan)->nama . '.pdf';

            return response()->file($fullPath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
                'Cache-Control' => 'no-cache, must-revalidate',
                'X-Content-Type-Options' => 'nosniff',
            ]);
        } catch (\Exception $e) {
            Log::error('Error stream dokumen', [
                'persyaratan_id' => $persyaratan_id,
                'pengajuan_id' => $pengajuan_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($this->isMobileAppRequest($request)) {
                return response()->json([
                    'error' => 'Server Error',
                    'message' => 'Gagal memuat dokumen: ' . $e->getMessage()
                ], 500);
            }

            abort(500, 'Gagal memuat dokumen.');
        }
    }

    /**
     * Method untuk menghapus data pengajuan
     */
    public function destroy($id)
    {
        try {
            Log::info("Memulai proses hapus pengajuan", ['id' => $id]);

            // Cari data pengajuan dengan relasi dokumen
            $pengajuan = Pengajuan::with('dokumenPersyaratan')->findOrFail($id);

            // Hapus file dokumen persyaratan jika ada
            if ($pengajuan->dokumenPersyaratan->count() > 0) {
                foreach ($pengajuan->dokumenPersyaratan as $dokumen) {
                    $filePath = public_path($dokumen->dokumen);

                    // Hapus file fisik jika ada
                    if (file_exists($filePath)) {
                        unlink($filePath);
                        Log::info("File dokumen dihapus", ['path' => $filePath]);
                    }
                }
            }

            // Hapus data verifikasi terkait
            Verifikasi::where('pengajuan_id', $id)->delete();

            // Hapus data dokumen persyaratan dari database
            DokumenPersyaratan::where('pengajuan_id', $id)->delete();

            // Hapus data pengajuan
            $pengajuan->delete();

            Log::info("Pengajuan berhasil dihapus", ['id' => $id]);

            return redirect()->back()->with('success', 'Data pengajuan berhasil dihapus');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus pengajuan', [
                'id' => $id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
