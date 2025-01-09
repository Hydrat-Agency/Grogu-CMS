<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Htmlable;
use Hydrat\GroguCMS\Actions\GenerateUniqueSlug;
use Hydrat\GroguCMS\Filament\Concerns as Parts;
use Hydrat\GroguCMS\Actions\Seo\GenerateSeoScore;
use Hydrat\GroguCMS\Enums\PostStatus;
use Hydrat\GroguCMS\Filament\Contracts\HasBlueprint;
use Hydrat\GroguCMS\Filament\Concerns\InteractsWithBlueprint;
use RalphJSmit\Filament\MediaLibrary\Tables\Columns\MediaColumn;
use RalphJSmit\Filament\MediaLibrary\Forms\Components\MediaPicker;

abstract class CmsResource extends Resource implements HasBlueprint
{
    use InteractsWithBlueprint;
    use Parts\HasContentTab;
    use Parts\HasOverviewTab;
    use Parts\HasSeoTab;

    public static function form(Form $form): Form
    {
        $blueprint = static::getBlueprint($form);

        return $form
            ->schema([
                ...static::startAttributesSection(),

                Forms\Components\Section::make(__('Overview'))
                    ->columns(2)
                    ->compact(false)
                    ->schema([
                        ...static::startAttributesOverviewSection(),

                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->columnSpanFull()
                            ->afterStateUpdated(function (Set $set, $state, ?Model $record, string $operation) use ($blueprint) {
                                if ($operation !== 'create') {
                                    return;
                                }

                                $slug = GenerateUniqueSlug::run(
                                    title: $state,
                                    class: $blueprint->model(),
                                );

                                $set('slug', $slug);
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->prefix(
                                fn () => Str::finish($blueprint->frontUrl(includeSelf: false), '/'),
                            )
                            ->columnSpanFull()
                            ->unique($form->getModel(), 'slug', ignoreRecord: true),
                            // ->unique($form->getModel(), 'slug', ignoreRecord: true, modifyRuleUsing: function ($rule) {
                            //     return $rule->where('parent_id', request()->route('record')?->parent_id ?: null);
                            // }),

                        Forms\Components\Select::make('parent_id')
                            ->relationship(
                                name: 'parent',
                                titleAttribute: 'title',
                                // modifyQueryUsing: fn (Builder $q, ?Model $record = null) => $q->when($record?->id, fn ($q) => $q->where('id', '!=', $record->id))
                            )
                            ->searchable()
                            ->live(debounce: 250)
                            ->visible($blueprint->hierarchical())
                            ->nullable()
                            ->preload(),

                        Forms\Components\Select::make('template')
                            ->visible($blueprint->hasTemplates())
                            ->required($blueprint->hasMandatoryTemplate())
                            ->options(
                                $blueprint->getTemplates()->map(
                                    fn ($template) => $template->label()
                                )
                            )
                            ->live(debounce: 250)
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('status')
                            ->options(PostStatus::class)
                            ->default(PostStatus::default()->value)
                            ->columnSpanFull()
                            ->native(false)
                            ->required(),

                        ...static::endAttributesOverviewSection(),
                    ]),

                Forms\Components\Section::make(__('Metadata'))
                    ->columns(2)
                    ->compact(false)
                    ->schema([
                        ...static::startAttributesMetadataSection(),

                        Forms\Components\Select::make('user_id')
                            ->label('Author')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(auth()->id())
                            ->columnSpanFull(),

                        Forms\Components\MarkdownEditor::make('excerpt')
                            ->maxLength(65535)
                            ->columnSpanFull()
                            ->columnSpanFull()
                            ->helperText(__('An overview of the page, used in feeds with the intent to entice readers to click through.'))
                            ->columnSpanFull(),

                        MediaPicker::make('thumbnail_id')
                            ->label(__('Thumbnail'))
                            ->acceptedFileTypes(['image/*']),

                        ...static::endAttributesMetadataSection(),
                    ]),

                ...static::endAttributesSection(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ...static::getTableColumns(),
            ])
            ->recordUrl(fn (Model $record): string => static::getUrl('content', ['record' => $record]))
            ->actions([
                Tables\Actions\Action::make('visit')
                    ->iconSoftButton('heroicon-o-arrow-up-right')
                    ->url(fn (Model $record) => optional($record->blueprint())->frontUrl())
                    ->openUrlInNewTab(),

                Tables\Actions\EditAction::make()->iconSoftButton('heroicon-o-pencil-square'),
                Tables\Actions\DeleteAction::make()->iconSoftButton('heroicon-o-trash'),
            ]);
    }

    protected static function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id')
                ->numeric()
                ->label('ID')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->weight('bold'),

            Tables\Columns\TextColumn::make('title')
                ->sortable()
                ->searchable()
                ->description(fn (Model $record) => optional($record->blueprint())->frontUri()),

            Tables\Columns\TextColumn::make('status')
                ->sortable()
                ->badge()
                ->toggleable(isToggledHiddenByDefault: false),

            Tables\Columns\TextColumn::make('user.name')
                ->label('Author')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),

            Tables\Columns\TextColumn::make('seo_score')
                ->label('SEO')
                ->badge()
                ->getStateUsing(fn (Model $record) => Cache::get(GenerateSeoScore::getCacheKey($record))?->getScore())
                ->formatStateUsing(fn (string|Htmlable|null $state) => $state ? $state.'/100' : '')
                ->color(fn (string|Htmlable|null $state) => match (true) {
                    $state < 50 => 'danger',
                    $state < 85 => 'warning',
                    default => 'success',
                })
                ->toggleable(isToggledHiddenByDefault: false),

            // Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
            //     ->collection('image')
            //     ->conversion('small')
            //     ->disk('media-library')
            //     ->circular(true)
            //     ->toggleable(isToggledHiddenByDefault: false),

            MediaColumn::make('thumbnail')
                ->circular()
                ->size(40),
        ];
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'slug', 'user.name', 'content', 'excerpt'];
    }

    public static function getGlobalSearchResultTitle(Model $record): string|Htmlable
    {
        return $record->title;
    }

    // public static function getGlobalSearchResultDetails(Model $page) : array
    // {
    //     return [
    //         __('Author') => $page->user?->name,
    //     ];
    // }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user:id,name']);
    }

    public static function startAttributesOverviewSection(): array
    {
        return [];
    }

    public static function endAttributesOverviewSection(): array
    {
        return [];
    }

    public static function startAttributesMetadataSection(): array
    {
        return [];
    }

    public static function endAttributesMetadataSection(): array
    {
        return [];
    }

    public static function startAttributesSection(): array
    {
        return [];
    }

    public static function endAttributesSection(): array
    {
        return [];
    }
}
