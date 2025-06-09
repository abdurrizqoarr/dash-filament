<?php

namespace App\Filament\Anggota\Resources;

use App\Filament\Anggota\Resources\RiwayatSertifikasiResource\Pages;
use App\Filament\Anggota\Resources\RiwayatSertifikasiResource\RelationManagers;
use App\Models\Sertifikasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RiwayatSertifikasiResource extends Resource
{
    protected static ?string $model = Sertifikasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Riwayat Sertifikasi';

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

                Forms\Components\FileUpload::make('dokumen_sertifikasi')
                    ->label('Sertifikasi')
                    ->directory('sertifikasi')
                    ->maxSize(3072)
                    ->previewable(false)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                $user = Auth::guard('anggota')->id();
                return Sertifikasi::query()
                    ->where('id_anggota', $user);
            })
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download_sk')
                    ->label('Sertifikat')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => $record->dokumen_sertifikasi ? Storage::url($record->dokumen_sertifikasi) : null)
                    ->openUrlInNewTab()
                    ->visible(fn($record) => !empty($record->dokumen_sertifikasi)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListRiwayatSertifikasis::route('/'),
            'create' => Pages\CreateRiwayatSertifikasi::route('/create'),
            'edit' => Pages\EditRiwayatSertifikasi::route('/{record}/edit'),
        ];
    }
}
