<?php

namespace App\Filament\Resources\SantriPermissions\Pages;

use App\Filament\Resources\SantriPermissions\SantriPermissionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSantriPermission extends ViewRecord
{
    protected static string $resource = SantriPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
