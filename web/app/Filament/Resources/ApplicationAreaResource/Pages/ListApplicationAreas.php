<?php

namespace App\Filament\Resources\ApplicationAreaResource\Pages;

use App\Filament\Resources\ApplicationAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListApplicationAreas extends ListRecords
{
    protected static string $resource = ApplicationAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
