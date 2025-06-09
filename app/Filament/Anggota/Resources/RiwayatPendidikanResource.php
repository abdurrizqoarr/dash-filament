<?php

namespace App\Filament\Anggota\Resources;

use App\Filament\Anggota\Resources\RiwayatPendidikanResource\Pages;
use App\Filament\Anggota\Resources\RiwayatPendidikanResource\RelationManagers;
use App\Models\RiwayatPendidikan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RiwayatPendidikanResource extends Resource
{
    protected static ?string $model = RiwayatPendidikan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Riwayat Pendidikan';

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
                    ->nullable(),

                Forms\Components\FileUpload::make('ijazah')
                    ->label('Ijazah')
                    ->directory('ijazah')
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
            ->query(function () {
                $user = Auth::guard('anggota')->id();
                return RiwayatPendidikan::query()
                    ->where('id_anggota', $user);
            })
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download_sk')
                    ->label('Ijazah')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => $record->ijazah
                        ? route('download.document', ['filename' => $record->ijazah])
                        : null)
                    ->openUrlInNewTab()
                    ->visible(fn($record) => !empty($record->ijazah)),
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
            'index' => Pages\ListRiwayatPendidikans::route('/'),
            'create' => Pages\CreateRiwayatPendidikan::route('/create'),
            'edit' => Pages\EditRiwayatPendidikan::route('/{record}/edit'),
        ];
    }
}
