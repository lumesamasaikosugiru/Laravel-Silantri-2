<?php

namespace App\Filament\Resources\WaliSantris\Pages;

use App\Filament\Resources\WaliSantris\WaliSantriResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewWaliSantri extends ViewRecord
{
    protected static string $resource = WaliSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
