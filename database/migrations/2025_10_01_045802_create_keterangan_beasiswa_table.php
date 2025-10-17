<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('keterangan_beasiswas', function (Blueprint $table) {
            $table->id();

            $table->string('mahasiswa_nim');
            $table->foreign('mahasiswa_nim')
                ->references('nim')
                ->on('mahasiswas')
                ->onDelete('cascade');
            $table->string('status_beasiswa');
            $table->string('keterangan_beasiswa');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keterangan_beasiswas');
    }
};
