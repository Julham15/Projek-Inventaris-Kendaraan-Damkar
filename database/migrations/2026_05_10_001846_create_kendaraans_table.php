<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('kendaraans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('jenis_mobil_id')->constrained()->restrictOnDelete();
        // $table->string('nama_kendaraan');
        $table->string('gambar')->nullable();
        $table->string('nomor_polisi')->nullable();
        $table->string('deskripsi')->nullable();
        // $table->string('status')->default('Aktif');
        $table->timestamps();
        });
    }

   
   
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
