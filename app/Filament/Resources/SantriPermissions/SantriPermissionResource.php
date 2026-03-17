<?php

namespace App\Filament\Resources\SantriPermissions;

use App\Filament\Resources\SantriPermissions\Pages\CreateSantriPermission;
use App\Filament\Resources\SantriPermissions\Pages\EditSantriPermission;
use App\Filament\Resources\SantriPermissions\Pages\ListSantriPermissions;
use App\Filament\Resources\SantriPermissions\Pages\ViewSantriPermission;
use App\Filament\Resources\SantriPermissions\Schemas\SantriPermissionForm;
use App\Filament\Resources\SantriPermissions\Schemas\SantriPermissionInfolist;
use App\Filament\Resources\SantriPermissions\Tables\SantriPermissionsTable;
use App\Models\SantriPermission;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SantriPermissionResource extends Resource
{
    protected static ?string $model = SantriPermission::class;
    protected static ?string $pluralModelLabel = 'Data Perizinan Santri';
    protected static string|UnitEnum|null $navigationGroup = "Santri's Activities";

    protected static ?int $navigationSort = 3;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboard;
    protected static ?string $recordTitleAttribute = 'santri_id';

    public static function form(Schema $schema): Schema
    {
        return SantriPermissionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SantriPermissionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SantriPermissionsTable::configure($table);
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
            'index' => ListSantriPermissions::route('/'),
            'create' => CreateSantriPermission::route('/create'),
            'view' => ViewSantriPermission::route('/{record}'),
            'edit' => EditSantriPermission::route('/{record}/edit'),
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
