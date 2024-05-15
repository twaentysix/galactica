<?php

namespace App\Filament\Resources\BasesResource\Pages;

use App\Filament\Resources\BasesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBases extends EditRecord
{
    protected static string $resource = BasesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
