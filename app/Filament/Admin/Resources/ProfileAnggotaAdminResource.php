<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProfileAnggotaAdminResource\Pages;
use App\Filament\Admin\Resources\ProfileAnggotaAdminResource\RelationManagers;
use App\Filament\Exports\ProfileExporter;
use App\Models\Anggota;
use App\Models\Profile;
use App\Models\ProfileAnggotaAdmin;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProfileAnggotaAdminResource extends Resource
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
                Forms\Components\TextInput::make('anggota.name')
                    ->label('Name')
                    ->disabled(),
                Forms\Components\TextInput::make('nomer_induk_warga')
                    ->label('Nomer Induk Warga')
                    ->disabled(),
                Forms\Components\TextInput::make('nomer_induk_kependudukan')
                    ->label('Nomer Induk Kependudukan')
                    ->disabled(),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')
                    ->disabled(),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->disabled(),
                Forms\Components\TextInput::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->disabled(),
                Forms\Components\TextInput::make('status_pernikahan')
                    ->label('Status Pernikahan')
                    ->disabled(),
                Forms\Components\Textarea::make('alamat')
                    ->label('Alamat Rumah')
                    ->disabled(),
                Forms\Components\TextInput::make('jenis_pekerjaan')
                    ->label('Jenis Pekerjaan')
                    ->disabled(),
                Forms\Components\TextInput::make('lembaga_instansi_bekerja')
                    ->label('Lembaga/Instansi Bekerja')
                    ->disabled(),
                Forms\Components\Textarea::make('alamat_lembaga_instansi_bekerja')
                    ->label('Alamat Lembaga/Instansi Bekerja')
                    ->disabled(),
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
            ->query(function () {
                $idRanting = Auth::guard('admin')->user()->id_ranting;
                return Profile::query()
                    ->whereHas('anggota', function ($query) use ($idRanting) {
                        $query->where('id_ranting', $idRanting);
                    });
            })
            ->filters([])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListProfileAnggotaAdmins::route('/'),
        ];
    }
}
