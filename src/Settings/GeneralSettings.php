<?php

namespace Hydrat\GroguCMS\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $website_name;

    public ?string $website_logo = '';

    public ?int $front_page;

    public string $date_format;

    public static function group(): string
    {
        return 'general';
    }
}