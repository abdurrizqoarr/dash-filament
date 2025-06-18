<?php

namespace App\Filament\Anggota\Resources;

use App\Filament\Anggota\Resources\PrestasiResource\Pages;
use App\Filament\Anggota\Resources\PrestasiResource\RelationManagers;
use App\Models\Prestasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrestasiResource extends Resource
{
    protected static ?string $model = Prestasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Prestasi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('prestasi')
                    ->label('Prestasi')
                    ->required()
                    ->minLength(2)
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
                    ->required(),
                Forms\Components\FileUpload::make('sertifikat_prestasi')
                    ->label('Sertifikat Prestasi')
                    ->directory('sertifikat-prestasi')
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
                Tables\Columns\TextColumn::make('prestasi')
                    ->label('Prestasi'),
                Tables\Columns\TextColumn::make('tahun')
                    ->label('Tahun')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tingkat')
                    ->label('Tingkat'),
            ])
            ->query(function () {
                $user = Auth::guard('anggota')->id();
                return Prestasi::query()
                    ->where('id_anggota', $user);
            })
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download_sk')
                    ->label('Sertifikat')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => $record->sertifikat_prestasi
                        ? route('download.document', ['filename' =>  $record->sertifikat_prestasi])
                        : null)
                    ->openUrlInNewTab()
                    ->visible(fn($record) => !empty($record->sertifikat_prestasi)),
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
            'index' => Pages\ListPrestasis::route('/'),
            'create' => Pages\CreatePrestasi::route('/create'),
            'edit' => Pages\EditPrestasi::route('/{record}/edit'),
        ];
    }
}
