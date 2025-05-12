<?php

namespace Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\ListRecords\Concerns\Translatable;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\FormResource;

class ListForms extends ListRecords
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
            Actions\CreateAction::make(),
        ];
    }
}
