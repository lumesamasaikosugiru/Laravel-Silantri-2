<?php

namespace App\Filament\Resources\ViolationDetails\Pages;

use App\Filament\Resources\ViolationDetails\ViolationDetailResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewViolationDetail extends ViewRecord
{
    protected static string $resource = ViolationDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
