<?php

namespace Hydrat\GroguCMS;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Hydrat\GroguCMS\Facades\GroguCMS;

class GroguCMSPlugin implements Plugin
{
    public function __construct(
        //
    ) {
        //
    }

    public function getId(): string
    {
        return 'grogu-cms';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources(
                config('grogu-cms.resources') ?: []
            )
            ->pages([
                // Settings::class,
            ])
            ->widgets([])
            ->discoverResources(in: __DIR__.'/Filament/Resources', for: 'Hydrat\\GroguCMS\\Filament\\Resources')
            ->discoverWidgets(in: __DIR__.'/Filament/Widgets', for: 'Hydrat\\GroguCMS\\Filament\\Widgets');
    }

    public function discoverTemplates(string $in, string $for): static
    {
        GroguCMS::discoverTemplates($in, $for);

        return $this;
    }

    public function discoverBlueprints(string $in, string $for): static
    {
        GroguCMS::discoverBlueprints($in, $for);

        return $this;
    }

    public function discoverBlockComposers(string $in, string $for): static
    {
        GroguCMS::discoverBlockComposers($in, $for);

        return $this;
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
