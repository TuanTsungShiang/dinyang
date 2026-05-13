<?php

namespace App\Filament\Resources\ApplicationAreaResource\Pages;

use App\Filament\Resources\ApplicationAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditApplicationArea extends EditRecord
{
    protected static string $resource = ApplicationAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
