<?php

namespace Hydrat\GroguCMS\Filament\Concerns;

use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms;
use Filament\Schemas\Schema;
use Hydrat\GroguCMS\Actions\Seo\GenerateSeoScore;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;
use Vormkracht10\Seo\SeoScore;

trait HasSeoTab
{
    public static function seoTabIsContained(): bool
    {
        return true;
    }

    protected static function getSeoTabSchema(Schema $schema): array
    {
        $blueprint = static::getBlueprint($schema);

        if (! $blueprint->hasSeo()) {
            return [];
        }

        $scheme = static::seoTabIsContained()
            ? static::getSeoTabSchemaContentSectionSchema($schema)
            : static::getSeoTabInnerSchema($schema);

        return [
            Tab::make('SEO')
                ->columns([
                    'md' => 1,
                ])
                ->schema([
                    ...$scheme,
                    ...static::getSeoTabScoreSchema($schema),
                ]),
        ];
    }

    protected static function getSeoTabSchemaContentSectionSchema(Schema $schema): array
    {
        return [
            Section::make('seo')
                ->label('SEO Configuration')
                ->schema([
                    ...static::getSeoTabInnerSchema($schema),
                ]),
        ];
    }

    protected static function getSeoTabInnerSchema(Schema $schema): array
    {
        return [
            Grid::make(2)
                ->schema([
                    TextInput::make('seo.title')
                        ->columnSpanFull(),

                    FileUpload::make('seo.image')
                        ->image()
                        ->columnSpanFull(),

                    Textarea::make('seo.description')
                        ->maxLength(65535)
                        ->rows(5)
                        ->helperText(__('A short description used on social previews and Google vignette.'))
                        ->columnSpanFull(),

                    DatePicker::make('seo.modified_time')
                        ->timezone('UTC'),

                    TextInput::make('seo.author'),
                ]),
        ];
    }

    protected static function getSeoTabScoreSchema(Schema $schema): array
    {
        if (! ($record = $schema->getRecord())) {
            return [];
        }

        $score = Cache::get(GenerateSeoScore::getCacheKey($record));

        if (! $score || ! ($score instanceof SeoScore)) {
            return [];
        }

        return [
            Section::make(__('SEO Analysis'))
                ->collapsible()
                ->schema([
                    Placeholder::make('seo_score')
                        ->content(function () use ($score) {
                            $score = $score->getScore();
                            $color = match (true) {
                                $score < 50 => 'danger',
                                $score < 85 => 'warning',
                                default => 'success',
                            };

                            return new HtmlString(
                                Blade::render(<<<HTML
                                    <x-filament::badge size="sm" color="{$color}" class="inline-flex">{$score} / 100</x-filament::badge>
                                HTML)
                            );
                        }),

                    Placeholder::make('failed')
                        ->content(fn () => new HtmlString(
                            $score->getFailedChecks()->map(
                                fn ($check) => <<<HTML
                                    <div class="py-1">
                                        <div>
                                            <x-filament::badge size="sm" color="danger" class="inline-flex">failed</x-filament::badge>
                                            <x-filament::badge size="sm" class="inline-flex">$check->priority</x-filament::badge>
                                            <span class="font-medium">$check->title</span>
                                        </div>
                                        <p class="text-gray-700">$check->description</p>
                                    </div>
                                HTML
                            )
                                ->map(fn ($content) => Blade::render($content))
                                ->join("\n")
                        )),

                    Placeholder::make('passes')
                        ->content(fn () => new HtmlString(
                            $score->getSuccessfulChecks()->map(
                                fn ($check) => <<<HTML
                                    <div class="py-1">
                                        <div>
                                            <x-filament::badge size="sm" color="success" class="inline-flex">succeded</x-filament::badge>
                                            <x-filament::badge size="sm" class="inline-flex">$check->priority</x-filament::badge>
                                            <span class="font-medium">$check->title</span>
                                        </div>
                                        <p class="text-gray-700">$check->description</p>
                                    </div>
                                HTML
                            )
                                ->map(fn ($content) => Blade::render($content))
                                ->join("\n")
                        )),
                ]),
        ];
    }
}
