<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\RelationManagers;

class MenuResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

    protected static bool $isDiscovered = false;

    public static function getNavigationGroup(): ?string
    {
        return __('Configuration');
    }

    public static function getModel(): string
    {
        return config('grogu-cms.models.menu') ?? \Hydrat\GroguCMS\Models\Menu::class;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('location')
                    ->required()
                    ->options(
                        GroguCMS::menuLocations()->toArray()
                    ),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('title'),
                Infolists\Components\TextEntry::make('location')
                    ->formatStateUsing(fn ($state) => GroguCMS::menuLocations()->get($state, $state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        $locations = GroguCMS::menuLocations();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => $locations->get($state, $state)),

                Tables\Columns\TextColumn::make('items_count')
                    ->counts('items')
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconSoftButton('heroicon-o-eye'),
                Tables\Actions\EditAction::make()->iconSoftButton('heroicon-o-pencil-square'),
                Tables\Actions\DeleteAction::make()->iconSoftButton('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'view' => Pages\ViewMenu::route('/{record}'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
