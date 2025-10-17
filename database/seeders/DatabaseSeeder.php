<?php

namespace Database\Seeders;

use App\Models\Aparatur;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::create([
        //     'username' => 'Admin',
        //     'email' => 'admin@gmail.com',
        //     'password' => 'pass1234',
        // ]);

        $this->call([
            MasyarakatSeeder::class,
            UserSeeder::class,
            PersyaratanSeeder::class,
            PelayananSeeder::class,
        ]);
        Aparatur::truncate();

        $aparatur = [
            [
                'nip' => '197501011999031001',
                'nama' => 'Andika',
                'jabatan' => 'Lurah',
                'foto' => 'assets/img/avatar.jpg',
                'posisi' => 1,
            ],
            [
                'nip' => '198003021999031002',
                'nama' => 'Yaya',
                'jabatan' => 'Sekretaris',
                'foto' => 'assets/img/avatar.jpg',
                'posisi' => 2,
            ],
            [
                'nip' => '198504051999031003',
                'nama' => 'Tendri',
                'jabatan' => 'Kepala Seksi',
                'foto' => 'assets/img/avatar.jpg',
                'posisi' => 3,
            ],
            [
                'nip' => '199001011999031004',
                'nama' => 'Admin',
                'jabatan' => 'Admin',
                'foto' => 'assets/img/avatar.jpg',
                'posisi' => 4,
            ],
        ];

        foreach ($aparatur as $item) {
            Aparatur::create([
                'nip' => $item['nip'],
                'nama' => $item['nama'],
                'jabatan' => $item['jabatan'],
                'foto' => $item['foto'],
                'posisi' => $item['posisi'],
            ]);
        }
    }
}
