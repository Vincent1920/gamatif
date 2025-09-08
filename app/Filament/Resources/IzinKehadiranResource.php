<?php

namespace App\Filament\Resources;

use App\Exports\IzinKehadiranExport;
use Filament\Forms;
use Filament\Tables;
use App\Models\kelompok;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DataMahasiswa;
use App\Models\IzinKehadiran;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select as FormsSelect;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Facades\FilamentIcon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\IzinKehadiranResource\Pages;
use App\Filament\Resources\IzinKehadiranResource\RelationManagers;

class IzinKehadiranResource extends Resource
{
    protected static ?string $model = IzinKehadiran::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $pluralModelLabel = 'Izin Kehadiran Mahasiswa';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();
    
        // Kalau admin, tampilkan semua
        if ($user->email === 'admin@gmail.com') {
            return $query;
        }
    
        // Kalau PK, ambil nama kelompok dari email (sebelum '@')
        $kelompokName = explode('@', $user->email)[0];
    
        // Cari id kelompok berdasarkan nama_kelompok
        $kelompok = Kelompok::where('nama_kelompok', $kelompokName)->first();
    
        if ($kelompok) {
            $query->where('kelompok_id', $kelompok->id);
        } else {
            // Kalau tidak ada kelompoknya, biar aman kasih kosong
            $query->whereRaw('1=0');
        }
    
        return $query;
    }
    
public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Data Diri')
                ->schema([
                    DatePicker::make('tanggal')
                        ->label('Tanggal')
                        ->native(false)
                        ->required(), // wajib diisi

                    Select::make('kelompok_id')
                        ->label('Kelompok')
                        ->options(function () {
                            $user = auth()->user();

                            if ($user->role === 'admin') {
                                return \App\Models\Kelompok::pluck('nama_kelompok', 'id');
                            }

                            if ($user->role === 'pk') {
                                return \App\Models\Kelompok::where('id', $user->kelompok_id)
                                    ->pluck('nama_kelompok', 'id');
                            }

                            return [];
                        })
                        ->searchable()
                        ->required() // wajib diisi
                        ->afterStateUpdated(fn (callable $set) => $set('nim', null)),

                    Select::make('nim')
                        ->label('Nama Mahasiswa')
                        ->options(function (callable $get) {
                            $kelompok = $get('kelompok_id');
                            return DataMahasiswa::when($kelompok, function ($query) use ($kelompok) {
                                return $query->where('kelompok_id', $kelompok);
                            })
                                ->pluck('nama', 'nim')
                                ->toArray();
                        })
                        ->searchable()
                        ->required(), // wajib diisi

                    Select::make('keterangan')
                        ->label('Keterangan')
                        ->options([
                            'Izin' => 'Izin',
                            'tidak ada keterangan' => 'tidak ada keterangan',
                            'Sakit' => 'Sakit',
                        ])
                        ->required(), // wajib diisi

                    Section::make('Surat Izin')
                        ->description('Wajib Melampirkan Surat!!!')
                        ->schema([
                            Fieldset::make('Maximum Ukuran Foto 5 MB !!')
                                ->schema([
                                    FileUpload::make('foto')
                                        ->label('')
                                        ->image()
                                        ->preserveFilenames()
                                        ->disk('public')
                                        ->openable()
                                        ->previewable()
                                        ->downloadable()
                                        ->columnSpanFull(),
                                ]),
                        ]),
                ]),
        ]);
}


   
public static function table(Table $table): Table
{
    return $table
    
        ->columns([
            TextColumn::make('No')
                ->rowIndex(),

            TextColumn::make('tanggal'),

            TextColumn::make('dataMahasiswa.nama')
                ->label('Nama Mahasiswa'),

            TextColumn::make('kelompok.nama_kelompok')
                ->label('Kelompok'),

            TextColumn::make('keterangan'),

             // Klik gambar -> buka di tab baru
    ImageColumn::make('foto')
        ->label('Bukti Surat Izin')
        ->disk('public')
        ->width(120)
        ->height(70)
        ->square()
        ->url(fn ($record) => Storage::disk('public')->url($record->foto))
        ->openUrlInNewTab()
        ->extraImgAttributes(['loading' => 'lazy']),

            TextColumn::make('download_link')
                ->label('Download')
                ->getStateUsing(fn ($record) => $record->foto ? 'Download' : 'Tidak ada gambar')
                ->url(fn ($record) => $record->foto ? route('izin.download', $record->id) : null)
                ->openUrlInNewTab()
                ->extraAttributes(fn ($record) => [
                    'class' => $record->foto 
                        ? 'text-blue-600 hover:underline font-medium' 
                        : 'text-gray-500 italic',
                ]),
        ])
        ->filters([
            SelectFilter::make('kelompok_id')
                ->label('Kelompok')
                ->relationship('kelompok', 'nama_kelompok')
                ->visible(fn () => auth()->user()->email === 'admin@gmail.com'), // hanya admin bisa filter kelompok
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ])
    ->headerActions([
    ...(
        auth()->user()->role === 'admin'
            ? [
                // Export semua data
                Action::make('export_all')
                    ->label('Export Semua')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        return \Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\IzinKehadiranExport(null),
                            'data_izin_all.xlsx'
                        );
                    }),

                // Export per kelompok
                Action::make('export_per_kelompok')
                    ->label('Export per Kelompok')
                    ->icon('heroicon-o-funnel')
                    ->form([
                        \Filament\Forms\Components\Select::make('kelompok_id')
                            ->label('Kelompok')
                            ->options(fn () => \App\Models\Kelompok::orderBy('nama_kelompok')->pluck('nama_kelompok', 'id'))
                            ->searchable()
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $kelompokId = $data['kelompok_id'];
                        $kelompok = \App\Models\Kelompok::find($kelompokId);
                        $filename = 'data_izin_' . ($kelompok?->nama_kelompok ?? $kelompokId) . '.xlsx';

                        return \Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\IzinKehadiranExport($kelompokId),
                            $filename
                        );
                    }),
            ]
            : []
    )
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
            'index' => Pages\ListIzinKehadirans::route('/'),
            'create' => Pages\CreateIzinKehadiran::route('/create'),
            'edit' => Pages\EditIzinKehadiran::route('/{record}/edit'),
        ];
    }
}
