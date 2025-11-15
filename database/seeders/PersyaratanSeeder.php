<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersyaratanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('persyaratans')->insert([
            [
                'nama' => 'Scan Kartu Tanda Mahasiswa (KTM)',
                'keterangan' => 'Upload scan / foto KTM yang masih berlaku.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Scan Kartu Keluarga (KK)',
                'keterangan' => 'Upload scan / foto Kartu Keluarga untuk validasi data mahasiswa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Scan Kartu Tanda Penduduk (KTP)',
                'keterangan' => 'Upload scan / foto KTP mahasiswa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Transkrip Nilai Terbaru',
                'keterangan' => 'Upload transkrip nilai terbaru (khusus untuk prestasi / aktif kuliah).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Surat Pernyataan Tidak Sedang Bekerja',
                'keterangan' => 'Upload surat pernyataan bermaterai bahwa mahasiswa tidak sedang bekerja (khusus untuk layanan terkait).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Piagam / Sertifikat Prestasi (jika ada)',
                'keterangan' => 'Upload sertifikat prestasi (khusus untuk Surat Keterangan Mahasiswa Prestasi).',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
