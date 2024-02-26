<?php

namespace Hydrat\GroguCMS\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Hydrat\GroguCMS\Contracts\BlueprintContract;

trait InteractsWithBlueprint
{
    public static function blueprintSchema(): ?string
    {
        return static::$blueprintSchema ?? null;
    }

    public static function blueprintInstance(?Model $model = null): BlueprintContract
    {
        if (!($class = static::blueprintSchema()) || !class_exists($class)) {
            throw new \Exception("Target Blueprint class {$class} does not exist.");
        }

        return new $class($model);
    }

    public function blueprint(): BlueprintContract
    {
        return static::blueprintInstance($this);
    }
}
