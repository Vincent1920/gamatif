<?php

namespace App\Filament\Resources;

use App\Models\IzinKehadiran;
use App\Models\MahasiswaBaru;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Filament\Resources\IzinKehadiranResource\Pages;

class IzinKehadiranResource extends Resource
{
    protected static ?string $model = IzinKehadiran::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-minus';
    protected static ?string $navigationGroup = 'Absensi Mahasiswa';
    protected static ?int $navigationSort = 4;
    protected static ?string $pluralModelLabel = 'Izin / Sakit';

    public static function form(Form $form): Form
    {
        return $form->schema([


          Forms\Components\Select::make('mahasiswa_baru_id')
            ->label('Mahasiswa')
            ->options(function () {
                $user = auth()->user();

                return \App\Models\MahasiswaBaru::with('kelompok:id,nama_kelompok')
                    ->when($user->role === 'pk', fn($q) => $q->where('kelompok_id', $user->kelompok_id))
                    ->limit(50) 
                    ->get()
                    ->mapWithKeys(function ($m) {
                        return [
                            $m->id => "{$m->nim} - {$m->nama_lengkap} (" . ($m->kelompok->nama_kelompok ?? '-') . ")",
                        ];
                    })
                    ->toArray();
            })
            ->searchable()
            ->preload()
            ->reactive()
            ->required(),


            Forms\Components\Select::make('jadwal_kegiatan_id')
                ->label('Jadwal Kegiatan')
                ->relationship('jadwal', 'nama')
                ->searchable()
                ->preload()
                ->reactive()
                ->required(),

            Forms\Components\Select::make('keterangan')
                ->label('Keterangan')
                ->options([
                    'izin' => 'Izin',
                    'sakit' => 'Sakit',
                ])
                ->required(),

            Forms\Components\Textarea::make('catatan')
                ->label('Catatan')
                ->maxLength(255),

            Forms\Components\FileUpload::make('foto')
                ->label('Bukti (Opsional)')
                ->image()
                ->maxSize(2048),
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
                    ->searchable(),

                Tables\Columns\TextColumn::make('mahasiswa.kelompok.nama_kelompok')
                    ->label('Kelompok'),

                Tables\Columns\TextColumn::make('jadwal.nama')
                    ->label('Kegiatan'),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->badge()
                    ->colors([
                        'info'    => 'izin',
                        'gray'  => 'sakit',
                    ])
                    ->formatStateUsing(fn(string $state) => ucfirst($state)),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Diajukan')
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
            $query->whereHas('mahasiswa.kelompok', function ($q) use ($user) {
                $q->where('kelompok_id', $user->kelompok_id);
            });
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIzinKehadirans::route('/'),
            'create' => Pages\CreateIzinKehadiran::route('/create'),
            'edit' => Pages\EditIzinKehadiran::route('/{record}/edit'),
        ];
    }
}
