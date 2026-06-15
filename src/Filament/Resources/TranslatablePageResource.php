<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Resources\Pages\Page as FilamentPage;
use Hydrat\FilamentLexiTranslate\Resources\Concerns\Translatable;
use Hydrat\GroguCMS\Filament\Resources\TranslatablePageResource\Pages\CreateTranslatablePage;
use Hydrat\GroguCMS\Filament\Resources\TranslatablePageResource\Pages\EditTranslatablePage;
use Hydrat\GroguCMS\Filament\Resources\TranslatablePageResource\Pages\EditTranslatablePageContent;
use Hydrat\GroguCMS\Filament\Resources\TranslatablePageResource\Pages\EditTranslatablePageSeo;
use Hydrat\GroguCMS\Filament\Resources\TranslatablePageResource\Pages\ListTranslatablePages;

class TranslatablePageResource extends PageResource
{
    use Translatable;

    public static function getPages(): array
    {
        return [
            'index' => ListTranslatablePages::route('/'),
            'create' => CreateTranslatablePage::route('/create'),
            'edit' => EditTranslatablePage::route('/{record}/edit'),
            'content' => EditTranslatablePageContent::route('/{record}/content'),
            'seo' => EditTranslatablePageSeo::route('/{record}/seo'),
        ];
    }

    public static function getRecordSubNavigation(FilamentPage $page): array
    {
        return $page->generateNavigationItems([
            EditTranslatablePage::class,
            EditTranslatablePageContent::class,
            EditTranslatablePageSeo::class,
        ]);
    }
}
