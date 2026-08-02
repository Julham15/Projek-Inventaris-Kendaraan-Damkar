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
         Schema::create('jenis_mobils', function (Blueprint $table) {
        $table->id();
       $table->foreignId('posko_id')->constrained()->restrictOnDelete();
        $table->string('nama_jenis');
        $table->integer('jumlah_mobil')->default(0);
        $table->string('gambar');
        $table->timestamps();
    });;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_mobils');
        
    }
};
