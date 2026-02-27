<?php

namespace App\Filament\Resources\SantriPermissions\Pages;

use App\Filament\Resources\SantriPermissions\SantriPermissionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSantriPermission extends EditRecord
{
    protected static string $resource = SantriPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
