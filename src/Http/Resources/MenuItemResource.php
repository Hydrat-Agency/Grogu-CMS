<?php

namespace Hydrat\GroguCMS\Http\Resources;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return Arr::only(parent::toArray($request), [
            'title',
            'url',
            'external',
            'new_tab',
        ]);
    }
}
