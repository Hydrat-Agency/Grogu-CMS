<?php

namespace Hydrat\GroguCMS\Content;

use Illuminate\Support\Arr;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Fluent;
use Hydrat\GroguCMS\UrlManager;
use Illuminate\Support\Collection;
use Hydrat\GroguCMS\Enums\PostStatus;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Hydrat\GroguCMS\Settings\GeneralSettings;
use Hydrat\GroguCMS\Contracts\BlueprintContract;

abstract class Blueprint implements BlueprintContract
{
    protected string $model;

    protected array $templates = [];

    protected ?string $view = null;

    protected ?string $routeName = null;

    protected bool $translatable = false;

    protected bool $hierarchical = false;

    protected bool $hasMandatoryTemplate = false;

    protected bool $supportsExcerpt = true;

    protected bool $supportsSeo = true;

    public function __construct(
        protected ?Model $record = null,
    ) {}

    public function hasRecord(): bool
    {
        return filled($this->record);
    }

    public function record(): ?Model
    {
        return $this->record;
    }

    public function view(): ?string
    {
        return $this->view;
    }

    public function model(): string
    {
        return $this->model;
    }

    public function templates(): array
    {
        return $this->templates;
    }

    public function translatable(): bool
    {
        return $this->translatable;
    }

    public function hierarchical(): bool
    {
        return $this->hierarchical;
    }

    public function routeName(): ?string
    {
        return $this->routeName;
    }

    public function translatedRouteName(string $locale): ?string
    {
        return Arr::join([$locale, $this->routeName()], '.');
    }

    public function showInMenus(): bool
    {
        return filled($this->routeName());
    }

    public function hasTemplates(): bool
    {
        return filled($this->templates());
    }

    public function hasMandatoryTemplate(): bool
    {
        return $this->hasMandatoryTemplate;
    }

    public function hasDefaultTemplate(): bool
    {
        return $this->hasTemplates()
            && ! $this->hasMandatoryTemplate();
    }

    public function hasExcerpt(): bool
    {
        return $this->supportsExcerpt;
    }

    public function hasSeo(): bool
    {
        return $this->supportsSeo;
    }

    public function hasContent(): bool
    {
        return blank($this->blocks());
    }

    public function hasBlocks(): bool
    {
        return filled($this->blocks());
    }

    public function modelSingularName(): string
    {
        $model = $this->model();

        return str()
            ->of($model)
            ->afterLast('\\')
            ->lower()
            ->toString();
    }

    public function modelPluralName(): string
    {
        $singular = $this->modelSingularName();

        return str()
            ->of($singular)
            ->plural()
            ->toString();
    }

    public function modelSingularLabel(): string
    {
        return str()
            ->of($this->modelSingularName())
            ->title()
            ->toString();
    }

    public function modelPluralLabel(): string
    {
        return str()
            ->of($this->modelPluralName())
            ->title()
            ->toString();
    }

    public function computeHierarchicalPath(?Model $record = null, ?string $locale = null): ?string
    {
        $record = $record ?? $this->record();
        $locale = $locale ?? app()->getLocale();

        if (! $this->hierarchical()) {
            return grogu_translate($record, 'slug', $locale);
        }

        $extends = [];
        $parent = $record;

        while ($parent) {
            $extends[] = grogu_translate($record, 'slug', $locale);
            $parent = $parent->parent()->select('id', 'parent_id', 'slug')->first();
        }

        return Arr::join(array_reverse($extends), '/');
    }

    public function frontUri(bool $includeSelf = true, ?string $locale = null): ?string
    {
        $locale = $locale ?? app()->getLocale();

        $routeName = $this->translatable()
            ? $this->translatedRouteName($locale)
            : $this->routeName();

        if (blank($routeName) || blank($record = $this->record())) {
            return null;
        }

        if (get_class($record) === 'App\\Models\\Page') {
            $settings = app(GeneralSettings::class);

            if ($settings->front_page === $record->id) {
                return $this->translatable()
                    ? route($locale . '.front-page.show')
                    : route('front-page.show');
            }
        }

        /** @var \Illuminate\Routing\Route */
        $route = Route::getRoutes()->getByName($routeName);
        $binds = $this->bindRouteParameters($locale);

        if (! $includeSelf) {
            $parent = $this->hierarchical() ? $record->parent : null;

            $binds = [
                ...$binds,
                'slug' => $parent ? $this->computeHierarchicalPath($parent, $locale) : '',
                $this->modelSingularName() => null,
            ];
        }

        return UrlManager::make()->getBindedUri($route, $binds);
    }

    public function frontUrl(bool $includeSelf = true, ?string $locale = null): ?string
    {
        $uri = $this->frontUri($includeSelf, $locale);

        return app('url')->to($uri);
    }

    public function alternates(bool $includeCurrentLocale = true): Collection
    {
        $alternates = new Collection();

        if ($this->translatable() && $this->record() && method_exists($this->record(), 'getSupportedLocales')) {
            foreach ($this->record()->getSupportedLocales() as $locale) {
                if (!$includeCurrentLocale && $locale === app()->getLocale()) {
                    continue;
                }

                $alternates->push(
                    new Fluent([
                        'locale' => $locale,
                        'url' => $this->frontUrl(includeSelf: true, locale: $locale),
                    ])
                );
            }
        } elseif ($includeCurrentLocale) {
            $alternates->push(
                new Fluent([
                    'locale' => app()->getLocale(),
                    'url' => $this->frontUrl(includeSelf: true, locale: app()->getLocale()),
                ])
            );
        }

        return $alternates;
    }

    public function sitemapEntry(): Url|string|array|null
    {
        if (! $this->routeName() || ! ($record = $this->record())) {
            return null;
        }

        if ($record->status !== PostStatus::Published) {
            return null;
        }

        $url = Url::create($this->frontUrl())
            ->setLastModificationDate($record->updated_at)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.5);

        foreach ($this->alternates() as $alternate) {
            $url->addAlternate($alternate->url, $alternate->locale);
        }

        return $url;
    }

    public function bindRouteParameters(?string $locale = null): array
    {
        return [
            $this->modelSingularName() => $this->record(),
            'slug' => $this->computeHierarchicalPath(locale: $locale),
        ];
    }

    public function getTemplates(): Collection
    {
        return collect($this->templates())
            ->map(fn ($template) => new $template)
            ->keyBy(fn ($template) => $template->name());
    }

    public function blocks(): array
    {
        return [
            //
        ];
    }
}
