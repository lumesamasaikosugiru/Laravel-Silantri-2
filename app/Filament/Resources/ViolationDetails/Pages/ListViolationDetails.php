<?php

namespace App\Filament\Resources\ViolationDetails\Pages;

use App\Filament\Resources\ViolationDetails\ViolationDetailResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListViolationDetails extends ListRecords
{
    protected static string $resource = ViolationDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
