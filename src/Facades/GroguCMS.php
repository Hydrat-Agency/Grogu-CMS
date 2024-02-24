<?php

namespace Hydrat\GroguCMS\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hydrat\GroguCMS\GroguCMS
 */
class GroguCMS extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Hydrat\GroguCMS\GroguCMS::class;
    }
}
