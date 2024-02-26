<?php

namespace Hydrat\GroguCMS\Actions\Seo;

use Vormkracht10\Seo\SeoScore;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Hydrat\GroguCMS\Events\CmsModelSaved;
use Lorisleiva\Actions\Concerns\AsAction;

class GenerateSeoScore
{
    use AsAction;

    public function handle(Model $record): SeoScore
    {
        $score = $record->seoScore();

        Cache::set(static::getCacheKey($record), $score);

        return $score;
    }

    public static function getCacheKey(Model $record): string
    {
        return sprintf('grogu-cms.seo-score.%s.%s', get_class($record), $record->id);
    }

    public function asListener(...$parameters): SeoScore
    {
        $event = $parameters[0];

        if ($event instanceof CmsModelSaved) {
            return $this->handle($event->model);
        }

        $this->handle(...$parameters);
    }
}
