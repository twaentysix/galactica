<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BasesResource\Pages;
use App\Filament\Resources\BasesResource\RelationManagers;
use App\Models\Bases;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BasesResource extends Resource
{
    protected static ?string $model = Bases::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('level')
                    ->numeric(),
                Forms\Components\Fieldset::make('Resources')
                    ->relationship('resources')
                    ->schema([
                        Forms\Components\TextInput::make('metal')->label('Metal')->numeric(),
                        Forms\Components\TextInput::make('gas')->label('Gas')->numeric(),
                        Forms\Components\TextInput::make('gems')->label('Gems')->numeric(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('level')
                    ->numeric(),
                Tables\Columns\TextColumn::make('resources.metal')
                    ->numeric()
                    ->label('Metal'),
                Tables\Columns\TextColumn::make('resources.gas')
                    ->numeric()
                    ->label('Fuel'),
                Tables\Columns\TextColumn::make('resources.gems')
                    ->numeric()
                    ->label('Gems'),
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
            'index' => Pages\ListBases::route('/'),
            'create' => Pages\CreateBases::route('/create'),
            'edit' => Pages\EditBases::route('/{record}/edit'),
        ];
    }
}
