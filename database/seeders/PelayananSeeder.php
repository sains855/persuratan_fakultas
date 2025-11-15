<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelayanans')->insert([
            [
                'nama' => 'Surat Keterangan Aktif Kuliah',
                'icon' => 'fa-file-alt',
                'deskripsi' => 'Surat ini digunakan untuk menyatakan bahwa mahasiswa masih aktif berkuliah.',
                'keterangan_surat' => 'Digunakan untuk keperluan beasiswa / instansi pemerintah / instansi swasta.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Surat Keterangan Alumni',
                'icon' => 'fa-graduation-cap',
                'deskripsi' => 'Surat ini menyatakan bahwa pemohon adalah alumni kampus.',
                'keterangan_surat' => 'Wajib mengisi data alumni terlebih dahulu jika belum tersedia.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Surat Keterangan Tidak Sedang Menerima Beasiswa',
                'icon' => 'fa-ban',
                'deskripsi' => 'Surat ini menerangkan bahwa mahasiswa tidak sedang menerima beasiswa.',
                'keterangan_surat' => 'Tidak dapat diajukan jika masih tercatat sebagai penerima beasiswa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Surat Keterangan Mahasiswa Prestasi',
                'icon' => 'fa-star',
                'deskripsi' => 'Surat ini menerangkan bahwa mahasiswa memiliki prestasi.',
                'keterangan_surat' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Surat Keterangan Berkelakuan Baik',
                'icon' => 'fa-certificate',
                'deskripsi' => 'Surat ini menerangkan bahwa mahasiswa berkelakuan baik.',
                'keterangan_surat' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Surat Keterangan Tidak Sedang Bekerja',
                'icon' => 'fa-briefcase',
                'deskripsi' => 'Surat ini menerangkan bahwa mahasiswa tidak sedang bekerja.',
                'keterangan_surat' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
