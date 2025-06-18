<?php

namespace App\Filament\Resources;

use App\Filament\Exports\RantingExporter;
use App\Filament\Resources\RantingResource\Pages;
use App\Filament\Resources\RantingResource\RelationManagers;
use App\Models\Ranting;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RantingResource extends Resource
{
    protected static ?string $model = Ranting::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Ranting';

    protected static ?string $modelLabel = 'Ranting';
    protected static ?string $pluralModelLabel = 'Ranting';

    public static function getLabel(): ?string
    {
        return 'Ranting';
    }

    public static function getPluralLabel(): ?string
    {
        return 'Ranting';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_ranting')
                    ->label('Nama Ranting')
                    ->required()
                    ->minLength(2)
                    ->maxLength(240)
                    ->unique(ignoreRecord: true)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(RantingExporter::class)
                    ->formats([
                        ExportFormat::Xlsx,
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('nama_ranting')
                    ->label('Nama Ranting')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
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
            'index' => Pages\ListRantings::route('/'),
            'create' => Pages\CreateRanting::route('/create'),
            'edit' => Pages\EditRanting::route('/{record}/edit'),
        ];
    }
}
