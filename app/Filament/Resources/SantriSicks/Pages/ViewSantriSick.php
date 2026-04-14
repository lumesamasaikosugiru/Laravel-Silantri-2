<?php

namespace App\Filament\Resources\SantriSicks\Pages;

use App\Filament\Resources\SantriSicks\SantriSickResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSantriSick extends ViewRecord
{
    protected static string $resource = SantriSickResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
