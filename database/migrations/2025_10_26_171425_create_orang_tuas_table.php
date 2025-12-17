<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orang_tuas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('pekerjaaan');
            $table->string('NIP_NOPensiun_NRP')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('instansi')->nullable();
            $table->string('alamat');
            $table->string('no_hp')->nullable();
            $table->string('mahasiswa_nim');
            $table->foreign('mahasiswa_nim')->references('nim')->on('mahasiswas')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orang_tuas');
    }
};
