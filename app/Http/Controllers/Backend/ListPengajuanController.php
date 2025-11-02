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
            $verifikasi = Verifikasi::where('pengajuan_id', $id)
                ->where('ttd_id', Auth::user()->ttd_id ?? 4)
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
                    'ttd_id' => Auth::user()->ttd_id ?? 4,
                ]);
            }

            return back()->with('success', 'Berhasil ' . strtolower($status) . ' data');
        } catch (\Throwable $th) {
            Log::error('Gagal verifikasi data: ' . $th->getMessage());
            return back()->with('error', 'Gagal verifikasi data');
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
     * ✅ DISESUAIKAN dengan jenis surat di PengajuanController
     */
    private function generatePdf(Request $request, $id, $action)
    {
        try {
            Log::info("Memulai proses generate PDF", [
                'id' => $id,
                'action' => $action,
                'request_data' => $request->all(),
                'is_mobile' => $this->isMobileAppRequest($request)
            ]);

            // Validasi input dari form
            $request->validate([
                'tgl_cetak' => 'required|date',
                'ttd_id' => 'required|exists:ttds,id',
            ]);

            // ✅ PERBAIKAN: Ambil data pengajuan dengan relasi mahasiswa
            $pengajuan = Pengajuan::with([
                'pelayanan',
                'mahasiswa',
                'mahasiswa.orangTua',
                'mahasiswa.alumni',
            ])->findOrFail($id);

            $ttd = Ttd::findOrFail($request->ttd_id);
            $mahasiswa = $pengajuan->mahasiswa;

            // ✅ PERBAIKAN: Siapkan data berdasarkan jenis surat
            $pelayananNama = $pengajuan->pelayanan->nama;

            $dataForView = [
                'judul' => $pelayananNama,
                'tahun' => Carbon::parse($request->tgl_cetak)->format('Y'),
                'tanggal' => Carbon::parse($request->tgl_cetak)->isoFormat('D MMMM Y'),
                'jabatan' => ucwords(strtolower($ttd->jabatan)),
                'ttd' => ucwords(strtolower($ttd->nama)),
                'ttd_nip' => $ttd->nip,
            ];

            // ✅ TAMBAHKAN DATA SESUAI JENIS SURAT
            if ($mahasiswa) {
                $dataForView['nim'] = $mahasiswa->nim;
                $dataForView['nama'] = ucwords(strtolower($mahasiswa->nama));
                $dataForView['tempat_lahir'] = ucwords(strtolower($mahasiswa->tempat_lahir));
                $dataForView['tanggal_lahir'] = Carbon::parse($mahasiswa->tgl_lahir)->isoFormat('D MMMM Y');
                $dataForView['jenis_kelamin'] = ucwords(strtolower($mahasiswa->jenis_kelamin));
                $dataForView['agama'] = ucwords(strtolower($mahasiswa->agama));
                $dataForView['prodi'] = ucwords(strtolower($mahasiswa->prodi));
                $dataForView['semester'] = $mahasiswa->semester;
                $dataForView['alamat'] = $mahasiswa->alamat;
            }

            // Data khusus untuk Surat Keterangan Aktif Kuliah
            if ($pelayananNama === "Surat Keterangan Aktif Kuliah" && $mahasiswa->orangTua) {
                $dataForView['nama_ayah'] = ucwords(strtolower($mahasiswa->orangTua->nama_ayah));
                $dataForView['pekerjaan_ayah'] = ucwords(strtolower($mahasiswa->orangTua->pekerjaan_ayah));
                $dataForView['nama_ibu'] = ucwords(strtolower($mahasiswa->orangTua->nama_ibu));
                $dataForView['pekerjaan_ibu'] = ucwords(strtolower($mahasiswa->orangTua->pekerjaan_ibu));
            }

            // Data khusus untuk Surat Keterangan Alumni
            if ($pelayananNama === "Surat Keterangan Alumni" && $mahasiswa->alumni) {
                $dataForView['no_ijazah'] = $mahasiswa->alumni->no_ijazah;
                $dataForView['tahun_studi_mulai'] = $mahasiswa->alumni->tahun_studi_mulai;
                $dataForView['tahun_studi_selesai'] = $mahasiswa->alumni->tahun_studi_selesai;
                $dataForView['tgl_yudisium'] = Carbon::parse($mahasiswa->alumni->tgl_yudisium)->isoFormat('D MMMM Y');
            }

            // ✅ REPLACE placeholder di keterangan surat
            if (isset($pengajuan->pelayanan->keterangan_surat)) {
                $keterangan = $pengajuan->pelayanan->keterangan_surat;

                // Replace placeholder umum
                $keterangan = str_replace(
                    ['{{ $keperluan }}'],
                    ['<b>' . ucwords(strtolower($pengajuan->keperluan ?? '....')) . '</b>'],
                    $keterangan
                );

                $dataForView['keterangan_surat'] = $keterangan;
            }

            // Generate PDF dengan satu panggilan
            $pdf = PDF::loadView('backend.surat.template-surat', $dataForView);

            Log::info("PDF berhasil di-generate untuk action: {$action}");

            // Kembalikan respons berdasarkan action yang diminta
            if ($action === 'download') {
                return $pdf->download('surat_' . $pengajuan->id . '.pdf');
            } else { // 'stream'
                return $pdf->stream('surat_' . $pengajuan->id . '.pdf');
            }
        } catch (\Exception $e) {
            Log::error('Gagal saat generate PDF', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($this->isMobileAppRequest($request)) {
                return response()->json([
                    'error' => 'Gagal generate PDF',
                    'message' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
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
