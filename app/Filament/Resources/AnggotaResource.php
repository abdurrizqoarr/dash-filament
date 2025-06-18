<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnggotaResource\Pages;
use App\Filament\Resources\AnggotaResource\RelationManagers;
use App\Models\Anggota;
use App\Models\Ranting;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnggotaResource extends Resource
{
    protected static ?string $model = Anggota::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Anggota';
    protected static ?string $pluralModelLabel = 'Anggota';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(240)
                    ->unique(ignoreRecord: true),
                TextInput::make('username')
                    ->label('Username')
                    ->required()
                    ->maxLength(240)
                    ->unique(ignoreRecord: true),
                Select::make('id_ranting')
                    ->required()
                    ->label('Ranting')
                    ->options(Ranting::all()->pluck('nama_ranting', 'id'))
                    ->searchable(),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->minLength(6)
                    ->maxLength(240)
                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('username')
                    ->label('Username')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('ranting.nama_ranting')
                    ->label('Ranting')
                    ->sortable()
                    ->limit(50),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('ranting')
                    ->label('Ranting')
                    ->relationship('ranting', 'ranting.nama_ranting')
                    ->searchable()
            ])
            ->actions([
                EditAction::make(),
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
            ->with(['ranting']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnggotas::route('/'),
            'edit' => Pages\EditAnggota::route('/{record}/edit'),
            'create' => Pages\CreateAnggota::route('/create'),
        ];
    }
}
