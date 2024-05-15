<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlanetsResource\Pages;
use App\Filament\Resources\PlanetsResource\RelationManagers;
use App\Models\Planets;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlanetsResource extends Resource
{
    protected static ?string $model = Planets::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('galaxy.name') // Access the galaxy name through the relationship
                    ->label('Galaxy'), // Optionally set a custom label for the column
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPlanets::route('/'),
            'create' => Pages\CreatePlanets::route('/create'),
            'edit' => Pages\EditPlanets::route('/{record}/edit'),
        ];
    }
}
