<?php

namespace Hydrat\GroguCMS\Models\Concerns;

use Vormkracht10\Seo\Traits\HasSeoScore;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Spatie\Sitemap\Tags\Url;

trait InteractsWithSeo
{
    use HasSeoScore;
    use HasSEO;

    public function getUrlAttribute(): string
    {
        return $this->blueprint()->frontUrl();
    }

    public function toSitemapTag(): Url | string | array
    {
        return $this->blueprint()->sitemapEntry();
    }

    public function getDynamicSEOData(): SEOData
    {
        $this->loadMissing('seo', 'user');

        return new SEOData(
            title: $this->seo?->title ?: $this->title,
            description: $this->seo?->description ?: $this->excerpt,
            author: $this->user?->name,
            robots: $this->seo?->robots,
            // alternates: [
            //     new AlternateTag(
            //         hreflang: 'en',
            //         href: "https://example.com/en",
            //     ),
            //     new AlternateTag(
            //         hreflang: 'fr',
            //         href: "https://example.com/fr",
            //     ),
            // ],
        );
    }
}
