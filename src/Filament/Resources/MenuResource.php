<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Forms;
use App\Models\Menu;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\RelationManagers;

class MenuResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-bars-3';

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
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
