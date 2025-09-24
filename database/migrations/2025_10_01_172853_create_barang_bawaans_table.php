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
        Schema::create('barang_bawaan', function (Blueprint $table) {
            $table->id();
        //   $table->foreignId('data_mahasiswa_id')->nullable()->constrained('data_mahasiswa'); // nullable supaya admin bisa tanpa kelompok
          $table->foreignId('absensi_id')->nullable()->constrained('absensi');
          $table->foreignId('jadwal_kegiatan_id')->nullable()->constrained('jadwal_kegiatan');
          $table->foreignId('Nama_Barang_Bawaan_id')->nullable()->constrained('Nama_Barang_Bawaan'); // nullable supaya admin bisa tanpa kelompok
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_bawaan');
    }
};
