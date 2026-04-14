<?php

namespace App\Filament\Resources\ViolationDetails\Pages;

use App\Filament\Resources\ViolationDetails\ViolationDetailResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditViolationDetail extends EditRecord
{
    protected static string $resource = ViolationDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
