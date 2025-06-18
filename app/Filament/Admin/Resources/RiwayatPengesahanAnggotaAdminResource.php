<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RiwayatPengesahanAnggotaAdminResource\Pages;
use App\Filament\Admin\Resources\RiwayatPengesahanAnggotaAdminResource\RelationManagers;
use App\Filament\Exports\RiwayatPengesahanExporter;
use App\Models\RiwayatPengesahan;
use App\Models\RiwayatPengesahanAnggotaAdmin;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RiwayatPengesahanAnggotaAdminResource extends Resource
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
            ->columns([
                Tables\Columns\TextColumn::make('anggota.name')
                    ->label('Nama Anggota')
                    ->searchable(),

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
            ->query(function () {
                $idRanting = Auth::guard('admin')->user()->id_ranting;
                return RiwayatPengesahan::query()
                    ->whereHas('anggota', function ($query) use ($idRanting) {
                        $query->where('id_ranting', $idRanting);
                    });
            })
            ->filters([])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiwayatPengesahanAnggotaAdmins::route('/'),
            'create' => Pages\CreateRiwayatPengesahanAnggotaAdmin::route('/create'),
            'edit' => Pages\EditRiwayatPengesahanAnggotaAdmin::route('/{record}/edit'),
        ];
    }
}
