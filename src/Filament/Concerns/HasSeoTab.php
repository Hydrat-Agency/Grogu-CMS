<?php

namespace Hydrat\GroguCMS\Filament\Concerns;

use Filament\Forms;
use Filament\Forms\Form;
use Hydrat\GroguCMS\Actions\Seo\GenerateSeoScore;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;
use Vormkracht10\Seo\SeoScore;

trait HasSeoTab
{
    public static function seoTabIsContained(): bool
    {
        return false;
    }

    protected static function getSeoTabSchema(Form $form): array
    {
        $scheme = static::seoTabIsContained()
            ? static::getSeoTabSchemaContentSectionSchema($form)
            : static::getSeoTabInnerSchema($form);

        return [
            Forms\Components\Tabs\Tab::make('SEO')
                ->columns([
                    'md' => 1,
                ])
                ->schema([
                    ...$scheme,
                    ...static::getSeoTabScoreSchema($form),
                ]),
        ];
    }

    protected static function getSeoTabSchemaContentSectionSchema(Form $form): array
    {
        return [
            Forms\Components\Section::make('seo')
                ->label('SEO')
                ->schema([
                    ...static::getSeoTabInnerSchema($form),
                ]),
        ];
    }

    protected static function getSeoTabInnerSchema(Form $form): array
    {
        return [
            Forms\Components\Textarea::make('description')
                ->maxLength(65535)
                ->rows(5)
                ->helperText(__('A short description used on social previews and Google vignette.')),

            Forms\Components\DatePicker::make('manually_updated_at')
                ->timezone('UTC'),
        ];
    }

    protected static function getSeoTabScoreSchema(Form $form): array
    {
        if (! ($record = $form->getRecord())) {
            return [];
        }

        $score = Cache::get(GenerateSeoScore::getCacheKey($record));

        if (! $score || ! ($score instanceof SeoScore)) {
            return [];
        }

        return [
            Forms\Components\Section::make(__('SEO Analysis'))
                ->collapsible()
                ->schema([
                    Forms\Components\Placeholder::make('seo_score')
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

                    Forms\Components\Placeholder::make('failed')
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

                    Forms\Components\Placeholder::make('passes')
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
