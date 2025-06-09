<?php

namespace App\Filament\Resources;

use App\Filament\Exports\RiwayatPengesahanExporter;
use App\Filament\Resources\RiwayatPengesahanAnggotaSuperAdminResource\Pages;
use App\Filament\Resources\RiwayatPengesahanAnggotaSuperAdminResource\RelationManagers;
use App\Models\RiwayatPengesahan;
use App\Models\RiwayatPengesahanAnggotaSuperAdmin;
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

class RiwayatPengesahanAnggotaSuperAdminResource extends Resource
{
    protected static ?string $model = RiwayatPengesahan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Riwayat Pengesahan Anggota';

    protected static ?string $modelLabel = 'Riwayat Pengesahan Anggota';
    protected static ?string $pluralModelLabel = 'Riwayat Pengesahan Anggota';

    public static function getLabel(): ?string
    {
        return 'Riwayat Pengesahan Anggota';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Riwayat Pengesahan Anggota';
    }
    protected static ?string $navigationGroup = 'Anggota';

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
                Forms\Components\Select::make('tingkat')
                    ->label('Tingkat')
                    ->options([
                        'Tingkat I' => 'Tingkat I',
                        'Tingkat II' => 'Tingkat II',
                        'Tingkat III' => 'Tingkat III',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('cabang')
                    ->label('Cabang')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('tahun')
                    ->label('Tahun')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(RiwayatPengesahanExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('anggota.name')
                    ->label('Nama Anggota')
                    ->searchable(),

                Tables\Columns\TextColumn::make('anggota.ranting.nama_ranting')->label('Ranting')->searchable(),

                Tables\Columns\TextColumn::make('tingkat')
                    ->label('Tingkat')
                    ->sortable(),

                Tables\Columns\TextColumn::make('cabang')
                    ->label('Cabang')
                    ->searchable(),

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
                        ->url(fn($record) => $record->sertifikat_pengesahan
                            ? route('download.document', ['filename' => $record->sertifikat_pengesahan])
                            : null)
                        ->openUrlInNewTab()
                        ->visible(fn($record) => !empty($record->sertifikat_pengesahan)),
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
            'index' => Pages\ListRiwayatPengesahanAnggotaSuperAdmins::route('/'),
        ];
    }
}
