<?php

namespace Hydrat\GroguCMS\Filament\Resources\PageResource\Pages;

use Hydrat\GroguCMS\Filament\Resources\CmsResource\Pages\EditRecordContent;
use Hydrat\GroguCMS\Filament\Resources\PageResource;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\EditRecord\Concerns\Translatable;

class EditPageContent extends EditRecordContent
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
