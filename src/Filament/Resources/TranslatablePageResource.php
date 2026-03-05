<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Resources\Pages\Page as FilamentPage;
use Hydrat\FilamentLexiTranslate\Resources\Concerns\Translatable;
use Hydrat\GroguCMS\Filament\Resources\TranslatablePageResource\Pages;

class TranslatablePageResource extends PageResource
{
    use Translatable;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTranslatablePages::route('/'),
            'create' => Pages\CreateTranslatablePage::route('/create'),
            'edit' => Pages\EditTranslatablePage::route('/{record}/edit'),
            'content' => Pages\EditTranslatablePageContent::route('/{record}/content'),
            'seo' => Pages\EditTranslatablePageSeo::route('/{record}/seo'),
        ];
    }

    public static function getRecordSubNavigation(FilamentPage $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditTranslatablePage::class,
            Pages\EditTranslatablePageContent::class,
            Pages\EditTranslatablePageSeo::class,
        ]);
    }
}
