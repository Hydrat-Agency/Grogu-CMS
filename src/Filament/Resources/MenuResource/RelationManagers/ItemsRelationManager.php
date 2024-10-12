<?php

namespace Hydrat\GroguCMS\Filament\Resources\MenuResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use Filament\Tables\Grouping\Group;
use Hydrat\GroguCMS\Models\MenuItem;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Filament\Resources\RelationManagers\RelationManager;

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
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('parent_id')
                    ->relationship(
                        name: 'parent',
                        titleAttribute: 'title',
                        modifyQueryUsing: fn (Builder $query, Model $record) => $query->where('menu_id', $record->menu_id),
                        ignoreRecord: true,
                    )
                    ->label('Parent'),

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
