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
    Schema::create('absensi', function (Blueprint $table) {
        $table->id();

        $table->foreignId('data_mahasiswa_id')
              ->constrained('data_mahasiswa', 'id');

        $table->foreignId('kelompok_id')
              ->constrained('kelompoks')
              ->onDelete('cascade');

        $table->boolean('day_1')->default(false);
        $table->boolean('day_2')->default(false);
        $table->boolean('day_3')->default(false);

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absesi');
    }
};
