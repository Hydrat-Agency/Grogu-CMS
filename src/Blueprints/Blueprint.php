<?php

namespace Hydrat\GroguCMS\Blueprints;

use Hydrat\GroguCMS\UrlManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Hydrat\GroguCMS\Contracts\BlueprintContract;
use Hydrat\GroguCMS\Settings\GeneralSettings;

abstract class Blueprint implements BlueprintContract
{
    protected string $model;

    protected array $templates = [];

    protected ?string $view = null;

    protected ?string $routeName = null;

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

    public function templates(): array
    {
        return $this->templates;
    }

    public function hierarchical(): bool
    {
        return $this->hierarchical;
    }

    public function computeHierarchicalPath(?Model $record = null): ?string
    {
        $record = $record ?? $this->record();

        if (!$this->hierarchical()) {
            return $record->slug;
        }

        $extends = [];
        $parent = $record;

        while ($parent) {
            $extends[] = $parent->slug;
            $parent = $parent->parent()->select('id', 'parent_id', 'slug')->first();
        }

        return Arr::join(array_reverse($extends), '/');
    }

    public function routeName(): ?string
    {
        return $this->routeName;
    }

    // public function frontUrl(?Model $record = null): string
    // {
    //     $record = $record ?? $this->record();

    //     $route = $this->routeName();
    //     $slug = $this->computeHierarchicalPath($record);

    //     return $route
    //         ? route($route, $slug)
    //         : url($slug);
    // }

    public function frontUri(bool $includeSelf = true): ?string
    {
        if (!$this->routeName()) {
            return null;
        }

        if (($record = $this->record()) && get_class($record) === "App\\Models\\Page") {
            $settings = app(GeneralSettings::class);

            if ($settings->front_page === $record->id) {
                return '/';
            }
        }

        /** @var \Illuminate\Routing\Route */
        $route = Route::getRoutes()->getByName($this->routeName());
        $binds = $this->bindRouteParameters();

        if (!$includeSelf) {
            $parent = $record->parent;

            $binds = [
                ...$binds,
                'slug' => $parent ? $this->computeHierarchicalPath($parent) : '',
                $this->modelSingularName() => null,
            ];
        }

        return UrlManager::make()->getBindedUri($route, $binds);
    }

    public function frontUrl(bool $includeSelf = true): ?string
    {
        $uri = $this->frontUri($includeSelf);

        return app('url')->to($uri);
    }

    public function bindRouteParameters(): array
    {
        return [
            $this->modelSingularName() => $this->record(),
            'slug' => $this->computeHierarchicalPath(),
        ];
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
            && !$this->hasMandatoryTemplate();
    }

    public function getTemplates(): Collection
    {
        return collect($this->templates())
            ->map(fn ($template) => new $template())
            ->keyBy(fn ($template) => $template->name());
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

    public function blocks(): array
    {
        return [
            //
        ];
    }
}
