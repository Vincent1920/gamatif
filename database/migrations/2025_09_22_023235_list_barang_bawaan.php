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
        Schema::create('list_barang_bawaan', function (Blueprint $table) {
            $table->id();
              $table->foreignId('mahasiswa_baru_id')->nullable()->constrained('mahasiswa_baru');
              $table->foreignId('data_barang_bawaan_id')->nullable()->constrained('data_barang_bawaan');
              $table->foreignId('jadwal_kegiatan_id')->nullable()->constrained('jadwal_kegiatan');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_barang_bawaan');
    }
};
