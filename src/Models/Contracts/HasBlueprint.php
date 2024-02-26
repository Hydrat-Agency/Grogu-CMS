<?php

namespace Hydrat\GroguCMS\Models\Contracts;

use Hydrat\GroguCMS\Contracts\BlueprintContract;

interface HasBlueprint
{
    public static function blueprintSchema(): ?string;

    public function blueprint(): BlueprintContract;
}
