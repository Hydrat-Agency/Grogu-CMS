<?php

namespace Hydrat\GroguCMS\Filament\Resources\TranslatableFormResource\Pages;

use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\CreateRecord\Concerns\Translatable;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\CreateForm;
use Hydrat\GroguCMS\Filament\Resources\TranslatableFormResource;

class CreateTranslatableForm extends CreateForm
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
