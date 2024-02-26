<?php

namespace Hydrat\GroguCMS\Templates;

use App\Models;
use Hydrat\GroguCMS\Layouts;

class Projects extends Template
{
    protected string $name = 'projects';

    protected ?string $view = 'pages/Projects/Projects';

    protected array $for = [
        Models\Page::class,
    ];

    public function label(): string
    {
        return __('Projects');
    }

    public function blocks(): array
    {
        return [
            // Layouts\ListingProjects::create(),
        ];
    }
}
