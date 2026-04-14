<?php

namespace App\Filament\Resources\SantriSicks\Pages;

use App\Filament\Resources\SantriSicks\SantriSickResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSantriSick extends EditRecord
{
    protected static string $resource = SantriSickResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
