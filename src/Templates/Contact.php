<?php

namespace Hydrat\GroguCMS\Templates;

use App\Models;
use Hydrat\GroguCMS\Layouts;

class Contact extends Template
{
    protected string $name = 'contact';

    protected ?string $view = 'pages/Contact/Contact';

    protected array $for = [
        Models\Page::class,
    ];

    public function label(): string
    {
        return __('Contact');
    }

    public function blocks(): array
    {
        return [
          // Layouts\Contact::create(),
        ];
    }
}
