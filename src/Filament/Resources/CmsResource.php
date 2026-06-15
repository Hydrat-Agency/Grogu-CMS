<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Actions\GenerateUniqueSlug;
use Hydrat\GroguCMS\Actions\Seo\GenerateSeoScore;
use Hydrat\GroguCMS\Enums\PostStatus;
use Hydrat\GroguCMS\Filament\Concerns as Parts;
use Hydrat\GroguCMS\Filament\Concerns\InteractsWithBlueprint;
use Hydrat\GroguCMS\Filament\Contracts\HasBlueprint;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use RalphJSmit\Filament\MediaLibrary\Filament\Forms\Components\MediaPicker;
use RalphJSmit\Filament\MediaLibrary\Filament\Tables\Columns\MediaColumn;

abstract class CmsResource extends Resource implements HasBlueprint
{
    use InteractsWithBlueprint;
    use Parts\HasContentTab;
    use Parts\HasOverviewTab;
    use Parts\HasSeoTab;

    public static function form(Schema $schema): Schema
    {
        $blueprint = static::getBlueprint($schema);

        return $schema
            ->components([
                ...static::startAttributesSection(),

                Section::make(__('Overview'))
                    ->columns(2)
                    ->compact(false)
                    ->schema([
                        ...static::startAttributesOverviewSection(),

                        TextInput::make('title')
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

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->prefix(function ($livewire) use ($blueprint) {
                                $locale = $blueprint->translatable() && method_exists($livewire, 'getActiveActionsLocale')
                                    ? $livewire->getActiveActionsLocale()
                                    : null;

                                return Str::finish($blueprint->frontUrl(includeSelf: false, locale: $locale), '/');
                            })
                            ->columnSpanFull()
                            ->unique($schema->getModel(), 'slug', ignoreRecord: true),
                        // ->unique($form->getModel(), 'slug', ignoreRecord: true, modifyRuleUsing: function ($rule) {
                        //     return $rule->where('parent_id', request()->route('record')?->parent_id ?: null);
                        // }),

                        Select::make('parent_id')
                            ->relationship(
                                name: 'parent',
                                titleAttribute: 'title',
                                ignoreRecord: true,
                                // modifyQueryUsing: fn (Builder $q, ?Model $record = null) => $q->when($record?->id, fn ($q) => $q->where('id', '!=', $record->id))
                            )
                            ->searchable()
                            ->live(debounce: 250)
                            ->visible($blueprint->hierarchical())
                            ->nullable()
                            ->preload(),

                        Select::make('template')
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

                        Select::make('status')
                            ->options(PostStatus::class)
                            ->default(PostStatus::default()->value)
                            ->columnSpanFull()
                            ->native(false)
                            ->required(),

                        ...static::endAttributesOverviewSection(),
                    ]),

                Section::make(__('Metadata'))
                    ->columns(2)
                    ->compact(false)
                    ->schema([
                        ...static::startAttributesMetadataSection(),

                        Select::make('user_id')
                            ->label('Author')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(auth()->id())
                            ->columnSpanFull(),

                        MarkdownEditor::make('excerpt')
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
            ->recordActions([
                Action::make('visit')
                    ->iconSoftButton('heroicon-o-arrow-up-right')
                    ->url(function (Model $record, $livewire) {
                        $blueprint = $record->blueprint();
                        $locale = $blueprint && $blueprint->translatable() && method_exists($livewire, 'getActiveActionsLocale')
                            ? $livewire->getActiveActionsLocale()
                            : null;

                        return optional($blueprint)->frontUrl(locale: $locale);
                    })
                    ->openUrlInNewTab(),

                ReplicateAction::make()
                    ->schema(function (Schema $schema) {
                        $blueprint = static::getBlueprint($schema);

                        return [
                            TextInput::make('title')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->columnSpanFull()
                                ->afterStateUpdated(function (Set $set, $state) use ($blueprint) {
                                    $slug = GenerateUniqueSlug::run(
                                        title: $state,
                                        class: $blueprint->model(),
                                    );

                                    $set('slug', $slug);
                                }),

                            TextInput::make('slug')
                                ->required()
                                ->maxLength(255)
                                ->prefix(
                                    fn () => Str::finish($blueprint->frontUrl(includeSelf: false), '/'),
                                )
                                ->columnSpanFull()
                                ->unique($schema->getModel(), 'slug', ignoreRecord: true),

                            Placeholder::make(__('Warning'))
                                ->content(__('Duplicated content can have a negative impact on your website\'s SEO score.')),
                        ];
                    })
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['title'] = $data['title'].' (Copy)';
                        $data['slug'] = Str::slug($data['title']);

                        return $data;
                    })
                    ->successRedirectUrl(fn (Model $replica): string => static::getUrl('edit', ['record' => $replica]))
                    ->iconSoftButton('heroicon-o-square-2-stack'),

                EditAction::make()->iconSoftButton('heroicon-o-pencil-square'),
                DeleteAction::make()->iconSoftButton('heroicon-o-trash'),
            ]);
    }

    protected static function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->numeric()
                ->label('ID')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true)
                ->weight('bold'),

            TextColumn::make('title')
                ->sortable()
                ->searchable()
                ->translatable()
                ->description(function (Model $record, $livewire) {
                    $blueprint = $record->blueprint();
                    $locale = $blueprint && $blueprint->translatable() && method_exists($livewire, 'getActiveActionsLocale')
                        ? $livewire->getActiveActionsLocale()
                        : null;

                    return optional($blueprint)->frontUri(locale: $locale);
                }),

            TextColumn::make('slug')
                ->sortable()
                ->searchable()
                ->translatable()
                ->toggleable(isToggledHiddenByDefault: true),

            TextColumn::make('status')
                ->sortable()
                ->badge()
                ->toggleable(isToggledHiddenByDefault: false),

            TextColumn::make('user.name')
                ->label('Author')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),

            TextColumn::make('seo_score')
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
