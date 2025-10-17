<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PersyaratanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengosongkan tabel terlebih dahulu untuk menghindari duplikasi data
        DB::table('persyaratans')->truncate();

        // Menyisipkan data baru
        DB::table('persyaratans')->insert([
            [
                'nama' => 'Pengantar RT',
                'keterangan' => 'Surat pengantar resmi yang telah ditandatangani dan dicap oleh Ketua RT setempat.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Fotokopi Kartu Keluarga (KK)',
                'keterangan' => 'Salinan Kartu Keluarga pemohon yang masih berlaku dan datanya terbaca dengan jelas.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Fotokopi KTP',
                'keterangan' => 'Salinan Kartu Tanda Penduduk pemohon yang masih berlaku dan datanya terbaca dengan jelas.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Bukti Lunas PBB',
                'keterangan' => 'Tanda terima atau bukti pembayaran Pajak Bumi dan Bangunan (PBB) untuk tahun berjalan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Surat Keterangan Kelahiran',
                'keterangan' => 'Surat keterangan lahir asli dari bidan, dokter, atau rumah sakit, diperlukan untuk penambahan anggota keluarga di KK.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'FC Akta Cerai/Kematian',
                'keterangan' => 'Fotokopi Akta Cerai atau Surat Keterangan Kematian yang diperlukan bagi pemohon berstatus duda atau janda.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Fotokopi Ijazah Terakhir',
                'keterangan' => 'Salinan ijazah pendidikan formal terakhir yang telah dilegalisir.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Fotokopi Bukti Waris',
                'keterangan' => 'Salinan dokumen bukti warisan seperti sertifikat, BPKB, surat wasiat, atau dokumen lain yang sah.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Fotokopi Bukti Kepemilikan',
                'keterangan' => 'Dokumen yang membuktikan kepemilikan sah atas suatu aset, misalnya sertifikat tanah.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Foto Tempat Usaha',
                'keterangan' => 'Foto yang menunjukkan tampak depan (plang nama) dan bagian dalam dari lokasi usaha.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Fotokopi Akta Pendirian',
                'keterangan' => 'Salinan akta notaris mengenai pendirian badan usaha atau yayasan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Daftar Susunan Pengurus',
                'keterangan' => 'Dokumen yang berisi daftar nama dan jabatan pengurus aktif dalam badan usaha atau yayasan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'nama' => 'Dokumen Pendukung Lainnya',
                'keterangan' => 'Surat atau bukti relevan lainnya yang mungkin diperlukan sesuai dengan jenis surat keterangan yang diajukan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
