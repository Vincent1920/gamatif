<?php

namespace App\Filament\Widgets;

use App\Models\Kelompok;
use App\Models\MahasiswaBaru;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
class DashboardOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Kelompok', Kelompok::count())
                ->description('Jumlah kelompok yang terdaftar')
                ->color('primary'),

            Stat::make('Total Maba', MahasiswaBaru::count())
                ->description('Jumlah seluruh mahasiswa baru')
                ->color('success'),

            Stat::make('Laki-laki', MahasiswaBaru::where('jenis_kelamin', 'L')->count())
                ->description('Jumlah maba laki-laki')
                ->color('info'),

            Stat::make('Perempuan', MahasiswaBaru::where('jenis_kelamin', 'P')->count())
                ->description('Jumlah maba perempuan')
                ->color('pink'),
        ];
    }

    
}