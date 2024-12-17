<?php

namespace Hydrat\GroguCMS\Models\Contracts;

use Hydrat\GroguCMS\Collections\BlockCollection;
use Illuminate\Support\Collection;

interface HasBlocks
{
    public function getBlocks(): ?BlockCollection;
    public function setBlocks(?BlockCollection $blocks = null): static;
}
