<?php

namespace App\Filament\Resources\ReportMonths\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReportMonthItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'reportMonthItems';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('santri_id')
                    ->relationship('santri', 'name')
                    ->required(),
                Select::make('type')
                    ->options(['sakit' => 'Sakit', 'ijin' => 'Ijin', 'pelanggaran' => 'Pelanggaran'])
                    ->required(),
                Select::make('source_table')
                    ->options([
                        'santri_sicks' => 'Santri sicks',
                        'santri_permissions' => 'Santri permissions',
                        'violation_details' => 'Violation details',
                    ])
                    ->required(),
                TextInput::make('source_id')
                    ->required()
                    ->numeric(),
                DatePicker::make('date')
                    ->required(),
                Textarea::make('summary_text')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('santri.name')
                    ->label('Santri'),
                TextEntry::make('type')
                    ->badge(),
                TextEntry::make('source_table')
                    ->badge(),
                TextEntry::make('source_id')
                    ->numeric(),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('summary_text')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('santri')
            ->columns([
                TextColumn::make('santri.name')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('source_table')
                    ->badge(),
                TextColumn::make('source_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DissociateAction::make()
                    ->visible(fn() => auth()->user()->can('delete report month')),
                DeleteAction::make()
                    ->visible(fn() => auth()->user()->can('delete report month')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
