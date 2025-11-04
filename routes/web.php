<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\TtdController;
use App\Http\Controllers\Backend\BeritaController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LandingPageController;
use App\Http\Controllers\Backend\ListPengajuanController;
use App\Http\Controllers\Backend\PersyaratanController;
use App\Http\Controllers\Backend\PelayananController;
use App\Http\Controllers\Backend\MahasiswaController;
use App\Http\Controllers\Frontend\BerandaController;
use App\Http\Controllers\Frontend\DetailBeritaController;
use App\Http\Controllers\Frontend\ListpelayananController as FrontendListpelayananController;
use App\Http\Controllers\Frontend\PengajuanController;
use App\Http\Controllers\Frontend\ListaparaturController;
use App\Http\Controllers\ListpelayananController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PermohonanController;
use App\Http\Controllers\Api\FcmController;
use App\Http\Controllers\Frontend\DetailAparaturController;
use App\Models\Pengajuan;
use App\Models\ttd;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route tanpa middleware (public)
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/detail-berita/{id}', [DetailBeritaController::class, 'index'])->name('detail-berita');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authLogin'])->name('auth.login');

Route::get('/detail-aparatur', [ListAparaturController::class, 'index'])->name('detail-aparatur');

Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing-page');
Route::post('/landing-page/store', [LandingPageController::class, 'store'])->name('landing-page.store');
Route::get('/sejarah', [LandingPageController::class, 'detailSejarah'])->name('sejarah');
Route::get('/visimisi', [LandingPageController::class, 'detailVisiMisi'])->name('visimisi');

Route::get('/list-aparatur', [ListaparaturController::class, 'index'])->name('frontend.aparatur.index');
Route::get('/list-pelayanan', [FrontendListpelayananController::class, 'index'])->name('list-pelayanan');
Route::get('/pengajuan/{id}', [PengajuanController::class, 'index'])->name('pengajuan');
Route::post('/pengajuan/cek/{id}', [PengajuanController::class, 'cek'])->name('pengajuan.cek');
Route::post('/pengajuan/store/{id}', [PengajuanController::class, 'store'])->name('pengajuan.store');
Route::get('/pengajuan/detail/{id}/{nik?}', [PengajuanController::class, 'detail'])->name('pengajuan.detail');

// ✅ PINDAHKAN 3 ROUTE INI KELUAR DARI MIDDLEWARE AUTH (untuk mobile app)
// Validasi auth sudah dilakukan di dalam controller
Route::post('/list-pengajuan/{id}/cetak-stream', [ListPengajuanController::class, 'handleCetakStream'])->name('list-pengajuan.cetak.stream');
Route::post('/list-pengajuan/{id}/cetak-download', [ListPengajuanController::class, 'handleCetakDownload'])->name('list-pengajuan.cetak.download');
Route::get('/list-pengajuan/stream/{persyaratan_id}/{pengajuan_id}', [ListPengajuanController::class, 'stream'])->name('list-pengajuan.stream');

// Route dengan middleware auth
Route::middleware(['auth'])->group(function () {
    Route::get('/surat', function () {
        // load view
        $pdf = Pdf::loadView('backend.surat.template-surat', [
            'judul' => 'Surat Keterangan',
            'tahun' => now()->format('-Y'),
            'tanggal' => now()->format('d-m-Y'),

        ]);


        // atau tampilkan di browser
        return $pdf->stream('surat.pdf');
    });

    Route::get('/logout', [AuthController::class, 'authLogout'])->name('auth.logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pengajuan-surat', [PermohonanController::class, 'index'])->name('permohonan.index');


    Route::get('/list-pengajuan', [ListPengajuanController::class, 'index'])->name('list-pengajuan');
    // Route::post('/list-pengajuan/cetak/{id}', [ListPengajuanController::class, 'cetak'])->name('list-pengajuan.cetak');
    Route::put('/list-pengajuan/verifikasi/{id}', [ListPengajuanController::class, 'verifikasi'])->name('list-pengajuan.verifikasi');
    // ✅ ROUTE INI SUDAH DIPINDAHKAN KE LUAR (lihat baris 43)
    // Route::get('/list-pengajuan/stream/{persyaratan_id}/{pengajuan_id}', [ListPengajuanController::class, 'stream'])->name('list-pengajuan.stream');

    Route::get('/list-pengajuan', [ListPengajuanController::class, 'index'])->name('list-pengajuan');
    Route::post('/list-pengajuan/cetak/{id}', [ListPengajuanController::class, 'cetak'])->name('list-pengajuan.cetak');
    Route::put('/list-pengajuan/verifikasi/{id}', [ListPengajuanController::class, 'verifikasi'])->name('list-pengajuan.verifikasi');
    // ✅ ROUTE INI SUDAH DIPINDAHKAN KE LUAR (lihat baris 43)
    // Route::get('/list-pengajuan/stream/{persyaratan_id}/{pengajuan_id}', [ListPengajuanController::class, 'stream'])->name('list-pengajuan.stream');

    Route::get('/persyaratan', [PersyaratanController::class, 'index'])->name('persyaratan');
    Route::get('/persyaratan/edit/{id}', [PersyaratanController::class, 'edit'])->name('persyaratan.edit');
    Route::post('/persyaratan/store', [PersyaratanController::class, 'store'])->name('persyaratan.store');
    Route::put('/persyaratan/update/{id}', [PersyaratanController::class, 'update'])->name('persyaratan.update');
    Route::get('/persyaratan/delete/{id}', [PersyaratanController::class, 'delete'])->name('persyaratan.delete');


    Route::get('/Mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa');
    Route::get('/Mahasiswa/edit/{id}', [MahasiswaController::class, 'edit'])->name('mahasiswa.edit');
    Route::post('/Mahasiswa/store', [MahasiswaController::class, 'store'])->name('mahasiswa.store');
    Route::put('/Mahasiswa/update/{id}', [MahasiswaController::class, 'update'])->name('mahasiswa.update');
    Route::get('/Mahasiswa/delete/{id}', [MahasiswaController::class, 'delete'])->name('mahasiswa.delete');

    Route::get('/pelayanan', [PelayananController::class, 'index'])->name('pelayanan');
    Route::get('/pelayanan/edit/{id}', [PelayananController::class, 'edit'])->name('pelayanan.edit');
    Route::post('/pelayanan/store', [PelayananController::class, 'store'])->name('pelayanan.store');
    Route::put('/pelayanan/update/{id}', [PelayananController::class, 'update'])->name('pelayanan.update');
    Route::get('/pelayanan/delete/{id}', [PelayananController::class, 'delete'])->name('pelayanan.delete');

    Route::get('/berita', [BeritaController::class, 'index'])->name('berita');
    Route::get('/berita/edit/{id}', [BeritaController::class, 'edit'])->name('berita.edit');
    Route::post('/berita/store', [BeritaController::class, 'store'])->name('berita.store');
    Route::put('/berita/update/{id}', [BeritaController::class, 'update'])->name('berita.update');
    Route::get('/berita/delete/{id}', [BeritaController::class, 'delete'])->name('berita.delete');




    Route::get('/aparatur', [TtdController::class, 'index'])->name('aparatur');
    Route::get('/aparatur/edit/{id}', [TtdController::class, 'edit'])->name('ttd.edit');
    Route::post('/aparatur/store', [ttdController::class, 'store'])->name('ttd.store');
    Route::put('/aparatur/update/{id}', [TtdController::class, 'update'])->name('ttd.update');
    Route::get('/aparatur/delete/{id}', [TtdController::class, 'delete'])->name('ttd.delete');


    // Route ini khusus untuk menerima laporan FCM token dari aplikasi Flutter
    // Route::post('/api/save-fcm-token', [FcmController::class, 'saveToken'])->name('api.save_token');

    Route::post('/fcm/save-token', [FcmController::class, 'saveToken']);

    // // Route untuk STREAM PDF (lihat di browser/mobile)
    // Route::get('/list-pengajuan/stream/{persyaratan_id}/{pengajuan_id}', [ListPengajuanController::class, 'stream'])
    //     ->name('list-pengajuan.stream');

    // // Route untuk CETAK/DOWNLOAD PDF
    // Route::post('/list-pengajuan/cetak/{id}', [ListPengajuanController::class, 'handleCetak'])
    //     ->name('list-pengajuan.cetak');

    // // Route untuk DOWNLOAD (khusus mobile)
    // Route::post('/list-pengajuan/cetak/download/{id}', [ListPengajuanController::class, 'handleCetak'])
    //     ->name('list-pengajuan.cetak.download');

    // ✅ ROUTE INI SUDAH DIPINDAHKAN KE LUAR (lihat baris 41-43)
    // Route::post('/list-pengajuan/{id}/cetak-stream', [ListPengajuanController::class, 'handleCetakStream'])->name('list-pengajuan.cetak.stream');
    // Route::post('/list-pengajuan/{id}/cetak-download', [ListPengajuanController::class, 'handleCetakDownload'])->name('list-pengajuan.cetak.download');

    Route::delete('/list-pengajuan/{id}', [ListPengajuanController::class, 'destroy'])->name('list-pengajuan.destroy');
});
