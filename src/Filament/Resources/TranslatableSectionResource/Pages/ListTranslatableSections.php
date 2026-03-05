<?php

namespace Hydrat\GroguCMS\Filament\Resources\TranslatableSectionResource\Pages;

use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\ListRecords\Concerns\Translatable;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages\ListSections;
use Hydrat\GroguCMS\Filament\Resources\TranslatableSectionResource;

class ListTranslatableSections extends ListSections
{
    use Translatable;

    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.section_resource') ?: TranslatableSectionResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [
            ...(GroguCMS::isTranslatableEnabled() ? [LocaleSwitcher::make()] : []),
            ...parent::getHeaderActions(),
        ];
    }
}
