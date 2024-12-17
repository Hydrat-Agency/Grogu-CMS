<?php

namespace Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages;

use Hydrat\GroguCMS\Filament\Resources\SectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

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
