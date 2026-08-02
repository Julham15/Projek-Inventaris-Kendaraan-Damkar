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
    Schema::create('status_peralatans', function (Blueprint $table) {

        $table->id();

        $table->foreignId('kendaraan_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->foreignId('peralatan_id')
              ->constrained()
              ->cascadeOnDelete();

        $table->string('status');

        $table->timestamps();

        $table->unique([
            'kendaraan_id',
            'peralatan_id'
        ]);
    });
}
};
