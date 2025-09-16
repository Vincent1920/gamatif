<?php

namespace App\Filament\Widgets;

use App\Models\Kelompok;
use App\Models\MahasiswaBaru;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KelompokCard extends Widget
{
    protected static ?int $sort = 3;
    protected static string $view = 'filament.widgets.kelompok';

    // protected function getStats(): array
    // {
    //     return [
    //         Stat::make('Total Kelompok', Kelompok::count())
    //             ->description('Jumlah kelompok yang terdaftar')
    //             ->color('primary'),

    //         Stat::make('Total Maba', MahasiswaBaru::count())
    //             ->description('Jumlah seluruh mahasiswa baru')
    //             ->color('success'),

    //         Stat::make('Laki-laki', MahasiswaBaru::where('jenis_kelamin', 'L')->count())
    //             ->description('Jumlah maba laki-laki')
    //             ->color('info'),

    //         Stat::make('Perempuan', MahasiswaBaru::where('jenis_kelamin', 'P')->count())
    //             ->description('Jumlah maba perempuan')
    //             ->color('pink'),
    //     ];
    // }

    protected function getViewData(): array
    {
        // Data untuk kartu statistik
        $totalKelompok = Kelompok::count();
        $totalMaba = MahasiswaBaru::count();
        $jumlahLaki = MahasiswaBaru::where('jenis_kelamin', 'L')->count();
        $jumlahPerempuan = MahasiswaBaru::where('jenis_kelamin', 'P')->count();

        // Data untuk kartu kelompok
        $kelompok = Kelompok::withCount([
            'mahasiswaBaru as total_maba',
            'mahasiswaBaru as jumlah_laki' => fn ($q) => $q->where('jenis_kelamin', 'L'),
            'mahasiswaBaru as jumlah_perempuan' => fn ($q) => $q->where('jenis_kelamin', 'P'),
        ])->get();

        return [
            'totalKelompok' => $totalKelompok,
            'totalMaba' => $totalMaba,
            'jumlahLaki' => $jumlahLaki,
            'jumlahPerempuan' => $jumlahPerempuan,
            'kelompok' => $kelompok,
        ];
    }
}