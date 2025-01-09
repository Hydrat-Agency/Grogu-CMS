<?php

namespace Hydrat\GroguCMS\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\Sitemap\Tags\Url;

interface BlueprintContract
{
    public function hasRecord(): bool;

    public function record(): ?Model;

    public function view(): ?string;

    public function model(): string;

    public function modelSingularName(): string;

    public function modelPluralName(): string;

    public function templates(): array;

    public function hierarchical(): bool;

    public function computeHierarchicalPath(?Model $record = null): ?string;

    public function routeName(): ?string;

    public function frontUri(bool $includeSelf = true): ?string;

    public function frontUrl(bool $includeSelf = true): ?string;

    public function sitemapEntry(): Url|string|array|null;

    public function bindRouteParameters(): array;

    public function hasTemplates(): bool;

    public function hasMandatoryTemplate(): bool;

    public function hasDefaultTemplate(): bool;

    public function getTemplates(): Collection;

    public function hasExcerpt(): bool;

    public function hasSeo(): bool;

    public function hasContent(): bool;

    public function hasBlocks(): bool;

    public function blocks(): array;
}
