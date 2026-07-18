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
        Schema::create('norma_kerjas', function (Blueprint $table) {
            $table->id();
            $table->string('status_umur_tanaman');
            $table->string('item_kerja');
            $table->decimal('datar_norma', 10, 4)->nullable();
            $table->decimal('datar_rotasi', 8, 2)->nullable();
            $table->decimal('datar_nxr', 10, 4)->nullable();
            $table->decimal('roling1_norma', 10, 4)->nullable();
            $table->decimal('roling1_rotasi', 8, 2)->nullable();
            $table->decimal('roling1_nxr', 10, 4)->nullable();
            $table->decimal('roling2_norma', 10, 4)->nullable();
            $table->decimal('roling2_rotasi', 8, 2)->nullable();
            $table->decimal('roling2_nxr', 10, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('norma_kerjas');
    }
};
