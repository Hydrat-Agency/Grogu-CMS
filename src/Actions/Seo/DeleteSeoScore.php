<?php

namespace Hydrat\GroguCMS\Actions\Seo;

use Hydrat\GroguCMS\Events\CmsModelDeleted;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Lorisleiva\Actions\Concerns\AsAction;

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
