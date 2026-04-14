<?php

namespace App\Filament\Resources\Santris;

use App\Filament\Resources\Santris\Pages\CreateSantri;
use App\Filament\Resources\Santris\Pages\EditSantri;
use App\Filament\Resources\Santris\Pages\ListSantris;
use App\Filament\Resources\Santris\Pages\ViewSantri;
use App\Filament\Resources\Santris\Schemas\SantriForm;
use App\Filament\Resources\Santris\Schemas\SantriInfolist;
use App\Filament\Resources\Santris\Tables\SantrisTable;
use App\Models\Santri;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SantriResource extends Resource
{
    protected static ?string $model = Santri::class;

    protected static ?string $pluralModelLabel = 'Santri';
    protected static string|UnitEnum|null $navigationGroup = "Santri's Activities";
    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SantriForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SantriInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SantrisTable::configure($table);
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
            'index' => ListSantris::route('/'),
            'create' => CreateSantri::route('/create'),
            'view' => ViewSantri::route('/{record}'),
            'edit' => EditSantri::route('/{record}/edit'),
        ];
    }

    //atur permission Resource/menu Filament
    public static function canViewAny(): bool
    {
        return auth()->user()->hasAnyRole([
            'superadmin',
            'admin',
            'staff',
            'kepala_pengasuhan',
        ]);
    }

    public static function canView($record): bool
    {
        return auth()->user()->hasAnyRole([
            'superadmin',
            'admin',
            'staff',
            'kepala_pengasuhan',
        ]);
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('manage santri');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('manage santri');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('manage santri');
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('manage santri');
    }

}

