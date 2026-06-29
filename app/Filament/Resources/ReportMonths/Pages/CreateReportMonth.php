<?php

namespace App\Filament\Resources\ReportMonths\Pages;

use App\Filament\Resources\ReportMonths\ReportMonthResource;
use App\Services\ReportMonthService;
use Filament\Resources\Pages\CreateRecord;



class CreateReportMonth extends CreateRecord
{
    protected static string $resource = ReportMonthResource::class;
    protected function afterCreate(): void
    {
        app(ReportMonthService::class)->generate($this->record);
    }
}
