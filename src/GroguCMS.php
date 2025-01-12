<?php

namespace Hydrat\GroguCMS;

use Hydrat\GroguCMS\Concerns\HasComponents;
use Hydrat\GroguCMS\Content\BlockComposer;
use Hydrat\GroguCMS\Content\Blueprint;
use Hydrat\GroguCMS\Content\Template;
use Hydrat\GroguCMS\Models\Menu;
use Illuminate\Support\Collection;

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

    /**
     * @var array<class-string>
     */
    protected array $blockComposers = [];

    /**
     * @var array<string>
     */
    protected array $blockComposersDirectories = [];

    /**
     * @var array<string>
     */
    protected array $blockComposersNamespaces = [];

    public function getTemplate(?string $name = null, ?string $model = null): ?Template
    {
        return $name
            ? $this->getTemplates($model)->get($name)
            : null;
    }

    public function getTemplates(?string $model = null): Collection
    {
        return collect($this->templates)
            ->map(fn ($template) => new $template)
            ->when($model, fn ($c) => $c->filter->isEnabledFor($model))
            ->keyBy(fn ($template) => $template->name());
    }

    public function getBlueprints(?string $model = null): Collection
    {
        return collect($this->blueprints)
            ->map(fn ($blueprint) => new $blueprint)
            ->when($model, fn ($c) => $c->filter(fn ($b) => $b->model() === $model));
    }

    public function getBlockComposers(?string $blockType = null): Collection
    {
        $composers = collect($this->blockComposers)
            ->map(fn ($composer) => collect($composer::blocks())->mapWithKeys(fn ($block) => [$block => $composer]))
            ->reduce(
                function (Collection $carry, $composer) {
                    foreach ($composer as $type => $class) {
                        if (! isset($carry[$type])) {
                            $carry[$type] = collect();
                        }

                        $carry[$type]->push($class);
                    }

                    return $carry;
                },
                collect()
            );

        if ($blockType) {
            return $composers->get($blockType, collect())
                ->merge($composers->get('*', collect()))
                ->unique();
        }

        return $composers;
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

    public function discoverBlockComposers(string $in, string $for): static
    {
        $this->blockComposersDirectories[] = $in;
        $this->blockComposersNamespaces[] = $for;

        $this->discoverComponents(
            BlockComposer::class,
            $this->blockComposers,
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
            ->with('elements.descendants')
            ->get()
            ->mapWithKeys(fn ($menu) => [
                $menu->location => $asResource
                    ? $menu->elements->map->toResource()
                    : $menu->elements,
            ]);
    }
}
