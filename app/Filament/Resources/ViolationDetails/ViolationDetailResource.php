<?php

namespace App\Filament\Resources\ViolationDetails;

use App\Filament\Resources\ViolationDetails\Pages\CreateViolationDetail;
use App\Filament\Resources\ViolationDetails\Pages\EditViolationDetail;
use App\Filament\Resources\ViolationDetails\Pages\ListViolationDetails;
use App\Filament\Resources\ViolationDetails\Pages\ViewViolationDetail;
use App\Filament\Resources\ViolationDetails\Schemas\ViolationDetailForm;
use App\Filament\Resources\ViolationDetails\Schemas\ViolationDetailInfolist;
use App\Filament\Resources\ViolationDetails\Tables\ViolationDetailsTable;
use App\Models\ViolationDetail;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ViolationDetailResource extends Resource
{
    protected static ?string $model = ViolationDetail::class;

    protected static ?string $pluralModelLabel = 'Data Pelanggaran';
    protected static string|UnitEnum|null $navigationGroup = "Santri's Activities";

    protected static ?int $navigationSort = 5;



    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedExclamationCircle;
    protected static ?string $recordTitleAttribute = 'santri_id';

    public static function form(Schema $schema): Schema
    {
        return ViolationDetailForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ViolationDetailInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ViolationDetailsTable::configure($table);
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
            'index' => ListViolationDetails::route('/'),
            'create' => CreateViolationDetail::route('/create'),
            'view' => ViewViolationDetail::route('/{record}'),
            'edit' => EditViolationDetail::route('/{record}/edit'),
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
        return auth()->user()->can('create santri violation');
    }

    public static function canEdit($record): bool
    {
        return auth()->user()->can('edit santri violation');
    }

    public static function canDelete($record): bool
    {
        return auth()->user()->can('delete santri violation');
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()->can('delete santri violation');
    }

}
