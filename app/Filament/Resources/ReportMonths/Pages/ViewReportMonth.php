<?php

namespace App\Filament\Resources\ReportMonths\Pages;

use App\Filament\Resources\ReportMonths\ReportMonthResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use App\Services\ReportMonthService;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;

class ViewReportMonth extends ViewRecord
{
    protected static string $resource = ReportMonthResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),

            Action::make('export_pdf')
                ->label('Export PDF')
                ->icon(Heroicon::DocumentArrowDown)
                ->color(Color::Teal)
                ->visible(
                    fn() =>
                    $this->record->status === 'divalidasi' &&
                    $this->record->reportMonthSummary !== null
                )
                ->url(fn() => route('report-months.pdf', $this->record))
                ->openUrlInNewTab(), // ✅ buka di tab baru
        ];
    }
}
