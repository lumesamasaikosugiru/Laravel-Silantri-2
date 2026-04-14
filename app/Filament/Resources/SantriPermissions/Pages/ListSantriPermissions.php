<?php

namespace App\Filament\Resources\SantriPermissions\Pages;

use App\Filament\Resources\SantriPermissions\SantriPermissionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSantriPermissions extends ListRecords
{
    protected static string $resource = SantriPermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn() => auth()->user()->can('create santri permission')),
        ];
    }
}
