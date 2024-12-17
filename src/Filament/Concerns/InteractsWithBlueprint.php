<?php

namespace Hydrat\GroguCMS\Filament\Concerns;

use Hydrat\GroguCMS\Contracts\BlueprintContract;
use Hydrat\GroguCMS\Exceptions\BlueprintMissingException;
use Hydrat\GroguCMS\Models\Concerns\HasBlueprint as ModelHasBlueprint;
use Throwable;
use Symfony\Component\Routing\Exception\InvalidParameterException;

trait InteractsWithBlueprint
{
    public static function getBlueprint($filament = null): BlueprintContract
    {
        $model = static::getModel();

        try {
            $record = $filament->getRecord();
        } catch (Throwable $e) {
            $record = null;
        }

        if ($record && ! ($record instanceof $model)) {
            throw new InvalidParameterException('The component record does not match the resource model.');
        }

        if (! in_array(ModelHasBlueprint::class, class_implements($model))) {
            throw new BlueprintMissingException(sprintf('The `%s` model must implement the `%s` contract.', $model, HasBlueprint::class));
        }

        return $model::blueprintInstance($record);
    }
}
