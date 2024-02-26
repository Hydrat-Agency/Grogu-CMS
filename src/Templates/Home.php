<?php

namespace Hydrat\GroguCMS\Templates;

use App\Models;
use Hydrat\GroguCMS\Layouts;

class Home extends Template
{
    protected string $name = 'home';

    protected ?string $view = 'pages/Home/Home';

    protected array $for = [
        Models\Page::class,
    ];

    public function label(): string
    {
        return __('Home');
    }

    public function blocks(): array
    {
        return [
            Layouts\Projects::create(),
            Layouts\HighlightedIntro::create(),
            Layouts\FloatingLabels::create(),
            Layouts\ProjectMesh::create(),
            Layouts\CtaText::create(),
        ];
    }
}
