<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Hydrat\GroguCMS\Filament\Resources\TranslatableSectionResource\Pages\ListTranslatableSections;
use Hydrat\GroguCMS\Filament\Resources\TranslatableSectionResource\Pages\CreateTranslatableSection;
use Hydrat\GroguCMS\Filament\Resources\TranslatableSectionResource\Pages\EditTranslatableSection;
use Hydrat\FilamentLexiTranslate\Resources\Concerns\Translatable;
use Hydrat\GroguCMS\Filament\Resources\TranslatableSectionResource\Pages;

class TranslatableSectionResource extends SectionResource
{
    use Translatable;

    public static function getPages(): array
    {
        return [
            'index' => ListTranslatableSections::route('/'),
            'create' => CreateTranslatableSection::route('/create'),
            'edit' => EditTranslatableSection::route('/{record}/edit'),
        ];
    }
}
