<?php

namespace Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;

use Filament\Actions;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Filament\Resources\Pages\EditRecord;
use Hydrat\GroguCMS\Filament\Resources\FormResource;
use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\EditRecord\Concerns\Translatable;

class EditForm extends EditRecord
{
    use Translatable;

    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.form_resource') ?: FormResource::class;
    }

    public static function getNavigationLabel(): string
    {
        return __('Form');
    }

    protected function getHeaderActions(): array
    {
        return [
            ...(GroguCMS::isTranslatableEnabled() ? [LocaleSwitcher::make()] : []),
            Actions\DeleteAction::make(),
        ];
    }
}
