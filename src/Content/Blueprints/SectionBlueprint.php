<?php

namespace Hydrat\GroguCMS\Content\Blueprints;

use Hydrat\GroguCMS\Models\Section;
use Hydrat\GroguCMS\Content\Blueprint;

class SectionBlueprint extends Blueprint
{
    protected ?string $view = 'sections.show';

    protected ?string $routeName = 'sections.show';

    protected bool $hierarchical = false;

    public function model(): string
    {
        return config('grogu-cms.models.section') ?? Section::class;
    }

    public function blocks(): array
    {
        return [
            //
        ];
    }
}
