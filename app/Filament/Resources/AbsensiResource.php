<?php

namespace App\Filament\Resources;

use App\Models\Absensi;
use App\Models\MahasiswaBaru;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\AbsensiResource\Pages;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Absensi Mahasiswa';
    protected static ?int $navigationSort = 3;
    protected static ?string $pluralModelLabel = 'Absensi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('mahasiswa_baru_id')
                ->label('Mahasiswa')
                ->options(function (callable $get) {
                    $kelompokId = $get('kelompok_id');

                    return MahasiswaBaru::with('kelompok')
                        ->when($kelompokId, fn($q) => $q->where('kelompok_id', $kelompokId))
                        ->limit(20)
                        ->get()
                        ->mapWithKeys(function ($m) {
                            $kelompok = $m->kelompok?->nama_kelompok ?? '-';
                            return [
                                $m->id => "{$m->nim} - {$m->nama_lengkap} ({$kelompok})",
                            ];
                        })
                        ->toArray();
                })
                ->disabled(),

            Forms\Components\Select::make('jadwal_kegiatan_id')
                ->label('Jadwal Kegiatan')
                ->relationship('jadwal', 'nama')
                ->disabled(),

                Forms\Components\Toggle::make('status')
                    ->label('Hadir')
                    ->default(false)
                    ->disabled(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('mahasiswa.nim')
                    ->label('NIM')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('mahasiswa.nama_lengkap')
                    ->label('Nama')
                    ->sortable()
                    ->searchable()
                    ->disabled(),

                Tables\Columns\TextColumn::make('mahasiswa.kelompok.nama_kelompok')
                    ->label('Kelompok'),

                Tables\Columns\TextColumn::make('jadwal.nama')
                    ->label('Kegiatan'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'hadir',
                        'warning' => 'telat',
                        'info'    => 'izin',
                        'gray'  => 'sakit',
                        'danger' => 'alpa',
                    ])
                    ->formatStateUsing(fn(string $state) => ucfirst($state)),


                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Absen')
                    ->dateTime('d M Y H:i'),


            ])
            ->filters([
                Tables\Filters\SelectFilter::make('mahasiswa.kelompok_id')
                    ->label('Kelompok')
                    ->relationship('mahasiswa.kelompok', 'nama_kelompok'),
            ]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();

        $user = auth()->user();
        if ($user->role === 'pk') {
            // Filter berdasarkan kelompok user PK
            $query->whereHas('mahasiswa.kelompok', function ($q) use ($user) {
                $q->where('kelompok_id', $user->kelompok_id);
            });
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit' => Pages\EditAbsensi::route('/{record}/edit'),
            'absenqr' => Pages\AbsenQR::route('/absenqr'),
        ];
    }
}
