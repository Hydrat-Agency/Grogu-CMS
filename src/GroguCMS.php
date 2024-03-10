<?php

namespace Hydrat\GroguCMS;

use Hydrat\GroguCMS\Models\Menu;
use Illuminate\Support\Collection;
use Hydrat\GroguCMS\Templates\Template;
use Hydrat\GroguCMS\Blueprints\Blueprint;
use Hydrat\GroguCMS\Concerns\HasComponents;

class GroguCMS
{
    use HasComponents;

    /**
     * @var array<class-string>
     */
    protected array $templates = [];

    /**
     * @var array<string>
     */
    protected array $templateDirectories = [];

    /**
     * @var array<string>
     */
    protected array $templateNamespaces = [];

    /**
     * @var array<class-string>
     */
    protected array $blueprints = [];

    /**
     * @var array<string>
     */
    protected array $blueprintDirectories = [];

    /**
     * @var array<string>
     */
    protected array $blueprintNamespaces = [];

    public function getTemplate(?string $name = null, ?string $model = null): ?Template
    {
        return $name
            ? $this->getTemplates($model)->get($name)
            : null;
    }

    public function getTemplates(?string $model = null): Collection
    {
        return collect($this->templates)
            ->map(fn ($template) => new $template())
            ->when($model, fn ($c) => $c->filter->isEnabledFor($model))
            ->keyBy(fn ($template) => $template->name());
    }

    public function getBlueprints(?string $model = null): Collection
    {
        return collect($this->blueprints)
            ->map(fn ($blueprint) => new $blueprint())
            ->when($model, fn ($c) => $c->filter(fn ($b) => $b->model() === $model));
    }

    public function discoverTemplates(string $in, string $for): static
    {
        $this->templateDirectories[] = $in;
        $this->templateNamespaces[] = $for;

        $this->discoverComponents(
            Template::class,
            $this->templates,
            directory: $in,
            namespace: $for,
        );

        return $this;
    }

    public function discoverBlueprints(string $in, string $for): static
    {
        $this->blueprintDirectories[] = $in;
        $this->blueprintNamespaces[] = $for;

        $this->discoverComponents(
            Blueprint::class,
            $this->blueprints,
            directory: $in,
            namespace: $for,
        );

        return $this;
    }

    public function menuLocations(): Collection
    {
        $shouldTranslate = config('grogu-cms.menus.translate_labels');

        return collect(config('grogu-cms.menus.locations', []))
            ->map(fn ($name) => $shouldTranslate ? __($name) : $name)
            ->unique();
    }

    public function menus(bool $asResource = false)
    {
        $model = config('grogu-cms.models.menu', Menu::class);

        return $model::query()
            ->with('items')
            ->get()
            ->mapWithKeys(fn ($menu) => [
                $menu->location => $asResource
                    ? $menu->items->map->toResource()
                    : $menu->items,
            ]);
    }
}
