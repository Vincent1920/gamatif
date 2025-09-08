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
        Schema::create('barang_bawaans', function (Blueprint $table) {
            $table->id();
          $table->foreignId('data_mahasiswa_id')->nullable()->constrained('data_mahasiswa'); // nullable supaya admin bisa tanpa kelompok
            $table->boolean('barang_1_day_1')->default(false)->change();
            $table->boolean('barang_2_day_1')->default(false)->change();
            $table->boolean('barang_3_day_1')->default(false)->change();
            $table->boolean('barang_4_day_1')->default(false)->change();
            $table->boolean('barang_5_day_1')->default(false)->change();
                    
            $table->string('barang_1_day_2')->default(false);
            $table->string('barang_2_day_2')->default(false);
            $table->string('barang_3_day_2')->default(false);
            $table->string('barang_4_day_2')->default(false);
            $table->string('barang_5_day_2')->default(false);
            
            $table->string('barang_1_day_3')->default(false);
            $table->string('barang_2_day_3')->default(false);
            $table->string('barang_3_day_3')->default(false);
            $table->string('barang_4_day_3')->default(false);
            $table->string('barang_5_day_3')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_bawaans');
    }
};
