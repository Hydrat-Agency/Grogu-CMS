<?php

namespace Hydrat\GroguCMS\Blueprints;

class PageBlueprint extends Blueprint
{
    protected string $model = \App\Models\Page::class;

    protected ?string $view = 'pages.show';

    protected ?string $routeName = 'pages.show';

    protected bool $hierarchical = true;

    protected array $templates = [
        //
    ];
}
