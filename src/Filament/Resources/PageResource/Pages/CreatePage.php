<?php

namespace Hydrat\GroguCMS\Filament\Resources\PageResource\Pages;

use Hydrat\GroguCMS\Facades\GroguCMS;
use Filament\Resources\Pages\CreateRecord;
use Hydrat\GroguCMS\Filament\Resources\PageResource;
use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreatePage extends CreateRecord
{
    use Translatable;

    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.page_resource') ?: PageResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [
            ...(GroguCMS::isTranslatableEnabled() ? [LocaleSwitcher::make()] : []),
        ];
    }
}
