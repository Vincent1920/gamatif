<?php

namespace Database\Seeders;

use App\Models\JadwalKegiatan;
use Illuminate\Database\Seeder;

class JadwalKegiatanSeeder extends Seeder
{
    public function run(): void
    {
        $jadwalData = [
            [
                'nama' => 'Pembukaan PKKMB',
                'tanggal' => '2025-09-15',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '10:00',
            ],
            [
                'nama' => 'Sesi Perkenalan',
                'tanggal' => '2025-09-15',
                'waktu_mulai' => '10:30',
                'waktu_selesai' => '12:00',
            ],
            [
                'nama' => 'Istirahat',
                'tanggal' => '2025-09-15',
                'waktu_mulai' => '12:00',
                'waktu_selesai' => '13:00',
            ],
            [
                'nama' => 'Workshop Tim',
                'tanggal' => '2025-09-15',
                'waktu_mulai' => '13:00',
                'waktu_selesai' => '15:00',
            ],
        ];

        foreach ($jadwalData as $data) {
            JadwalKegiatan::create($data);
        }
    }
}
