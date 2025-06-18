<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RiwayatPendidikanAnggotaAdminResource\Pages;
use App\Filament\Admin\Resources\RiwayatPendidikanAnggotaAdminResource\RelationManagers;
use App\Filament\Exports\RiwayatPengesahanExporter;
use App\Models\RiwayatPendidikan;
use App\Models\RiwayatPendidikanAnggotaAdmin;
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

class RiwayatPendidikanAnggotaAdminResource extends Resource
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
            ->columns([
                Tables\Columns\TextColumn::make('anggota.name')
                    ->label('Nama Anggota')
                    ->searchable(),
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
                //
            ])
            ->query(function () {
                $idRanting = Auth::guard('admin')->user()->id_ranting;
                return RiwayatPendidikan::query()
                    ->whereHas('anggota', function ($query) use ($idRanting) {
                        $query->where('id_ranting', $idRanting);
                    });
            })
            ->actions([
                ActionGroup::make([
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('download_sk')
                        ->label('Ijazah')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->url(fn($record) => $record->ijazah
                            ? route('download.document', ['filename' => $record->ijazah])
                            : null)
                        ->openUrlInNewTab()
                        ->visible(fn($record) => !empty($record->ijazah)),
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
            'index' => Pages\ListRiwayatPendidikanAnggotaAdmins::route('/'),
        ];
    }
}
