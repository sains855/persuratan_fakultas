<?php

namespace Database\Seeders;

use App\Models\Aparatur;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
    */public function run(): void
    {
        $this->call([
            PelayananSeeder::class,
            PersyaratanSeeder::class,
            UserSeeder::class,
        ]);
    }
}
