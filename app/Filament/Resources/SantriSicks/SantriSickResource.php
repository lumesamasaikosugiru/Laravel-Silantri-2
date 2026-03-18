<?php

namespace App\Filament\Resources\SantriSicks;

use App\Filament\Resources\SantriSicks\Pages\CreateSantriSick;
use App\Filament\Resources\SantriSicks\Pages\EditSantriSick;
use App\Filament\Resources\SantriSicks\Pages\ListSantriSicks;
use App\Filament\Resources\SantriSicks\Pages\ViewSantriSick;
use App\Filament\Resources\SantriSicks\Schemas\SantriSickForm;
use App\Filament\Resources\SantriSicks\Schemas\SantriSickInfolist;
use App\Filament\Resources\SantriSicks\Tables\SantriSicksTable;
use App\Models\SantriSick;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SantriSickResource extends Resource
{
    protected static ?string $model = SantriSick::class;

    protected static ?string $pluralModelLabel = 'Data Santri Sakit';
    protected static string|UnitEnum|null $navigationGroup = "Santri's Activities";

    protected static ?int $navigationSort = 2;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocument;
    protected static ?string $recordTitleAttribute = 'santri_id';

    public static function form(Schema $schema): Schema
    {
        return SantriSickForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SantriSickInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SantriSicksTable::configure($table);
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
            'index' => ListSantriSicks::route('/'),
            'create' => CreateSantriSick::route('/create'),
            'view' => ViewSantriSick::route('/{record}'),
            'edit' => EditSantriSick::route('/{record}/edit'),
        ];
    }
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
        return auth()->user()->can('create santri sick');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit santri sick');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete santri sick');
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('delete santri sick');
    }

}
