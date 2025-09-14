<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\InfoDataMaba;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InfoDataMabaResource\Pages;
use App\Filament\Resources\InfoDataMabaResource\RelationManagers;

class InfoDataMabaResource extends Resource
{
    protected static ?string $model = InfoDataMaba::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Absensi Mahasiswa';
    protected static ?int $navigationSort = 3;
    // Label dinamis per kelompok (opsional, bisa pakai Blade)
    protected static ?string $pluralModelLabel = 'Info DataMaba';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

   
public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('nim')
                ->label('NIM')
                ->sortable()
                ->searchable(),

            TextColumn::make('nama_lengkap')
                ->label('Nama Lengkap')
                ->sortable()
                ->searchable(),

        TextColumn::make('kelompok.nama_kelompok')
            ->label('Kelompok')
            ->sortable()
            ->searchable()
            ->getStateUsing(fn ($record) => $record->kelompok->nama_kelompok ?? 'Maba belum ambil kelompok')
            ->color(fn ($record) => $record->kelompok ? 'success' : 'danger'),


        ])
          ->filters([
            // Filter Kelompok
            \Filament\Tables\Filters\SelectFilter::make('kelompok_id')
                ->label('Kelompok')
                ->options(
                    \App\Models\Kelompok::orderBy('nama_kelompok')
                        ->pluck('nama_kelompok', 'id')
                        ->toArray()
                )
                ->searchable(),
                ]);
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
            'index' => Pages\ListInfoDataMabas::route('/'),
            // 'create' => Pages\CreateInfoDataMaba::route('/create'),
            // 'edit' => Pages\EditInfoDataMaba::route('/{record}/edit'),
        ];
    }
}
