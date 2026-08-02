<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('peralatans', function (Blueprint $table) {
        $table->id();
       
        $table->foreignId('kendaraan_id')->constrained()->onDelete('cascade');
        $table->string('nama_alat');
        // $table->string('gambar')->nullable();
        $table->integer('jumlah')->default(1);
        $table->enum('kondisi', [
            'Baik',
            'Rusak Ringan',
            'Rusak Berat'
        ])->default('Baik');
        $table->date('tanggal_pengadaan')->nullable();
        // $table->text('deskripsi')->nullable();
        $table->timestamps();
    });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('peralatans');
    }
};
