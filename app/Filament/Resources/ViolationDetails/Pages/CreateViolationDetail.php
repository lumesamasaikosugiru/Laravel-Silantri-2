<?php

namespace App\Filament\Resources\ViolationDetails\Pages;

use App\Filament\Resources\ViolationDetails\ViolationDetailResource;
use Filament\Resources\Pages\CreateRecord;

class CreateViolationDetail extends CreateRecord
{
    protected static string $resource = ViolationDetailResource::class;
}
