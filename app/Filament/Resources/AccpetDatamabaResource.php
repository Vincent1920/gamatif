<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AccpetDatamaba;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\CheckboxColumn;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AccpetDatamabaResource\Pages;
use App\Filament\Resources\AccpetDatamabaResource\RelationManagers;
use Illuminate\Support\Facades\Mail;
use App\Mail\MahasiswaBaruActivated;

class AccpetDatamabaResource extends Resource
{
    protected static ?string $model = AccpetDatamaba::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $pluralModelLabel = 'Accpe Datamahasiswa';
    protected static ?int $navigationSort = 1;
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
            ->modifyQueryUsing(function ($query) {
                return $query->orderByRaw("
                CASE
                    WHEN status = 0 THEN 0
                    WHEN status IS NULL THEN 1
                    ELSE 2
                END
            ")->orderBy('nama_lengkap', 'asc'); // opsional, biar tetap rapi
            })

            ->columns([
                TextColumn::make('nim')
                    ->label('NIM')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nomor_whatsapp')
                    ->label('No. WhatsApp'),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                    
                // tampilkan file bukti registrasi
                ImageColumn::make('bukti_registrasi')
                    ->label('Bukti Registrasi')
                    ->disk('public')
                    ->width(120)
                    ->height(70)
                    ->square()
                    ->url(fn($record) => Storage::disk('public')->url($record->foto))
                    ->extraImgAttributes(['loading' => 'lazy']),

                // Checkbox status aktif / tidak_aktif
                CheckboxColumn::make('status')
                    ->label('Status')
                    ->afterStateUpdated(function ($state, $record) {
                        if ($state) {
                            // Status changed to aktif, send email
                            Mail::to($record->email)->send(new MahasiswaBaruActivated($record->nama_lengkap));
                        }
                    })


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
            'index' => Pages\ListAccpetDatamabas::route('/'),
            // 'create' => Pages\CreateAccpetDatamaba::route('/create'),
            // 'edit' => Pages\EditAccpetDatamaba::route('/{record}/edit'),
        ];
    }
}
