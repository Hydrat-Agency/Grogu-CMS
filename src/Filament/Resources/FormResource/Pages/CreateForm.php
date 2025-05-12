<?php

namespace Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;

use Hydrat\GroguCMS\Facades\GroguCMS;
use Filament\Resources\Pages\CreateRecord;
use Hydrat\GroguCMS\Filament\Resources\FormResource;
use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateForm extends CreateRecord
{
    use Translatable;

    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.form_resource') ?: FormResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [
            ...(GroguCMS::isTranslatableEnabled() ? [LocaleSwitcher::make()] : []),
        ];
    }
}
