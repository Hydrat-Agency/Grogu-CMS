<?php

namespace Hydrat\GroguCMS\Models\Contracts;

use Illuminate\Http\Resources\Json\JsonResource;

interface Resourceable
{
    public function toResource(): JsonResource;
}
