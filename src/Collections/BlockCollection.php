<?php

namespace Hydrat\GroguCMS\Collections;

use Hydrat\GroguCMS\Datas\Block;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Illuminate\Support\Collection;

class BlockCollection extends Collection
{
    public static function fromArray(array $blocks, bool $shouldCompose = true): self
    {
        return static::make($blocks)
            ->map(fn ($block) => Block::fromArray($block))
            ->when($shouldCompose, fn ($blocks) => $blocks->compose());
    }

    public function compose()
    {
        return $this->map(function ($block) {
            foreach (GroguCMS::getBlockComposers($block->type) as $composer) {
                with(new $composer)->compose($block);
            }

            return $block;
        });
    }

    public static function fromString(string $blocks): self
    {
        return static::fromArray(
            json_decode($blocks, true)
        );
    }
}
