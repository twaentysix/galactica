<?php

namespace App\Filament\Resources\GalaxiesResource\Pages;

use App\Filament\Resources\GalaxiesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGalaxies extends ListRecords
{
    protected static string $resource = GalaxiesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
