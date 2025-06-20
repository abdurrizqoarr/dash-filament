<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\JabatanAdminResource\Pages;
use App\Filament\Admin\Resources\JabatanAdminResource\RelationManagers;
use App\Filament\Exports\JabatanExporter;
use App\Models\Jabatan;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JabatanAdminResource extends Resource
{
    protected static ?string $model = Jabatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
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
    protected static ?string $navigationGroup = 'KEANGGOTAAN';
    protected static ?int $navigationSort = 2;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jabatan')
                    ->label('Jabatan')
                    ->minLength(2)
                    ->required()
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
                Tables\Columns\TextColumn::make('anggota.name')->label('Nama Anggota')->searchable(),
                Tables\Columns\TextColumn::make('jabatan')->label('Jabatan'),
                Tables\Columns\TextColumn::make('lokasi_jabatan')->label('Tingkat')->sortable(),
                Tables\Columns\TextColumn::make('mulai_jabatan')->label('Mulai Jabatan')->dateTime('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('akhir_jabatan')->label('Akhir Jabatan')->dateTime('d M Y')->sortable(),
            ])
            ->query(function () {
                $idRanting = Auth::guard('admin')->user()->id_ranting;
                return Jabatan::query()
                    ->whereHas('anggota', function ($query) use ($idRanting) {
                        $query->where('id_ranting', $idRanting);
                    });
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
            'index' => Pages\ListJabatanAdmins::route('/'),
            'edit' => Pages\EditJabatanAdmin::route('/{record}/edit'),
        ];
    }
}
