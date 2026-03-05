<?php

namespace Hydrat\GroguCMS\Filament\Resources\TranslatableFormResource\Pages;

use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\ListRecords\Concerns\Translatable;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\ListForms;
use Hydrat\GroguCMS\Filament\Resources\TranslatableFormResource;

class ListTranslatableForms extends ListForms
{
    use Translatable;

    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.form_resource') ?: TranslatableFormResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [
            ...(GroguCMS::isTranslatableEnabled() ? [LocaleSwitcher::make()] : []),
            ...parent::getHeaderActions(),
        ];
    }
}
