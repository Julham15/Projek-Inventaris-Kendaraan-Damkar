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
       Schema::create('regus', function (Blueprint $table) {
    $table->id();

    $table->foreignId('platon_id')
          ->constrained()
          ->onDelete('cascade');

    $table->integer('nama');
       $table->unique(['platon_id', 'nama']);

    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('regus');
    }
    
};
