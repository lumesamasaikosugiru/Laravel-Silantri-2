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
            CreateAction::make()
                ->visible(fn() => auth()->user()->can('create report month'))
            // ->disabled(fn() => now()->day > 28)
            // ->tooltip(fn() => now()->day !== 28 ? 'Hanya bisa dibuat tanggal 28' : null),
        ];
    }
}
