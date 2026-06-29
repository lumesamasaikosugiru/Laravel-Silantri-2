<?php

namespace App\Filament\Resources\WaliSantris\Pages;

use App\Filament\Resources\WaliSantris\WaliSantriResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWaliSantris extends ListRecords
{
    protected static string $resource = WaliSantriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
