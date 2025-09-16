<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing data: 'aktif' to 1, 'tidak_aktif' to 0
        DB::statement("UPDATE mahasiswa_baru SET status = CASE WHEN status = 'aktif' THEN 1 ELSE 0 END");

        // Change column to boolean
        DB::statement("ALTER TABLE mahasiswa_baru MODIFY status BOOLEAN DEFAULT 0");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Change back to enum
        DB::statement("ALTER TABLE mahasiswa_baru MODIFY status ENUM('tidak_aktif', 'aktif') DEFAULT 'tidak_aktif'");

        // Update data back
        DB::statement("UPDATE mahasiswa_baru SET status = CASE WHEN status = 1 THEN 'aktif' ELSE 'tidak_aktif' END");
    }
};
