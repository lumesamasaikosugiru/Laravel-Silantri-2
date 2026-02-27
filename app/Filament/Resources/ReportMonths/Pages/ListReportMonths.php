<?php

namespace App\Filament\Resources\ReportMonths\Pages;

use App\Filament\Resources\ReportMonths\ReportMonthResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReportMonths extends ListRecords
{
    protected static string $resource = ReportMonthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
