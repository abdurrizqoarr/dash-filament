<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PrestasiAnggotaAdminResource\Pages;
use App\Filament\Admin\Resources\PrestasiAnggotaAdminResource\RelationManagers;
use App\Filament\Exports\PrestasiExporter;
use App\Models\Prestasi;
use App\Models\PrestasiAnggotaAdmin;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup as ActionsActionGroup;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrestasiAnggotaAdminResource extends Resource
{
    protected static ?string $model = Prestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Prestasi Anggota';

    protected static ?string $modelLabel = 'Prestasi Anggota';
    protected static ?string $pluralModelLabel = 'Prestasi Anggota';

    public static function getLabel(): ?string
    {
        return 'Prestasi Anggota';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Prestasi Anggota';
    }
    protected static ?string $navigationGroup = 'Anggota';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false; // Disable editing for this resource
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('prestasi')
                    ->label('Prestasi')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tahun')
                    ->label('Tahun')
                    ->numeric()
                    ->minValue(1900)
                    ->maxValue(date('Y'))
                    ->required(),
                Forms\Components\Select::make('tingkat')
                    ->label('Tingkat')
                    ->options([
                        'Daerah' => 'Daerah',
                        'Provinsi' => 'Provinsi',
                        'Cabang' => 'Cabang',
                        'Nasional' => 'Nasional',
                        'Internasional' => 'Internasional',
                    ])
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(PrestasiExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('anggota.name')
                    ->label('Nama Anggota')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prestasi')
                    ->label('Prestasi'),
                Tables\Columns\TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tingkat')
                    ->label('Tingkat'),
            ])
            ->query(function () {
                $idRanting = Auth::guard('admin')->user()->id_ranting;
                return Prestasi::query()
                    ->whereHas('anggota', function ($query) use ($idRanting) {
                        $query->where('id_ranting', $idRanting);
                    });
            })
            ->filters([
                //
            ])
            ->actions([
                ActionsActionGroup::make([
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('download_sk')
                        ->label('Sertifikat')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->url(fn($record) => $record->sertifikat_prestasi ? Storage::url($record->sertifikat_prestasi) : null)
                        ->openUrlInNewTab()
                        ->visible(fn($record) => !empty($record->sertifikat_prestasi)),
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
            'index' => Pages\ListPrestasiAnggotaAdmins::route('/'),
        ];
    }
}
