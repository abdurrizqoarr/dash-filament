<?php

namespace App\Filament\Anggota\Resources;

use App\Filament\Anggota\Resources\RiwayatPelatihanResource\Pages;
use App\Filament\Anggota\Resources\RiwayatPelatihanResource\RelationManagers;
use App\Models\RiwayatLatihan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RiwayatPelatihanResource extends Resource
{
    protected static ?string $model = RiwayatLatihan::class;

    protected static ?string $navigationGroup = 'KEANGGOTAAN';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Riwayat Latihan PSHT';
    protected static ?int $navigationSort = 3;

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
                    ->minLength(2)
                    ->maxLength(240)
                    ->required(),
                Forms\Components\TextInput::make('penyelenggara')
                    ->label('Penyelenggara')
                    ->minLength(2)
                    ->maxLength(240)
                    ->required(),
                Forms\Components\FileUpload::make('sertifikat')
                    ->label('Sertifikat')
                    ->directory('sertifikat-latihan')
                    ->maxSize(3072)
                    ->previewable(false)
                    ->nullable()
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->helperText('Unggah file gambar atau PDF, maksimal 3MB.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            ->query(function () {
                $user = Auth::guard('anggota')->id();
                return RiwayatLatihan::query()
                    ->where('id_anggota', $user);
            })
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download_sk')
                    ->label('Sertifikat')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => $record->sertifikat
                        ? route('download.document', ['filename' => $record->sertifikat])
                        : null)
                    ->openUrlInNewTab()
                    ->visible(fn($record) => !empty($record->sertifikat)),
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
            'index' => Pages\ListRiwayatPelatihans::route('/'),
            'create' => Pages\CreateRiwayatPelatihan::route('/create'),
            'edit' => Pages\EditRiwayatPelatihan::route('/{record}/edit'),
        ];
    }
}
