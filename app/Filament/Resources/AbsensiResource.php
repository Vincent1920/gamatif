<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Absensi;
use App\Models\Kelompok;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DataMahasiswa;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\CheckboxColumn;
use App\Filament\Resources\AbsensiResource\Pages;

class AbsensiResource extends Resource
{
    protected static ?string $model = Absensi::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Absensi Mahasiswa';
    
    // Label dinamis per kelompok (opsional, bisa pakai Blade)
    protected static ?string $pluralModelLabel = 'Absensi';

  

public static function table(Table $table): Table
{
    return $table
        ->defaultPaginationPageOption('all')
        ->defaultSort('nim', 'asc') 
        ->columns([
            TextColumn::make('index')
                ->label('No')
                ->rowIndex(),

            TextColumn::make('nim')
                ->label('NIM')
                ->searchable()
                ->sortable(),

            TextColumn::make('nama')
                ->label('Nama')
                ->searchable()
                ->sortable(),

            TextColumn::make('kelompok.nama_kelompok')
                ->label('Kelompok')
              ->formatStateUsing(fn ($state) => str_replace('_', ' ', $state)),
                // ->formatStateUsing(fn ($state, $record) => $state ?? 'Kelompok ID: ' . $record->kelompok_id),

            CheckboxColumn::make('day_1')->label('Day 1'),
            CheckboxColumn::make('day_2')->label('Day 2'),
            CheckboxColumn::make('day_3')->label('Day 3'),
        ])
        ->filters(array_filter([
            auth()->user()->role === 'admin'
                ? SelectFilter::make('kelompok_id')
                    ->label('Kelompok')
                    ->relationship('kelompok', 'nama_kelompok')
                : null,
        ]));
}

public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
{
    $query = parent::getEloquentQuery();

    $user = auth()->user();

    if ($user->role === 'pk') {
        $query->where('kelompok_id', $user->kelompok_id);
    }

    return $query;
}



    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbsensis::route('/'),
            // 'create' => Pages\CreateAbsensi::route('/create'),
            // 'edit' => Pages\EditAbsensi::route('/{record}/edit'),
        ];
    }



}
