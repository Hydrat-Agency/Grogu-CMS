<?php

namespace Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages;

use Filament\Actions;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Filament\Resources\Pages\EditRecord;
use Hydrat\GroguCMS\Filament\Resources\SectionResource;
use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\FilamentLexiTranslate\Resources\Pages\EditRecord\Concerns\Translatable;

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
