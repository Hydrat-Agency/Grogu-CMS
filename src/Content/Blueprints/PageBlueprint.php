<?php

namespace Hydrat\GroguCMS\Content\Blueprints;

use Hydrat\GroguCMS\Content\Blueprint;

class PageBlueprint extends Blueprint
{
    protected ?string $view = 'pages.show';

    protected ?string $routeName = 'pages.show';

    protected bool $hierarchical = true;

    protected array $templates = [
        //
    ];

    public function model(): string
    {
        return config('grogu-cms.models.page') ?? \Hydrat\GroguCMS\Models\Page::class;
    }
}
