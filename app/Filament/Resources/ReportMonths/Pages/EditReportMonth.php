<?php

namespace App\Filament\Resources\ReportMonths\Pages;

use App\Filament\Resources\ReportMonths\ReportMonthResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditReportMonth extends EditRecord
{
    protected static string $resource = ReportMonthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->visible(fn() => auth()->user()->can('delete report month')),
        ];
    }
}
