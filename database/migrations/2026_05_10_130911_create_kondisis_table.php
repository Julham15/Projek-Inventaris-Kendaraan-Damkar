<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('kondisis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('kendaraan_id')
              ->constrained()
              ->onDelete('cascade');
        $table->string('nama_kondisi');
        $table->enum('status', ['Baik','Cukup','Perlu Perhatian']);
        // $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}
};
