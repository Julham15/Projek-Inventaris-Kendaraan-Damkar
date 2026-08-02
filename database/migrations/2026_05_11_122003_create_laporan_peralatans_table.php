<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('laporan_peralatans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('laporan_id')->constrained()->onDelete('cascade');
        $table->foreignId('peralatan_id')->nullable()->constrained()->nullOnDelete();
        $table->string('nama_peralatan');
        $table->integer('jumlah_awal');
        $table->integer('jumlah')->default(0);
        $table->string('kondisi');

        $table->string('foto')->nullable();
        $table->boolean('foto_dihapus_admin')->default(false);

        $table->text('deskripsi')->nullable();

        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('laporan_peralatans');
    }
};
