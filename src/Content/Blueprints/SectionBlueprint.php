<?php

namespace Hydrat\GroguCMS\Content\Blueprints;

use Hydrat\GroguCMS\Content\Blueprint;

class SectionBlueprint extends Blueprint
{
    protected ?string $view = 'sections.show';

    protected ?string $routeName = 'sections.show';

    protected bool $hierarchical = false;

    public function model(): string
    {
        return config('grogu-cms.models.section') ?? \Hydrat\GroguCMS\Models\Section::class;
    }

    public function blocks(): array
    {
        return [
            //
        ];
    }
}
