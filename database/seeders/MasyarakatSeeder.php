<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Masyarakat; // Pastikan nama Model Anda benar
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB; // <-- Pastikan ini ada

class MasyarakatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- INI BAGIAN PERBAIKANNYA ---

        // 1. Matikan aturan foreign key untuk sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 2. Kosongkan tabel masyarakat
        Masyarakat::truncate();

        // 3. Aktifkan kembali aturan foreign key (SANGAT PENTING)
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // --- AKHIR PERBAIKAN ---


        // Bagian untuk mengisi data (ini sudah benar, tidak perlu diubah)
        $faker = Faker::create('id_ID');

        // Buat 20 data warga dummy
        for ($i = 0; $i < 20; $i++) {
            Masyarakat::create([
                'nik' => $faker->unique()->nik(),
                'nama' => $faker->name(),
                'tempat_lahir' => $faker->city(),
                'tgl_lahir' => $faker->date($format = 'Y-m-d', $max = '2005-01-01'),
                'alamat' => $faker->address(),
                'status' => $faker->randomElement(['Kawin', 'Belum Kawin']),
                'pekerjaan' => $faker->jobTitle(),
                'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                'jk' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'created_at' => now(),
                'RT' => $faker->numberBetween(1, 10), // Misal RT antara 1-10
                'RW' => $faker->numberBetween(1, 5),  // Misal RW antara 1-5
                'updated_at' => now(),
            ]);
        }
    }
}
