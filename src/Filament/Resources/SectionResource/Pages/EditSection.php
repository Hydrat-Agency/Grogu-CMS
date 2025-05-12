<?php

namespace Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\EditRecord\Concerns\Translatable;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\SectionResource;

class EditSection extends EditRecord
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
            Actions\DeleteAction::make(),
        ];
    }
}
