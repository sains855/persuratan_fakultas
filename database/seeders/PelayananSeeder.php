<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PelayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengosongkan tabel terlebih dahulu
        DB::table('pelayanans')->truncate();

        // Menyisipkan data layanan baru
        DB::table('pelayanans')->insert([
            [
                'nama' => 'Surat Keterangan Tempat Tinggal Sementara',
                'icon' => 'fa-solid fa-house-user',
                'deskripsi' => 'Surat keterangan bagi penduduk yang berdomisili sementara di wilayah kelurahan.',
                'keterangan_surat' => 'Nama yang tersebut diatas benar bertempat tinggal sementara pada alamat {{ $alamat_sementara }}  RT {{ $rt }} / RW {{ $rw }} Kelurahan Tipulu Kecamatan Kendari Barat.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Keterangan Pindah Penduduk',
                'icon' => 'fa-solid fa-person-walking-arrow-right',
                'deskripsi' => 'Surat pengantar untuk proses pindah domisili ke luar wilayah kelurahan.',
                'keterangan_surat' => 'karena atas permintaan sendiri kepadanya diberikan Surat Keterangan Pindah Ke : ',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Pengurusan Kartu Keluarga (KK)',
                'icon' => 'fa-solid fa-users-rectangle',
                'deskripsi' => 'Layanan untuk pembuatan Kartu Keluarga baru, penambahan, atau pengurangan anggota.',
                'keterangan_surat' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Pengurusan KTP',
                'icon' => 'fa-solid fa-id-card',
                'deskripsi' => 'Surat pengantar untuk proses pembuatan atau perpanjangan Kartu Tanda Penduduk.',
                'keterangan_surat' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Pengantar Nikah',
                'icon' => 'fa-solid fa-ring',
                'deskripsi' => 'Surat pengantar dari kelurahan sebagai salah satu syarat untuk pendaftaran nikah di KUA.',
                'keterangan_surat' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Keterangan Belum Nikah',
                'icon' => 'fa-solid fa-person',
                'deskripsi' => 'Surat pernyataan resmi dari kelurahan yang menyatakan status perkawinan seseorang.',
                'keterangan_surat' => 'dan sepanjang pengetahuan kami berstatus belum menikah dan surat keterangan ini dibuat untuk keperluan {{ $keperluan }}',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Keterangan Kelakuan Baik (Pengantar SKCK)',
                'icon' => 'fa-solid fa-shield-halved',
                'deskripsi' => 'Surat pengantar dari kelurahan untuk pembuatan Surat Keterangan Catatan Kepolisian (SKCK).',
                'keterangan_surat' => 'untuk membuat Surat Kelakuan Baik.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Keterangan Ahli Waris',
                'icon' => 'fa-solid fa-people-roof',
                'deskripsi' => 'Surat yang menerangkan siapa saja yang berhak menjadi ahli waris dari seseorang yang telah meninggal.',
                'keterangan_surat' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Keterangan Hak Tanah',
                'icon' => 'fa-solid fa-landmark',
                'deskripsi' => 'Surat keterangan dari kelurahan yang berkaitan dengan status kepemilikan tanah.',
                'keterangan_surat' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Keterangan Memiliki Usaha (SKU)',
                'icon' => 'fa-solid fa-store',
                'deskripsi' => 'Surat keterangan yang menyatakan bahwa seseorang memiliki suatu usaha di wilayah kelurahan.',
                'keterangan_surat' => 'dan benar memiliki usaha seperti yang tercantum diatas dan berdiri sejak {{ $tahun_berdiri }} sampai dengan sekarang.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Keterangan Domisili Usaha dan Yayasan',
                'icon' => 'fa-solid fa-building',
                'deskripsi' => 'Surat yang menerangkan alamat atau domisili resmi dari suatu badan usaha atau yayasan.',
                'keterangan_surat' => 'dan benar memiliki usaha/Yayasan yang berdomisili di alamat sebagai mana berikut ini:',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Keterangan Belum Bekerja',
                'icon' => 'fa-solid fa-briefcase',
                'deskripsi' => 'Surat pernyataan yang menerangkan bahwa seseorang saat ini tidak sedang bekerja.',
                'keterangan_surat' => 'dan sepanjang pengetahuan kami berstatus tidak bekerja dan surat keterangan ini dibuat  untuk keperluan {{ $keperluan }}',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Keterangan Tidak Mampu (SKTM)',
                'icon' => 'fa-solid fa-hand-holding-heart',
                'deskripsi' => 'Surat keterangan bagi warga yang tergolong ekonomi lemah untuk berbagai keperluan.',
                'keterangan_surat' => 'dan sepanjang  pengetahuan kami tidak mampu dalam segi ekonomi dan surat keterangan ini kami berikan kepada yang bersangkutan untuk keperluan {{ $keperluan }}',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Izin Keramaian',
                'icon' => 'fa-solid fa-bullhorn',
                'deskripsi' => 'Surat pengantar untuk mendapatkan izin mengadakan acara yang mengundang keramaian.',
                'keterangan_surat' => 'Nama tersebut diatas adalah warga RT {{ $rt }}/ RW {{ $rw }} Kelurahan Tipulu Kecamatan Kendari Barat Kota Kendari, dan benar berencana mengadakan acara {{ $nama_acara }} {{ $deskripsi_acara }} yang Insya Allah dilaksanakan pada:',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Keterangan Kematian',
                'icon' => 'fa-solid fa-cross',
                'deskripsi' => 'Surat resmi yang menerangkan bahwa seorang penduduk telah meninggal dunia.',
                'keterangan_surat' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Keterangan Lainnya',
                'icon' => 'fa-solid fa-file-lines',
                'deskripsi' => 'Layanan untuk pengurusan surat keterangan lain yang tidak tercantum dalam daftar.',
                'kereterangan_surat' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
