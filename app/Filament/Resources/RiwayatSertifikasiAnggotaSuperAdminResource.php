<?php

namespace App\Filament\Resources;

use App\Filament\Exports\SertifikasiExporter;
use App\Filament\Resources\RiwayatSertifikasiAnggotaSuperAdminResource\Pages;
use App\Filament\Resources\RiwayatSertifikasiAnggotaSuperAdminResource\RelationManagers;
use App\Models\RiwayatSertifikasiAnggotaSuperAdmin;
use App\Models\Sertifikasi;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class RiwayatSertifikasiAnggotaSuperAdminResource extends Resource
{
    protected static ?string $model = Sertifikasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Riwayat Sertifikasi Anggota';
    protected static ?string $pluralModelLabel = 'Riwayat Sertifikasi Anggota';

    public static function getLabel(): ?string
    {
        return 'Riwayat Sertifikasi Anggota';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Riwayat Sertifikasi Anggota';
    }
    protected static ?string $navigationGroup = 'Anggota';
    protected static ?string $navigationLabel = 'Riwayat Sertifikasi Anggota';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sertifikasi')
                    ->label('Nama Sertifikasi')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('penyelenggara')
                    ->label('Penyelenggara')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('tingkat')
                    ->label('Tingkat')
                    ->required()
                    ->options([
                        'Internasional' => 'Internasional',
                        'Nasional' => 'Nasional',
                        'Provinsi' => 'Provinsi',
                        'Daerah' => 'Daerah',
                        'Cabang' => 'Cabang',
                    ]),

                Forms\Components\TextInput::make('tahun')
                    ->label('Tahun')
                    ->required()
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(SertifikasiExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('anggota.name')
                    ->label('Nama Anggota')
                    ->searchable(),

                Tables\Columns\TextColumn::make('anggota.ranting.nama_ranting')->label('Ranting')->searchable(),

                Tables\Columns\TextColumn::make('sertifikasi')
                    ->label('Nama Sertifikasi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('penyelenggara')
                    ->label('Penyelenggara')
                    ->searchable(),

                Tables\Columns\TextColumn::make('tingkat')
                    ->label('Tingkat')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('ranting')
                    ->label('Ranting')
                    ->relationship('anggota.ranting', 'nama_ranting')
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('download_sk')
                        ->label('Sertifikat')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->url(fn($record) => $record->dokumen_sertifikasi ? Storage::url($record->dokumen_sertifikasi) : null)
                        ->openUrlInNewTab()
                        ->visible(fn($record) => !empty($record->dokumen_sertifikasi)),
                ]),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['anggota.ranting']);
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
            'index' => Pages\ListRiwayatSertifikasiAnggotaSuperAdmins::route('/'),
        ];
    }
}
