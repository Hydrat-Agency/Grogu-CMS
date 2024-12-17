<?php

namespace Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Hydrat\GroguCMS\Filament\Resources\SectionResource;

class CreateSection extends CreateRecord
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.section_resource') ?: SectionResource::class;
    }
}
