<?php

namespace Hydrat\GroguCMS;

use Hydrat\GroguCMS\Concerns\Makeable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Route;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class UrlManager
{
    use Makeable;

    public function getBindedUri(Route $route, array $parameters = []): string
    {
        $routeParameters = $route->parameterNames();
        $bindingFields = $route->bindingFields();
        $uri = $route->uri();
        $binded = [];

        foreach ($routeParameters as $routeParameterName) {
            $parameter = Arr::get($parameters, $routeParameterName);

            if ($parameter && is_a($parameter, Model::class)) {
                $parameter = $this->parseModelParameter($parameter, Arr::get($bindingFields, $routeParameterName));
            }

            $binded[$routeParameterName] = $parameter ?: '';
        }

        foreach ($binded as $parameterName => $parameterValue) {
            $uri = str_replace('{'.$parameterName.'}', $parameterValue, $uri);
        }

        return Str::start($uri, '/');
    }

    public function parseModelParameter(Model $record, ?string $bindingField = null)
    {
        $bindingField ??= $record->getRouteKeyName();

        return $record->{$bindingField};
    }
}
