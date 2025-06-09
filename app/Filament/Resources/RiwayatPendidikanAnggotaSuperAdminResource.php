<?php

namespace App\Filament\Resources;

use App\Filament\Exports\RiwayatPendidikanExporter;
use App\Filament\Resources\RiwayatPendidikanAnggotaSuperAdminResource\Pages;
use App\Filament\Resources\RiwayatPendidikanAnggotaSuperAdminResource\RelationManagers;
use App\Models\RiwayatPendidikan;
use App\Models\RiwayatPendidikanAnggotaSuperAdmin;
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

class RiwayatPendidikanAnggotaSuperAdminResource extends Resource
{
    protected static ?string $model = RiwayatPendidikan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Riwayat Pendidikan Anggota';

    protected static ?string $modelLabel = 'Riwayat Pendidikan Anggota';
    protected static ?string $pluralModelLabel = 'Riwayat Pendidikan Anggota';

    public static function getLabel(): ?string
    {
        return 'Riwayat Pendidikan Anggota';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Riwayat Pendidikan Anggota';
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
                Forms\Components\Select::make('tingakt_pendidikan')
                    ->label('Tingkat Pendidikan')
                    ->options([
                        'SD / Sederajat' => 'SD / Sederajat',
                        'SMP / Sederajat' => 'SMP / Sederajat',
                        'SMA / Sederajat' => 'SMA / Sederajat',
                        'SMK' => 'SMK',
                        'DI' => 'DI',
                        'D-II' => 'D-II',
                        'D-III' => 'D-III',
                        'D-IV / Sarjana' => 'D-IV / Sarjana',
                        'Pasca Sarjana - S2' => 'Pasca Sarjana - S2',
                        'Pasca Sarjana - S3' => 'Pasca Sarjana - S3',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('nama_instansi')
                    ->label('Nama Instansi')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('tahun_lulus')
                    ->label('Tahun Lulus')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y') + 10)
                    ->length(4)
                    ->nullable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(RiwayatPendidikanExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('anggota.name')
                    ->label('Nama Anggota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('anggota.ranting.nama_ranting')->label('Ranting')->searchable(),
                Tables\Columns\TextColumn::make('tingakt_pendidikan')
                    ->label('Tingkat Pendidikan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_instansi')
                    ->label('Nama Instansi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tahun_lulus')
                    ->label('Tahun Lulus')
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
                        ->label('Ijazah')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->url(fn($record) => $record->ijazah ? Storage::url($record->ijazah) : null)
                        ->openUrlInNewTab()
                        ->visible(fn($record) => !empty($record->ijazah)),
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
            'index' => Pages\ListRiwayatPendidikanAnggotaSuperAdmins::route('/'),
        ];
    }
}
