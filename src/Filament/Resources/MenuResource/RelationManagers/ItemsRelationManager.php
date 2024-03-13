<?php

namespace Hydrat\GroguCMS\Filament\Resources\MenuResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Hydrat\GroguCMS\Models\MenuItem;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\RelationManagers\RelationManager;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function reorderTable(array $order): void
    {
        $model = config('grogu-cms.models.menu_item', MenuItem::class);

        $model::setNewOrder($order);
    }

    public function form(Form $form): Form
    {
        $blueprints = GroguCMS::getBlueprints();

        $blueprintsTypes = $blueprints->filter->showInMenus()->mapWithKeys(
            fn ($blueprint) => [$blueprint->model() => $blueprint->modelSingularLabel()]
        );

        return $form
            ->reorderable('order')
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),

                Forms\Components\Select::make('linkeable_type')
                    ->label('Link type')
                    ->required()
                    ->live()
                    ->default('url')
                    ->options([
                        'url' => 'URL',
                        ...$blueprintsTypes,
                    ]),

                Forms\Components\TextInput::make('url')
                    ->maxLength(255)
                    ->visible(fn (Get $get) => $get('linkeable_type') === 'url'),

                Forms\Components\Select::make('linkeable_id')
                    ->label('Item')
                    ->required()
                    ->searchable()
                    ->visible(fn (Get $get) => $get('linkeable_type') !== 'url')
                    ->options(
                        fn (Get $get) => ($class = $get('linkeable_type')) && class_exists($class)
                            ? $class::pluck('title', 'id')
                            : [],
                    ),

                Forms\Components\Toggle::make('new_tab')
                    ->label('Open in new tab')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        $blueprints = GroguCMS::getBlueprints();

        $blueprintsTypes = $blueprints->filter->showInMenus()->mapWithKeys(
            fn ($blueprint) => [$blueprint->model() => $blueprint->modelSingularLabel()]
        );

        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('linkeable_type')
                    ->label('Link type')
                    ->getStateUsing(fn (Model $record): string => $record->linkeable_type ?: 'url')
                    ->formatStateUsing(fn (string $state): string => $blueprintsTypes->get($state, strtoupper($state))),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(Closure::fromCallable([$this, 'mutateDataBeforeSaving'])),
            ])
            ->actions([
                Tables\Actions\ReplicateAction::make()
                    ->iconSoftButton('heroicon-o-square-2-stack'),

                Tables\Actions\EditAction::make()
                    ->iconSoftButton('heroicon-o-pencil-square')
                    ->mutateFormDataUsing(Closure::fromCallable([$this, 'mutateDataBeforeSaving']))
                    ->mutateRecordDataUsing(function (array $data): array {
                        if (! Arr::get($data, 'linkeable_type')) {
                            $data['linkeable_type'] = 'url';
                        }

                        return $data;
                    }),

                Tables\Actions\DeleteAction::make()
                    ->iconSoftButton('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function mutateDataBeforeSaving(array $data): array
    {
        if ($data['linkeable_type'] === 'url') {
            $data['linkeable_id'] = null;
            $data['linkeable_type'] = null;
            $data['external'] = match (true) {
                strpos($data['url'], config('app.url')) === 0 => false,
                strpos($data['url'], '#') === 0 => false,
                strpos($data['url'], '?') === 0 => false,
                default => true,
            };

            return $data;
        }

        $data['external'] = false;
        $data['url'] = null;

        return $data;
    }
}
