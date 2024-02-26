<?php

namespace Hydrat\GroguCMS\Models\Concerns;

use Vormkracht10\Seo\Traits\HasSeoScore;

trait InteractsWithSeo
{
    use HasSeoScore;

    public function getUrlAttribute(): string
    {
        return $this->blueprint()->frontUrl();
    }
}
