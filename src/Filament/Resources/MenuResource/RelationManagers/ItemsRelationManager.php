<?php

namespace Hydrat\GroguCMS\Filament\Resources\MenuResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Models\MenuItem;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Items');
    }

    public function reorderTable(array $order): void
    {
        $model = config('grogu-cms.models.menu_item', MenuItem::class);

        $model::setNewOrder($order);

        $this->dispatch('refreshTree');
    }

    public function form(Form $form): Form
    {
        $blueprints = GroguCMS::getBlueprints();

        $blueprintsTypes = $blueprints->filter->showInMenus()->mapWithKeys(
            fn ($blueprint) => [$blueprint->model() => $blueprint->modelSingularLabel()]
        );

        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(6)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(3),

                        Forms\Components\Select::make('parent_id')
                            ->label('Parent')
                            ->columnSpan(3)
                            ->relationship(
                                name: 'parent',
                                titleAttribute: 'title',
                                modifyQueryUsing: fn (Builder $query) => $query->where('menu_id', $this->getOwnerRecord()->id),
                                ignoreRecord: true,
                            ),

                        Forms\Components\Select::make('linkeable_type')
                            ->label('Link type')
                            ->required()
                            ->live()
                            ->default('url')
                            ->columnSpan(2)
                            ->options([
                                'url' => 'URL',
                                ...$blueprintsTypes,
                            ]),

                        Forms\Components\TextInput::make('url')
                            ->maxLength(255)
                            ->visible(fn (Get $get) => $get('linkeable_type') === 'url')
                            ->columnSpan(4),

                        Forms\Components\Select::make('linkeable_id')
                            ->label('Item')
                            ->required()
                            ->searchable()
                            ->visible(fn (Get $get) => $get('linkeable_type') !== 'url')
                            ->columnSpan(2)
                            ->options(
                                fn (Get $get) => ($class = $get('linkeable_type')) && class_exists($class)
                                    ? $class::pluck('title', 'id')
                                    : [],
                            ),

                        Forms\Components\TextInput::make('anchor')
                            ->maxLength(255)
                            ->columnSpan(2)
                            ->visible(fn (Get $get) => $get('linkeable_type') !== 'url'),

                        Forms\Components\Toggle::make('new_tab')
                            ->label('Open in new tab')
                            ->columnSpanFull(),
                    ]),
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
            ->reorderable('order')
            ->defaultSort('order')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('parent.title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('path')
                    ->getStateUsing(fn (Model $record) => $record->joinAncestors()->reverse()->implode('title', ' > '))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('linkeable_type')
                    ->label('Link type')
                    ->getStateUsing(fn (Model $record): string => $record->linkeable_type ?: 'url')
                    ->formatStateUsing(fn (string $state): string => $blueprintsTypes->get($state, strtoupper($state)))
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('destination')
                    ->getStateUsing(fn (Model $record): ?string => match (filled($record->linkeable)) {
                        true => $record->linkeable->title,
                        default => $record->url,
                    })
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(Closure::fromCallable([$this, 'mutateDataBeforeSaving']))
                    ->after(fn () => $this->dispatch('refreshTree')),
            ])
            ->actions([
                Tables\Actions\ReplicateAction::make()
                    ->iconSoftButton('heroicon-o-square-2-stack'),

                Tables\Actions\EditAction::make()
                    ->iconSoftButton('heroicon-o-pencil-square')
                    ->mutateFormDataUsing(Closure::fromCallable([$this, 'mutateDataBeforeSaving']))
                    ->mutateRecordDataUsing(Closure::fromCallable([$this, 'mutateDataBeforeEditing']))
                    ->after(fn () => $this->dispatch('refreshTree')),

                Tables\Actions\DeleteAction::make()
                    ->iconSoftButton('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->groups([
                Group::make('parent.title')
                    ->collapsible(),

                Group::make('linkeable_type')
                    ->label(__('Link type'))
                    ->getTitleFromRecordUsing(fn (Model $record): ?string => $blueprintsTypes->get($record->linkeable_type))
                    ->collapsible(),
            ]);
    }

    protected function mutateDataBeforeEditing(array $data): array
    {
        if (! Arr::get($data, 'linkeable_type')) {
            $data = Arr::set($data, 'linkeable_type', 'url');
        }

        return [
            ...$data,
            'path' => $data['path']?->getValue(),
        ];
    }

    protected function mutateDataBeforeSaving(array $data): array
    {
        if (isset($data['path'])) {
            unset($data['path']);
        }

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
