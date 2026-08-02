<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
   public function up(): void
    {
    Schema::create('laporans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('platon_id')->constrained()->onDelete('restrict');
        $table->foreignId('regu_id')->constrained()->onDelete('restrict');
        $table->foreignId('kendaraan_id')->constrained()->restrictOnDelete();
        $table->string('nama_posko')->nullable();
        // $table->string('foto')->nullable();
        //  $table->string('foto_kondisi')->nullable();
        $table->date('tanggal_kejadian')->nullable();
        $table->enum('status', ['Diproses','Selesai','Diarsipkan','Ditolak'])->default('Diproses');
        // $table->text('catatan_admin')->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
