<?php

namespace App\Filament\Anggota\Resources;

use App\Filament\Anggota\Resources\RiwayatPengesahanResource\Pages;
use App\Filament\Anggota\Resources\RiwayatPengesahanResource\RelationManagers;
use App\Models\RiwayatPengesahan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RiwayatPengesahanResource extends Resource
{
    protected static ?string $model = RiwayatPengesahan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Riwayat Pengesahan';

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

                Forms\Components\FileUpload::make('sertifikat_pengesahan')
                    ->label('Sertifikat Pengesahan')
                    ->directory('sertifikat-pengesahan')
                    ->maxSize(3072)
                    ->acceptedFileTypes(['application/pdf'])
                    ->helperText('Hanya file PDF yang diperbolehkan')
                    ->previewable(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
                $user = Auth::guard('anggota')->id();
                return RiwayatPengesahan::query()
                    ->where('id_anggota', $user);
            })
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download_sk')
                    ->label('Sertifikat')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => $record->sertifikat_pengesahan ? Storage::url($record->sertifikat_pengesahan) : null)
                    ->openUrlInNewTab()
                    ->visible(fn($record) => !empty($record->sertifikat_pengesahan)),
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
            'index' => Pages\ListRiwayatPengesahans::route('/'),
            'create' => Pages\CreateRiwayatPengesahan::route('/create'),
            'edit' => Pages\EditRiwayatPengesahan::route('/{record}/edit'),
        ];
    }
}
