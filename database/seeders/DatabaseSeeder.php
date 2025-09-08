<?php
use App\Models\User;
use App\Models\Kelompok;
use App\Models\DataMahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Daftar nama kelompok
        $kelompokNames = [
            'Gipsy_Danger',
            'Striker_Eureka',
            'Crimson_Typhoon',
            'Cherno_Alpha',
            'Bracer_Phoenix',
            'Saber_Athena',
            'Titan_Redeemer',
            'Guardian_Bravo',
            'Obsidian_Fury',
            'Horizon_Brave'
        ];

        // Buat data kelompok
        $kelompoks = [];
        foreach ($kelompokNames as $name) {
            $kelompoks[$name] = Kelompok::create(['nama_kelompok' => $name]);
        }

        // Buat user Admin
        User::factory()->create([
            'name' => 'Admin',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('adm_admin123'),
            'kelompok_id' => null,
        ]);

        // Buat user untuk masing-masing kelompok
        foreach ($kelompokNames as $index => $name) {
            User::factory()->create([
                'name' => 'Kelompok ' . ($index + 1) . ' - ' . str_replace('_', ' ', $name),
                'role' => 'pk',
                'email' => $name . '@gmail.com',
                'password' => Hash::make($name),
                'kelompok_id' => $kelompoks[$name]->id,
            ]);
        }

        // Data mahasiswa
        $mahasiswaData = [
            ['nim' => '10001', 'nama' => 'Gipsy Danger', 'nama_kelompok' => 'Gipsy_Danger'],
            ['nim' => '10002', 'nama' => 'Striker Eureka', 'nama_kelompok' => 'Striker_Eureka'],
            ['nim' => '10003', 'nama' => 'Crimson Typhoon', 'nama_kelompok' => 'Crimson_Typhoon'],
            ['nim' => '10004', 'nama' => 'Cherno Alpha', 'nama_kelompok' => 'Cherno_Alpha'],
            ['nim' => '10005', 'nama' => 'Bracer Phoenix', 'nama_kelompok' => 'Bracer_Phoenix'],
            ['nim' => '10006', 'nama' => 'Saber Athena', 'nama_kelompok' => 'Saber_Athena'],
            ['nim' => '10007', 'nama' => 'Titan Redeemer', 'nama_kelompok' => 'Titan_Redeemer'],
            ['nim' => '10008', 'nama' => 'Guardian Bravo', 'nama_kelompok' => 'Guardian_Bravo'],
            ['nim' => '10009', 'nama' => 'Obsidian Fury', 'nama_kelompok' => 'Obsidian_Fury'],
            ['nim' => '10010', 'nama' => 'Horizon Brave', 'nama_kelompok' => 'Horizon_Brave'],
        ];

        foreach ($mahasiswaData as $data) {
            DataMahasiswa::create([
                'nim' => $data['nim'],
                'nama' => $data['nama'],
                'kelompok_id' => $kelompoks[$data['nama_kelompok']]->id,
            ]);
        }
    }
}
