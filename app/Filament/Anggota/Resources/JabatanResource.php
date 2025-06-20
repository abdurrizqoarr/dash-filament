<?php

namespace App\Filament\Anggota\Resources;

use App\Filament\Anggota\Resources\JabatanResource\Pages;
use App\Filament\Anggota\Resources\JabatanResource\RelationManagers;
use App\Models\Jabatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JabatanResource extends Resource
{
    protected static ?string $model = Jabatan::class;

    protected static ?string $navigationGroup = 'KEANGGOTAAN';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationLabel = 'Jabatan Dalam PSHT';

    protected static ?string $modelLabel = 'Jabatan Dalam PSHT';
    protected static ?string $pluralModelLabel = 'Jabatan Dalam PSHT';

    public static function getLabel(): ?string
    {
        return 'Jabatan Dalam PSHT';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Jabatan Dalam PSHT';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jabatan')
                    ->label('Jabatan')
                    ->required()
                    ->minLength(2)
                    ->maxLength(255),
                Forms\Components\Select::make('lokasi_jabatan')
                    ->label('Tingkat')
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
            ->columns([
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),
                Tables\Columns\TextColumn::make('lokasi_jabatan')->label('Tingkat')->sortable(),
                Tables\Columns\TextColumn::make('mulai_jabatan')->label('Mulai Jabatan')->dateTime('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('akhir_jabatan')->label('Akhir Jabatan')->dateTime('d M Y')->sortable(),
            ])
            ->query(function () {
                $user = Auth::guard('anggota')->id();
                return Jabatan::query()
                    ->where('id_anggota', $user);
            })
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download_sk')
                    ->label('Download SK')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => $record->sk_jabatan
                        ? route('download.document', ['filename' => $record->sk_jabatan])
                        : null)
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJabatans::route('/'),
            'create' => Pages\CreateJabatan::route('/create'),
            'edit' => Pages\EditJabatan::route('/{record}/edit'),
        ];
    }
}
