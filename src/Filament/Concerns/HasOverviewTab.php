<?php

namespace Hydrat\GroguCMS\Filament\Concerns;

use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Hydrat\GroguCMS\Actions\GenerateUniqueSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use RalphJSmit\Filament\MediaLibrary\Forms\Components\MediaPicker;

trait HasOverviewTab
{
    protected static function getOverviewTabSchema(Form $form): array
    {
        return [
            Forms\Components\Tabs\Tab::make('Overview')
                ->columns([
                    'md' => 1,
                    'lg' => 3,
                ])
                ->schema([
                    ...static::getOverviewTabOverviewSectionSchema($form),
                    ...static::getOverviewTabMetadataSectionSchema($form),
                ]),
        ];
    }

    protected static function getOverviewTabOverviewSectionSchema(Form $form): array
    {
        $blueprint = static::getBlueprint($form);

        return [
            Forms\Components\Section::make(__('Overview'))
                ->collapsible()
                ->columnSpan([
                    'md' => 1,
                    'lg' => 2,
                ])
                ->schema([
                    Forms\Components\TextInput::make('title')
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

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->prefix(
                            fn () => Str::finish($blueprint->frontUrl(includeSelf: false), '/'),
                        )
                        ->unique($form->getModel(), 'slug', ignoreRecord: true),
                    // ->unique($form->getModel(), 'slug', ignoreRecord: true, modifyRuleUsing: function ($rule) {
                    //     return $rule->where('parent_id', request()->route('record')?->parent_id ?: null);
                    // }),

                    Forms\Components\MarkdownEditor::make('excerpt')
                        ->maxLength(65535)
                        ->columnSpanFull()
                        ->helperText(__('An overview of the page, used in feeds with the intent to entice readers to click through.')),

                    Forms\Components\DateTimePicker::make('published_at')
                        ->timezone('UTC')
                        ->helperText(__('When not set, the article is considered as a draft.')),
                ]),
        ];
    }

    protected static function getOverviewTabMetadataSectionSchema(Form $form): array
    {
        $blueprint = static::getBlueprint($form);

        return [
            Forms\Components\Section::make(__('Metadata'))
                ->collapsible()
                ->columnSpan([
                    'lg' => 1,
                ])
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->label('Author')
                        ->relationship('user', 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->default(auth()->id()),

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

                    Forms\Components\Group::make()
                        ->schema([
                            Forms\Components\Placeholder::make('created_at')
                                ->label('Created at')
                                ->content(fn (Model $record): ?string => $record->created_at?->isoFormat('LLL')),

                            Forms\Components\Placeholder::make('updated_at')
                                ->label('Last modified at')
                                ->content(fn (Model $record): ?string => $record->updated_at?->isoFormat('LLL')),
                        ])
                        ->hidden(fn (?Model $record) => $record === null),
                ]),
        ];
    }
}
