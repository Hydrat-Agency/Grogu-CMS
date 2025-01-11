<?php

namespace Hydrat\GroguCMS\Filament\Resources\PageResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Hydrat\GroguCMS\Filament\Resources\PageResource;

class CreatePage extends CreateRecord
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.page_resource') ?: PageResource::class;
    }
}
