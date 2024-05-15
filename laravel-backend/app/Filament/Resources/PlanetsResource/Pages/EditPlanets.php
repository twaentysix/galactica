<?php

namespace App\Filament\Resources\PlanetsResource\Pages;

use App\Filament\Resources\PlanetsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlanets extends EditRecord
{
    protected static string $resource = PlanetsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
