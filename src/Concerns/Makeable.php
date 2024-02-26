<?php

namespace Hydrat\GroguCMS\Concerns;

trait Makeable
{
    public static function make(...$args): static
    {
        return new static(...$args);
    }
}
