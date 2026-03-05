<?php

namespace Hydrat\GroguCMS\Filament\Resources\TranslatablePageResource\Pages;

use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\ListRecords\Concerns\Translatable;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\PageResource\Pages\ListPages;
use Hydrat\GroguCMS\Filament\Resources\TranslatablePageResource;

class ListTranslatablePages extends ListPages
{
    use Translatable;

    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.page_resource') ?: TranslatablePageResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [
            ...(GroguCMS::isTranslatableEnabled() ? [LocaleSwitcher::make()] : []),
            ...parent::getHeaderActions(),
        ];
    }
}
