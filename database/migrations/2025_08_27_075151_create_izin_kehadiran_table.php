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
            $table->foreignId('nim');
            $table->date('tanggal');
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
