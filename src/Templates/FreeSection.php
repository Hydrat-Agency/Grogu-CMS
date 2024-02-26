<?php

namespace Hydrat\GroguCMS\Templates;

use App\Models;
use Hydrat\GroguCMS\Layouts;

class FreeSection extends Template
{
    protected string $name = 'free_section';

    protected ?string $view = 'pages/FreeSection/FreeSection';

    protected array $for = [
        Models\Page::class,
    ];

    public function label(): string
    {
        return __('Free section');
    }

    public function blocks(): array
    {
        return [
            Layouts\Heading::create(),
            Layouts\HighlightedIntro::create(),
            Layouts\ComplexeIntro::create(),
            Layouts\CtaText::create(),
            Layouts\FloatingLabels::create(),
            Layouts\Accordion::create(),
            Layouts\ProjectMesh::create(),
            Layouts\Clients::create(),
        ];
    }
}
