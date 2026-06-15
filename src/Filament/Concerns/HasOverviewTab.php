<?php

namespace Hydrat\GroguCMS\Filament\Concerns;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Hydrat\GroguCMS\Actions\GenerateUniqueSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RalphJSmit\Filament\MediaLibrary\Filament\Forms\Components\MediaPicker;

trait HasOverviewTab
{
    protected static function getOverviewTabSchema(Schema $schema): array
    {
        return [
            Tab::make('Overview')
                ->columns([
                    'md' => 1,
                    'lg' => 3,
                ])
                ->schema([
                    ...static::getOverviewTabOverviewSectionSchema($schema),
                    ...static::getOverviewTabMetadataSectionSchema($schema),
                ]),
        ];
    }

    protected static function getOverviewTabOverviewSectionSchema(Schema $schema): array
    {
        $blueprint = static::getBlueprint($schema);

        return [
            Section::make(__('Overview'))
                ->collapsible()
                ->columnSpan([
                    'md' => 1,
                    'lg' => 2,
                ])
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
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
                        ->prefix(
                            fn () => Str::finish($blueprint->frontUrl(includeSelf: false), '/'),
                        )
                        ->unique($schema->getModel(), 'slug', ignoreRecord: true),
                    // ->unique($schema->getModel(), 'slug', ignoreRecord: true, modifyRuleUsing: function ($rule) {
                    //     return $rule->where('parent_id', request()->route('record')?->parent_id ?: null);
                    // }),

                    MarkdownEditor::make('excerpt')
                        ->maxLength(65535)
                        ->columnSpanFull()
                        ->helperText(__('An overview of the page, used in feeds with the intent to entice readers to click through.')),

                    Select::make('status')
                        ->options(PostStatus::class)
                        ->default(PostStatus::default()->value)
                        ->columnSpanFull()
                        ->native(false)
                        ->required(),
                ]),
        ];
    }

    protected static function getOverviewTabMetadataSectionSchema(Schema $schema): array
    {
        $blueprint = static::getBlueprint($schema);

        return [
            Section::make(__('Metadata'))
                ->collapsible()
                ->columnSpan([
                    'lg' => 1,
                ])
                ->schema([
                    Select::make('user_id')
                        ->label('Author')
                        ->relationship('user', 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->default(auth()->id()),

                    Select::make('parent_id')
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

                    // SpatieMediaLibraryFileUpload::make('image')
                    //     ->collection('image')
                    //     ->conversion('small')
                    //     ->disk('media-library')
                    //     ->downloadable()
                    //     ->imageCropAspectRatio('16:9')
                    //     ->imageEditor()
                    //     ->imageResizeMode('cover')
                    //     ->imageResizeTargetHeight('1080')
                    //     ->imageResizeTargetWidth('1920')
                    //     ->visibility('public'),

                    MediaPicker::make('thumbnail_id')
                        ->label(__('Thumbnail'))
                        ->acceptedFileTypes(['image/*']),

                    Group::make()
                        ->schema([
                            Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn (Model $record): ?string => $record->created_at?->isoFormat('LLL')),

                            Placeholder::make('updated_at')
                                ->label('Last modified at')
                                ->content(fn (Model $record): ?string => $record->updated_at?->isoFormat('LLL')),
                        ])
                        ->hidden(fn (?Model $record) => $record === null),
                ]),
        ];
    }
}
