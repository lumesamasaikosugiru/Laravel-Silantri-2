<?php

namespace App\Filament\Resources\WaliSantris;

use App\Filament\Resources\WaliSantris\Pages\CreateWaliSantri;
use App\Filament\Resources\WaliSantris\Pages\EditWaliSantri;
use App\Filament\Resources\WaliSantris\Pages\ListWaliSantris;
use App\Filament\Resources\WaliSantris\Pages\ViewWaliSantri;
use App\Filament\Resources\WaliSantris\Schemas\WaliSantriForm;
use App\Filament\Resources\WaliSantris\Schemas\WaliSantriInfolist;
use App\Filament\Resources\WaliSantris\Tables\WaliSantrisTable;
use App\Models\WaliSantri;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WaliSantriResource extends Resource
{
    protected static ?string $model = WaliSantri::class;

    protected static ?string $pluralModelLabel = 'Wali Santri';
    protected static string|UnitEnum|null $navigationGroup = "Santri's Activities";
    protected static ?int $navigationSort = 2;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return WaliSantriForm::configure($schema);
    }
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['santris']);
    }
    public static function infolist(Schema $schema): Schema
    {
        return WaliSantriInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WaliSantrisTable::configure($table);
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
            'index' => ListWaliSantris::route('/'),
            'create' => CreateWaliSantri::route('/create'),
            'view' => ViewWaliSantri::route('/{record}'),
            'edit' => EditWaliSantri::route('/{record}/edit'),
        ];
    }
}
