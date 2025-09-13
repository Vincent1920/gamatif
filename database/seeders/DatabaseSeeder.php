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
            'Gipsy Danger',
            'Striker Eureka',
            'Crimson Typhoon',
            'Cherno Alpha',
            'Bracer Phoenix',
            'Saber Athena',
            'Titan Redeemer',
            'Guardian Bravo',
            'Obsidian Fury',
            'Horizon Brave'
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
        // ubah spasi jadi underscore, tapi biarkan huruf besar tetap
        $emailName = str_replace(' ', '_', $name);

        User::factory()->create([
            'name' => 'Kelompok ' . ($index + 1) . ' - ' . str_replace('_', ' ', $name),
            'role' => 'pk',
            'email' => $emailName . '@gmail.com',
            'password' => Hash::make($emailName), // password juga bisa pakai versi underscore
            'kelompok_id' => $kelompoks[$name]->id,
        ]);
    }


        // Data mahasiswa
        $mahasiswaData = [
            ['nim' => '10001', 'nama' => 'Gipsy Danger', 'nama_kelompok' => 'Gipsy Danger'],
            ['nim' => '10002', 'nama' => 'Striker Eureka', 'nama_kelompok' => 'Striker Eureka'],
            ['nim' => '10003', 'nama' => 'Crimson Typhoon', 'nama_kelompok' => 'Crimson Typhoon'],
            ['nim' => '10004', 'nama' => 'Cherno Alpha', 'nama_kelompok' => 'Cherno Alpha'],
            ['nim' => '10005', 'nama' => 'Bracer Phoenix', 'nama_kelompok' => 'Bracer Phoenix'],
            ['nim' => '10006', 'nama' => 'Saber Athena', 'nama_kelompok' => 'Saber Athena'],
            ['nim' => '10007', 'nama' => 'Titan Redeemer', 'nama_kelompok' => 'Titan Redeemer'],
            ['nim' => '10008', 'nama' => 'Guardian Bravo', 'nama_kelompok' => 'Guardian Bravo'],
            ['nim' => '10009', 'nama' => 'Obsidian Fury', 'nama_kelompok' => 'Obsidian Fury'],
            ['nim' => '10010', 'nama' => 'Horizon Brave', 'nama_kelompok' => 'Horizon Brave'],
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
