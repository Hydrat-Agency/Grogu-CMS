<?php

namespace Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages;

use Hydrat\GroguCMS\Filament\Resources\SectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSections extends ListRecords
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.section_resource') ?: SectionResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
