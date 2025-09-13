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
        Schema::create('izin_kehadiran', function (Blueprint $table) {
            $table->id();
            $table->string('catatan');
            $table->string('nim'); 
            $table->foreign('nim')->references('nim')->on('data_mahasiswa')->onDelete('cascade');
            $table->json('day');
            $table->date('tanggal');
            // $table->foreignId('data_mahasiswa_id')->constrained('data_mahasiswa', 'id');
            $table->foreignId('kelompok_id')->constrained('kelompoks', 'id');
            $table->string('keterangan');
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_kehadiran');
    }
};
