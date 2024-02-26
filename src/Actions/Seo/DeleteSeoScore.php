<?php

namespace Hydrat\GroguCMS\Actions\Seo;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Lorisleiva\Actions\Concerns\AsAction;
use Hydrat\GroguCMS\Events\CmsModelDeleted;
use Hydrat\GroguCMS\Actions\Seo\GenerateSeoScore;

class DeleteSeoScore
{
    use AsAction;

    public function handle(Model $record): bool
    {
        return Cache::forget(GenerateSeoScore::getCacheKey($record));
    }

    public function asListener(...$parameters): bool
    {
        $event = $parameters[0];

        if ($event instanceof CmsModelDeleted) {
            return $this->handle($event->model);
        }

        $this->handle(...$parameters);
    }
}
