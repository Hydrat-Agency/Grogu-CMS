<?php

namespace Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\CreateRecord\Concerns\Translatable;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\SectionResource;

class CreateSection extends CreateRecord
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
        ];
    }
}
