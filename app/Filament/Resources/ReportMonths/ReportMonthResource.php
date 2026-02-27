<?php

namespace App\Filament\Resources\ReportMonths;

use App\Filament\Resources\ReportMonths\Pages\CreateReportMonth;
use App\Filament\Resources\ReportMonths\Pages\EditReportMonth;
use App\Filament\Resources\ReportMonths\Pages\ListReportMonths;
use App\Filament\Resources\ReportMonths\Pages\ViewReportMonth;
use App\Filament\Resources\ReportMonths\Schemas\ReportMonthForm;
use App\Filament\Resources\ReportMonths\Schemas\ReportMonthInfolist;
use App\Filament\Resources\ReportMonths\Tables\ReportMonthsTable;
use App\Models\ReportMonth;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ReportMonthResource extends Resource
{
    protected static ?string $model = ReportMonth::class;

    protected static ?string $pluralModelLabel = 'Laporan Bulanan';
    protected static string|UnitEnum|null $navigationGroup = 'Reports';
    protected static ?int $navigationSort = 7;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static ?string $recordTitleAttribute = 'month';

    public static function form(Schema $schema): Schema
    {
        return ReportMonthForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ReportMonthInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReportMonthsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReportMonths::route('/'),
            'create' => CreateReportMonth::route('/create'),
            'view' => ViewReportMonth::route('/{record}'),
            'edit' => EditReportMonth::route('/{record}/edit'),
        ];
    }
}
