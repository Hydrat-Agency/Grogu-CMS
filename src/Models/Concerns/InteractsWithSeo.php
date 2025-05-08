<?php

namespace Hydrat\GroguCMS\Models\Concerns;

use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Collection;
use Vormkracht10\Seo\Traits\HasSeoScore;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use RalphJSmit\Laravel\SEO\Support\AlternateTag;
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

    public function getAlternates(): Collection
    {
        return $this->blueprint()->alternates(includeCurrentLocale: true);
    }

    public function getDynamicSEOData(): SEOData
    {
        $this->loadMissing('seo', 'user');

        $imageUrl = null;

        if (filled($mediaId = $this->seo?->image)) {
            $imageUrl = MediaLibraryItem::with('folder')->find($mediaId)?->getItem()?->getUrl();
        }

        return new SEOData(
            title: $this->seo?->title ?: grogu_translate($this, 'title'),
            description: $this->seo?->description ?: grogu_translate($this, 'excerpt'),
            author: $this->user?->name,
            robots: $this->seo?->robots,
            image: $imageUrl ?: $this->thumbnail?->getItem()?->getUrl(),
            alternates: $this->getAlternates()
                ->map(fn ($alternate) => new AlternateTag($alternate->locale, $alternate->url))
                ->toArray(),
        );
    }
}
