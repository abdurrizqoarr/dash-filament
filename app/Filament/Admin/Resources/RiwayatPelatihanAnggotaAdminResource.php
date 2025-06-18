<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RiwayatPelatihanAnggotaAdminResource\Pages;
use App\Filament\Admin\Resources\RiwayatPelatihanAnggotaAdminResource\RelationManagers;
use App\Filament\Exports\RiwayatLatihanExporter;
use App\Models\RiwayatLatihan;
use App\Models\RiwayatPelatihanAnggotaAdmin;
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

class RiwayatPelatihanAnggotaAdminResource extends Resource
{
    protected static ?string $model = RiwayatLatihan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Riwayat Pelatihan Anggota';

    protected static ?string $modelLabel = 'Riwayat Pelatihan Anggota';
    protected static ?string $pluralModelLabel = 'Riwayat Pelatihan Anggota';

    public static function getLabel(): ?string
    {
        return 'Riwayat Pelatihan Anggota';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Riwayat Pelatihan Anggota';
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
                        'Tingkat Polos' => 'Tingkat Polos',
                        'Tingkat Jambon' => 'Tingkat Jambon',
                        'Tingkat Hijau' => 'Tingkat Hijau',
                        'Tingkat Putih' => 'Tingkat Putih',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('rayon')
                    ->label('Rayon')
                    ->maxLength(240)
                    ->minLength(2)
                    ->required(),
                Forms\Components\TextInput::make('penyelenggara')
                    ->label('Penyelenggara')
                    ->maxLength(240)
                    ->minLength(2)
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
                Tables\Columns\TextColumn::make('rayon')
                    ->label('Rayon')
                    ->searchable(),
                Tables\Columns\TextColumn::make('penyelenggara')
                    ->label('Penyelenggara')
                    ->searchable(),
            ])
            ->filters([])
            ->query(function () {
                $idRanting = Auth::guard('admin')->user()->id_ranting;
                return RiwayatLatihan::query()
                    ->whereHas('anggota', function ($query) use ($idRanting) {
                        $query->where('id_ranting', $idRanting);
                    });
            })
            ->actions([
                ActionGroup::make([
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRiwayatPelatihanAnggotaAdmins::route('/'),
        ];
    }
}
