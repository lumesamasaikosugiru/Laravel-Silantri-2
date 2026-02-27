<?php

namespace App\Filament\Resources\Violations;

use App\Filament\Resources\Violations\Pages\CreateViolation;
use App\Filament\Resources\Violations\Pages\EditViolation;
use App\Filament\Resources\Violations\Pages\ListViolations;
use App\Filament\Resources\Violations\Pages\ViewViolation;
use App\Filament\Resources\Violations\Schemas\ViolationForm;
use App\Filament\Resources\Violations\Schemas\ViolationInfolist;
use App\Filament\Resources\Violations\Tables\ViolationsTable;
use App\Models\Violation;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ViolationResource extends Resource
{
    protected static ?string $model = Violation::class;

    protected static ?string $pluralModelLabel = 'Pelanggaran';
    protected static string|UnitEnum|null $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 6;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldExclamation;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return ViolationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ViolationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ViolationsTable::configure($table);
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
            'index' => ListViolations::route('/'),
            'create' => CreateViolation::route('/create'),
            'view' => ViewViolation::route('/{record}'),
            'edit' => EditViolation::route('/{record}/edit'),
        ];
    }
}
