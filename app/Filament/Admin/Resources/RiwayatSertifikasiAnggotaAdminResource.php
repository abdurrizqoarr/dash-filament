<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\RiwayatSertifikasiAnggotaAdminResource\Pages;
use App\Filament\Admin\Resources\RiwayatSertifikasiAnggotaAdminResource\RelationManagers;
use App\Filament\Exports\SertifikasiExporter;
use App\Models\RiwayatSertifikasiAnggotaAdmin;
use App\Models\Sertifikasi;
use Filament\Actions\ActionGroup as ActionsActionGroup;
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

class RiwayatSertifikasiAnggotaAdminResource extends Resource
{
    protected static ?string $model = Sertifikasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Riwayat Pendidikan Non Formal';

    protected static ?string $modelLabel = 'Riwayat Pendidikan Non Formal';
    protected static ?string $pluralModelLabel = 'Riwayat Pendidikan Non Formal';

    public static function getLabel(): ?string
    {
        return 'Riwayat Pendidikan Non Formal';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Riwayat Pendidikan Non Formal';
    }
    protected static ?string $navigationGroup = 'KEANGGOTAAN';
    protected static ?int $navigationSort = 7;

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
            ->columns([
                Tables\Columns\TextColumn::make('anggota.name')
                    ->label('Nama Anggota')
                    ->searchable(),

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
            ->query(function () {
                $idRanting = Auth::guard('admin')->user()->id_ranting;
                return Sertifikasi::query()
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
                        ->url(fn($record) => $record->dokumen_sertifikasi
                            ? route('download.document', ['filename' => $record->dokumen_sertifikasi])
                            : null)
                        ->openUrlInNewTab()
                        ->visible(fn($record) => !empty($record->dokumen_sertifikasi)),
                ])
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
            'index' => Pages\ListRiwayatSertifikasiAnggotaAdmins::route('/'),
        ];
    }
}
