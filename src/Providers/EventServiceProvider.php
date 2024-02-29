<?php

namespace Hydrat\GroguCMS\Providers;

use Hydrat\GroguCMS\Actions;
use Hydrat\GroguCMS\Events;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Events\CmsModelSaved::class => [
            Actions\Seo\GenerateSeoScore::class,
        ],
        Events\CmsModelDeleted::class => [
            Actions\Seo\DeleteSeoScore::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}