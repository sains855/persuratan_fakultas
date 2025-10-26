<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('Alumnis', function (Blueprint $table) {
            $table->string('no_ijazah')->primary();
            $table->year('tahun_studi_mulai');
            $table->year('tahun_studi_selesai');
            $table->date('tgl_yudisium');

            // Foreign key ke tabel mahasiswa
            $table->string('mahasiswa_nim');
            $table->foreign('mahasiswa_nim')->references('nim')->on('mahasiswas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::dropIfExists('Alumnis');
    }
};
