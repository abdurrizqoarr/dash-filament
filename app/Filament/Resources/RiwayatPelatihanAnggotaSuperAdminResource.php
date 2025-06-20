<?php

namespace App\Filament\Resources;

use App\Filament\Exports\RiwayatLatihanExporter;
use App\Filament\Resources\RiwayatPelatihanAnggotaSuperAdminResource\Pages;
use App\Filament\Resources\RiwayatPelatihanAnggotaSuperAdminResource\RelationManagers;
use App\Models\RiwayatLatihan;
use App\Models\RiwayatPelatihanAnggotaSuperAdmin;
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

class RiwayatPelatihanAnggotaSuperAdminResource extends Resource
{
    protected static ?string $model = RiwayatLatihan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Riwayat Latihan PSHT';

    protected static ?string $modelLabel = 'Riwayat Latihan PSHT';
    protected static ?string $pluralModelLabel = 'Riwayat Latihan PSHT';

    public static function getLabel(): ?string
    {
        return 'Riwayat Latihan PSHT';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Riwayat Latihan PSHT';
    }
    protected static ?string $navigationGroup = 'KEANGGOTAAN';
    protected static ?int $navigationSort = 3;

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
                        'Tingkat Polos' => 'Tingkat Polos',
                        'Tingkat Jambon' => 'Tingkat Jambon',
                        'Tingkat Hijau' => 'Tingkat Hijau',
                        'Tingkat Putih' => 'Tingkat Putih',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('rayon')
                    ->label('Rayon')
                    ->required(),
                Forms\Components\TextInput::make('penyelenggara')
                    ->label('Penyelenggara')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(RiwayatLatihanExporter::class)
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
                Tables\Columns\TextColumn::make('rayon')
                    ->label('Rayon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penyelenggara')
                    ->label('Penyelenggara')
                    ->searchable(),
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
                        ->url(fn($record) => $record->sertifikat
                            ? route('download.document', ['filename' => $record->sertifikat])
                            : null)
                        ->openUrlInNewTab()
                        ->visible(fn($record) => !empty($record->sertifikat)),
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
            'index' => Pages\ListRiwayatPelatihanAnggotaSuperAdmins::route('/'),
        ];
    }
}
