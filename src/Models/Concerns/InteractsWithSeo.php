<?php

namespace Hydrat\GroguCMS\Models\Concerns;

use Spatie\Sitemap\Tags\Url;
use Vormkracht10\Seo\Traits\HasSeoScore;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Filament\MediaLibrary\Media\Models\MediaLibraryItem;

trait InteractsWithSeo
{
    use HasSEO;
    use HasSeoScore;

    public function getUrlAttribute(): string
    {
        return $this->blueprint()->frontUrl();
    }

    public function toSitemapTag(): Url|string|array
    {
        return $this->blueprint()->sitemapEntry() ?: '';
    }

    public function getDynamicSEOData(): SEOData
    {
        $this->loadMissing('seo', 'user');

        $imageUrl = null;

        if (filled($mediaId = $this->seo?->image)) {
            $imageUrl = MediaLibraryItem::with('folder')->find($mediaId)?->getItem()?->getUrl();
        }

        return new SEOData(
            title: $this->seo?->title ?: $this->title,
            description: $this->seo?->description ?: $this->excerpt,
            author: $this->user?->name,
            robots: $this->seo?->robots,
            image: $imageUrl ?: $this->thumbnail?->getItem()?->getUrl(),
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
