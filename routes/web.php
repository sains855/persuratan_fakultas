<?php

use App\Models\ttd;
use App\Models\Pengajuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\FcmController;
use App\Http\Controllers\Backend\TtdController;
use App\Http\Controllers\ListpelayananController;
use App\Http\Controllers\Backend\BeritaController;
use App\Http\Controllers\Frontend\BerandaController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\MahasiswaController;
use App\Http\Controllers\Backend\PelayananController;
use App\Http\Controllers\Backend\PermohonanController;
use App\Http\Controllers\Frontend\PengajuanController;
use App\Http\Controllers\Frontend\KeteranganBeasiswaController;
use App\Http\Controllers\Backend\LandingPageController;
use App\Http\Controllers\Backend\PersyaratanController;
use App\Http\Controllers\Backend\ListPengajuanController;
use App\Http\Controllers\Frontend\DetailBeritaController;
use App\Http\Controllers\Frontend\ListaparaturController;
use App\Http\Controllers\Frontend\DetailAparaturController;
use App\Http\Controllers\Frontend\ListpelayananController as FrontendListpelayananController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route tanpa middleware (public)
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authLogin'])->name('auth.login');




// Halaman form cek NIM berdasarkan jenis layanan
Route::get('/pengajuan/{id}', [PengajuanController::class, 'index'])
    ->name('pengajuan');

// Proses cek NIM + validasi (beasiswa & lainnya)
Route::post('/pengajuan/{id}/cek', [PengajuanController::class, 'cek'])
    ->name('pengajuan.cek');

// Halaman detail form pengajuan
Route::get('/pengajuan/{id}/detail/{nim?}', [PengajuanController::class, 'detail'])
    ->name('pengajuan.detail');

// Simpan data orang tua (khusus SK Aktif Kuliah)
Route::post('/pengajuan/store-orangtua', [PengajuanController::class, 'storeOrangTua'])
    ->name('pengajuan.storeOrangTua');
// ... rute yang sudah ada

// =========================================================================
// MEKANISME EDIT DATA ORANG TUA DAN ALUMNI
// =========================================================================

// Halaman form edit data orang tua
Route::get('/pengajuan/{id}/edit-orangtua/{nim}', [PengajuanController::class, 'editOrangTua'])
    ->name('pengajuan.editOrangTua');

// Proses update data orang tua
Route::put('/pengajuan/{id}/update-orangtua/{nim}', [PengajuanController::class, 'updateOrangTua'])
    ->name('pengajuan.updateOrangTua');

// Halaman form edit data alumni
Route::get('/pengajuan/{id}/edit-alumni/{nim}', [PengajuanController::class, 'editAlumni'])
    ->name('pengajuan.editAlumni');

// Proses update data alumni
Route::put('/pengajuan/{id}/update-alumni/{nim}', [PengajuanController::class, 'updateAlumni'])
    ->name('pengajuan.updateAlumni');

// ... rute yang sudah ada
// Simpan data alumni (khusus SK Alumni)
Route::post('/pengajuan/store-alumni', [PengajuanController::class, 'storeAlumni'])
    ->name('pengajuan.storeAlumni');

// Simpan data mahasiswa baru (jika NIM belum ada)
Route::post('/pengajuan/store-mahasiswa', [PengajuanController::class, 'storeMahasiswa'])
    ->name('pengajuan.storeMahasiswa');

// Simpan pengajuan surat
Route::post('/pengajuan/store', [PengajuanController::class, 'store'])
    ->name('pengajuan.store');

Route::get('/', [FrontendListpelayananController::class, 'index'])->name('beranda');
// Route::get('/pengajuan/{id}', [PengajuanController::class, 'index'])->name('pengajuan');
// Route::post('/pengajuan/cek/{id}', [PengajuanController::class, 'cek'])->name('pengajuan.cek');
// Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
// Route::get('/pengajuan/detail/{id}/{nim?}', [PengajuanController::class, 'detail'])->name('pengajuan.detail');
// Route::post('/pengajuandetail/{id}/{nim?}', [PengajuanController::class, 'storeOrangTua'])->name('pengajuan.store');
// Route::post('/pengajuandetail/{id}/{nim?}', [PengajuanController::class, 'storeAlumni'])->name('pengajuan.store');
// Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');


// ✅ PINDAHKAN 3 ROUTE INI KELUAR DARI MIDDLEWARE AUTH (untuk mobile app)
// Validasi auth sudah dilakukan di dalam controller
Route::post('/list-pengajuan/{id}/cetak-stream', [ListPengajuanController::class, 'handleCetakStream'])->name('list-pengajuan.cetak.stream');
Route::post('/list-pengajuan/{id}/cetak-download', [ListPengajuanController::class, 'handleCetakDownload'])->name('list-pengajuan.cetak.download');
Route::get('/list-pengajuan/stream/{persyaratan_id}/{pengajuan_id}', [ListPengajuanController::class, 'stream'])->name('list-pengajuan.stream');

Route::get('/keterangan-beasiswa', [KeteranganBeasiswaController::class, 'create'])->name('frontend.keteranganbeasiswa.create');
Route::post('/keterangan-beasiswa/cek-nim', [KeteranganBeasiswaController::class, 'cekNim'])->name('frontend.keteranganbeasiswa.cekNim');
Route::get('/keterangan-beasiswa/detail/{nim}', [KeteranganBeasiswaController::class, 'detail'])->name('frontend.keteranganbeasiswa.detail');
Route::post('/keterangan-beasiswa/store-mahasiswa', [KeteranganBeasiswaController::class, 'storeMahasiswa'])->name('frontend.keteranganbeasiswa.storeMahasiswa');
Route::post('/keterangan-beasiswa/store', [KeteranganBeasiswaController::class, 'store'])->name('frontend.keteranganbeasiswa.store');

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

    Route::get('/aparatur', [TtdController::class, 'index'])->name('ttd');
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
