<?php

namespace App\Filament\Resources\SantriSicks\Pages;

use App\Filament\Resources\SantriSicks\SantriSickResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSantriSicks extends ListRecords
{
    protected static string $resource = SantriSickResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn() => auth()->user()->can('create santri sick')),
        ];
    }
}
