<?php

namespace Hydrat\GroguCMS\Filament\Resources\TranslatableFormResource\Pages;

use Hydrat\FilamentLexiTranslate\Resources\RelationManagers\Concerns\Translatable;
use Hydrat\FilamentLexiTranslate\Tables\Actions\LocaleSwitcher;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\ManageFormFields;
use Hydrat\GroguCMS\Filament\Resources\TranslatableFormResource;

class ManageTranslatableFormFields extends ManageFormFields
{
    use Translatable;

    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.form_resource') ?: TranslatableFormResource::class;
    }

    protected function beforeTableHeaderActions(): array
    {
        return GroguCMS::isTranslatableEnabled() ? [LocaleSwitcher::make()] : [];
    }
}
