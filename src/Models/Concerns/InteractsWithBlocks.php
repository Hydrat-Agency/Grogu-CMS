<?php

namespace Hydrat\GroguCMS\Models\Concerns;

use Hydrat\GroguCMS\Collections\BlockCollection;
use Illuminate\Support\Collection;

trait InteractsWithBlocks
{
    protected ?BlockCollection $blockCollection = null;

    public function getBlocks(): ?BlockCollection
    {
        if (filled($this->blockCollection)) {
            return $this->blockCollection;
        }

        $blocks = method_exists($this, 'translate') && $this->isTranslatableAttribute('blocks')
            ? $this->translate('blocks', useFallbackLocale: true)
            : $this->blocks;

        if (blank($blocks)) {
            return null;
        }

        if (is_a($blocks, Collection::class)) {
            return tap(BlockCollection::fromArray($blocks->toArray()),
                fn ($blocks) => $this->setBlocks($blocks)
            );
        }

        return tap(BlockCollection::fromArray($blocks),
            fn ($blocks) => $this->setBlocks($blocks)
        );
    }

    public function setBlocks(?BlockCollection $blocks = null): static
    {
        $this->blockCollection = $blocks;

        return $this;
    }
}
