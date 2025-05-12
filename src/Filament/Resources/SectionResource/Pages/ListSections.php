<?php

namespace Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages;

use Filament\Actions;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Filament\Resources\Pages\ListRecords;
use Hydrat\GroguCMS\Filament\Resources\SectionResource;
use Hydrat\FilamentLexiTranslate\Resources\Pages\ListRecords\Concerns\Translatable;

class ListSections extends ListRecords
{
    use Translatable;

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
            ...(GroguCMS::isTranslatableEnabled() ? [LocaleSwitcher::make()] : []),
            Actions\CreateAction::make(),
        ];
    }
}
