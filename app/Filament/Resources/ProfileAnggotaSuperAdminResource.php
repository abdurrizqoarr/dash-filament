<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ProfileExporter;
use App\Filament\Resources\ProfileAnggotaSuperAdminResource\Pages;
use App\Filament\Resources\ProfileAnggotaSuperAdminResource\RelationManagers;
use App\Models\Profile;
use App\Models\ProfileAnggotaSuperAdmin;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfileAnggotaSuperAdminResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Profile Anggota';

    protected static ?string $modelLabel = 'Profile Anggota';
    protected static ?string $pluralModelLabel = 'Profile Anggota';

    public static function getLabel(): ?string
    {
        return 'Profile Anggota';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Profile Anggota';
    }
    protected static ?string $navigationGroup = 'Anggota';

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Anggota')
                    ->schema([
                        Forms\Components\TextInput::make('nama_anggota')
                            ->label('Nama Anggota'),
                        Forms\Components\TextInput::make('nama_ranting')
                            ->label('Nama Ranting'),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Detail Profile Anggota')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('nomer_induk_warga')
                                ->label('Nomer Induk Warga')
                                ->required()
                                ->unique(ignoreRecord: true),

                            Forms\Components\TextInput::make('nomer_induk_kependudukan')
                                ->label('Nomer Induk Kependudukan')
                                ->nullable(),

                            Forms\Components\TextInput::make('tempat_lahir')
                                ->label('Tempat Lahir')
                                ->required(),

                            Forms\Components\DatePicker::make('tanggal_lahir')
                                ->label('Tanggal Lahir')
                                ->required(),

                            Forms\Components\Select::make('jenis_kelamin')
                                ->label('Jenis Kelamin')
                                ->options([
                                    'Pria' => 'Pria',
                                    'Perempuan' => 'Perempuan',
                                ])
                                ->required(),

                            Forms\Components\Select::make('status_pernikahan')
                                ->label('Status Pernikahan')
                                ->options([
                                    'Belum Kawin' => 'Belum Kawin',
                                    'Kawin' => 'Kawin',
                                    'Duda' => 'Duda',
                                    'Janda' => 'Janda',
                                ])
                                ->required(),

                            Forms\Components\Textarea::make('alamat')
                                ->label('Alamat Rumah')
                                ->required()
                                ->columnSpanFull(),
                        ]),
                    ])
                    ->columns(2),
                Forms\Components\Section::make('Pekerjaan')
                    ->schema([
                        Forms\Components\Select::make('jenis_pekerjaan')
                            ->label('Jenis Pekerjaan')
                            ->options([
                                'Pedagang' => 'Pedagang',
                                'Wiraswasta' => 'Wiraswasta',
                                'Swasta' => 'Swasta',
                                'Karyawan Perusahaan' => 'Karyawan Perusahaan',
                                'ASN' => 'ASN',
                                'TNI' => 'TNI',
                                'POLRI' => 'POLRI',
                                'Lainnya' => 'Lainnya',
                            ])
                            ->nullable(),

                        Forms\Components\TextInput::make('lembaga_instansi_bekerja')
                            ->label('Lembaga/Instansi Bekerja')
                            ->nullable(),

                        Forms\Components\Textarea::make('alamat_lembaga_instansi_bekerja')
                            ->label('Alamat Lembaga/Instansi Bekerja')
                            ->nullable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(ProfileExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('anggota.name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('anggota.ranting.nama_ranting')->label('Ranting')->searchable(),
                Tables\Columns\TextColumn::make('nomer_induk_warga')
                    ->label('Nomer Induk Warga')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('nomer_induk_kependudukan')
                    ->label('Nomer Induk Kependudukan')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('Tempat Lahir'),
                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->limit(50),
                Tables\Columns\TextColumn::make('status_pernikahan')
                    ->label('Status Pernikahan')
                    ->limit(50),
                Tables\Columns\TextColumn::make('alamat')
                    ->label('Alamat Rumah'),
                Tables\Columns\TextColumn::make('jenis_pekerjaan')
                    ->label('Jenis Pekerjaan'),
                Tables\Columns\TextColumn::make('lembaga_instansi_bekerja')
                    ->label('Lembaga/Instansi Bekerja'),
                Tables\Columns\TextColumn::make('alamat_lembaga_instansi_bekerja')
                    ->label('Alamat Lembaga/Instansi Bekerja'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('ranting')
                    ->label('Ranting')
                    ->relationship('anggota.ranting', 'nama_ranting')
                    ->searchable()
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['anggota.ranting']);
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
            'index' => Pages\ListProfileAnggotaSuperAdmins::route('/'),
            'view' => Pages\DetailProfile::route('/{record}'),
        ];
    }
}
