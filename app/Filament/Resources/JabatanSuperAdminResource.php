<?php

namespace App\Filament\Resources;

use App\Filament\Exports\JabatanExporter;
use App\Filament\Resources\JabatanSuperAdminResource\Pages;
use App\Filament\Resources\JabatanSuperAdminResource\RelationManagers;
use App\Models\Jabatan;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Tables\Actions\ExportAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class JabatanSuperAdminResource extends Resource
{
    protected static ?string $model = Jabatan::class;
    protected static ?string $navigationLabel = 'Jabatan Anggota';

    public static function canCreate(): bool
    {
        return false;
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Jabatan Anggota';
    protected static ?string $pluralModelLabel = 'Jabatan Anggota';

    public static function getLabel(): ?string
    {
        return 'Jabatan Anggota';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Jabatan Anggota';
    }
    protected static ?string $navigationGroup = 'Anggota';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jabatan')
                    ->label('Jabatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('lokasi_jabatan')
                    ->label('Lokasi Jabatan')
                    ->options([
                        'Pusat' => 'Pusat',
                        'Provinsi' => 'Provinsi',
                        'Cabang' => 'Cabang',
                        'Ranting' => 'Ranting',
                        'Rayon' => 'Rayon',
                    ])
                    ->required(),
                Forms\Components\DatePicker::make('mulai_jabatan')
                    ->label('Mulai Jabatan')
                    ->required(),
                Forms\Components\DatePicker::make('akhir_jabatan')
                    ->label('Akhir Jabatan'),
                Forms\Components\FileUpload::make('sk_jabatan')
                    ->label('SK Jabatan')
                    ->directory('sk_jabatan')
                    ->maxSize(3072)
                    ->acceptedFileTypes(['application/pdf'])
                    ->helperText('Hanya file PDF yang diperbolehkan')
                    ->previewable(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(JabatanExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('anggota.name')->label('Nama Anggota')->searchable(),
                Tables\Columns\TextColumn::make('anggota.ranting.nama_ranting')->label('Ranting')->searchable(),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),
                Tables\Columns\TextColumn::make('lokasi_jabatan')->label('Lokasi Jabatan')->sortable(),
                Tables\Columns\TextColumn::make('mulai_jabatan')->label('Mulai Jabatan')->dateTime('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('akhir_jabatan')->label('Akhir Jabatan')->dateTime('d M Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('ranting')
                    ->label('Ranting')
                    ->relationship('anggota.ranting', 'nama_ranting')
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download_sk')
                    ->label('Download SK')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => $record->sk_jabatan ? Storage::url($record->sk_jabatan) : null)
                    ->openUrlInNewTab()
                    ->visible(fn($record) => !empty($record->sk_jabatan)),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['anggota.ranting']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJabatanSuperAdmins::route('/'),
            'create' => Pages\CreateJabatanSuperAdmin::route('/create'),
            'edit' => Pages\EditJabatanSuperAdmin::route('/{record}/edit'),
        ];
    }
}
