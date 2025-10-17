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
        Schema::create('dokumen_persyaratans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nim');
            $table->unsignedBigInteger('persyaratan_id');
            $table->unsignedBigInteger('pelayanan_id');
            $table->text('dokumen');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_persyaratans');
    }
};
