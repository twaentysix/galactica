<?php

namespace App\Filament\Resources\PlanetsResource\Pages;

use App\Filament\Resources\PlanetsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlanets extends ListRecords
{
    protected static string $resource = PlanetsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
