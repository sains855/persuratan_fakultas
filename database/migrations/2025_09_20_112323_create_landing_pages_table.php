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
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string('nama_instansi');
            $table->string('slogan');
            $table->string('gambar_utama');
            $table->text('deskripsi');
            $table->text('visi');
            $table->text('misi');
            $table->string('koordinat');
            $table->text('alamat');
            $table->string('telpon');
            $table->text('waktu_pelayanan');
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_pages');
    }
};
