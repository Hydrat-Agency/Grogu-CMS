<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Hydrat\GroguCMS\Models\Menu;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\RelationManagers\ItemsRelationManager;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages\ListMenus;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages\CreateMenu;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages\ViewMenu;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages\EditMenu;
use Filament\Forms;
use Filament\Infolists;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\RelationManagers;

class MenuResource extends Resource
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-bars-3';

    protected static bool $isDiscovered = false;

    protected static ?int $navigationSort = 500;

    public static function getNavigationGroup(): ?string
    {
        return __('Configuration');
    }

    public static function getModel(): string
    {
        return config('grogu-cms.models.menu') ?? Menu::class;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Select::make('location')
                    ->required()
                    ->options(
                        GroguCMS::menuLocations()->toArray()
                    ),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('title'),
                TextEntry::make('location')
                    ->formatStateUsing(fn ($state) => GroguCMS::menuLocations()->get($state, $state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        $locations = GroguCMS::menuLocations();

        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),

                TextColumn::make('location')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => $locations->get($state, $state)),

                TextColumn::make('items_count')
                    ->counts('items')
                    ->toggleable(isToggledHiddenByDefault: false),

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
            ->recordActions([
                ViewAction::make()->iconSoftButton('heroicon-o-eye'),
                EditAction::make()->iconSoftButton('heroicon-o-pencil-square'),
                DeleteAction::make()->iconSoftButton('heroicon-o-trash'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMenus::route('/'),
            'create' => CreateMenu::route('/create'),
            'view' => ViewMenu::route('/{record}'),
            'edit' => EditMenu::route('/{record}/edit'),
        ];
    }
}
