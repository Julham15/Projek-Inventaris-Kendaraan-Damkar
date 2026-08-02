<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('laporan_kondisis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('laporan_id')->constrained()->onDelete('cascade');
        $table->foreignId('kondisi_id')->nullable()->constrained()->nullOnDelete();
        $table->string('nama_kondisi');
        $table->string('status');
        $table->string('foto')->nullable();
        $table->boolean('foto_dihapus_admin')->default(false);
        $table->text('deskripsi')->nullable();
        $table->timestamps();

    });
}
    public function down(): void
    {
        Schema::dropIfExists('laporan_kondisis');
    }
};
