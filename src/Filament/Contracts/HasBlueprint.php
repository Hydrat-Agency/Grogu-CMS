<?php

namespace Hydrat\GroguCMS\Filament\Contracts;

use Hydrat\GroguCMS\Contracts\BlueprintContract;

interface HasBlueprint
{
    public static function getBlueprint($filament = null): BlueprintContract;
}
