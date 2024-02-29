<?php

namespace Hydrat\GroguCMS;

use Filament\Panel;
use Filament\Contracts\Plugin;
use Hydrat\GroguCMS\Facades\GroguCMS as GroguCMSFacade;
use Hydrat\GroguCMS\Filament\Resources\MenuResource;

class GroguCMSPlugin implements Plugin
{
    public function getId(): string
    {
        return 'grogu-cms';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                MenuResource::class,
            ])
            ->pages([
                // Settings::class,
            ]);
    }

    public function discoverTemplates(string $in, string $for): static
    {
        GroguCMSFacade::make()->discoverTemplates($in, $for);

        return $this;
    }

    public function discoverBlueprints(string $in, string $for): static
    {
        GroguCMSFacade::make()->discoverBlueprints($in, $for);

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
