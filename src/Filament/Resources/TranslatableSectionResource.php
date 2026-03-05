<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Hydrat\FilamentLexiTranslate\Resources\Concerns\Translatable;
use Hydrat\GroguCMS\Filament\Resources\TranslatableSectionResource\Pages;

class TranslatableSectionResource extends SectionResource
{
    use Translatable;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTranslatableSections::route('/'),
            'create' => Pages\CreateTranslatableSection::route('/create'),
            'edit' => Pages\EditTranslatableSection::route('/{record}/edit'),
        ];
    }
}
