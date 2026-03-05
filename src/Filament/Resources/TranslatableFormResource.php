<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Resources\Pages\Page;
use Hydrat\FilamentLexiTranslate\Resources\Concerns\Translatable;
use Hydrat\GroguCMS\Filament\Resources\TranslatableFormResource\Pages;

class TranslatableFormResource extends FormResource
{
    use Translatable;

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTranslatableForms::route('/'),
            'create' => Pages\CreateTranslatableForm::route('/create'),
            'edit' => Pages\EditTranslatableForm::route('/{record}/edit'),
            'fields' => Pages\ManageTranslatableFormFields::route('/{record}/fields'),
            'entries' => \Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\ManageFormEntries::route('/{record}/entries'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditTranslatableForm::class,
            Pages\ManageTranslatableFormFields::class,
            \Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\ManageFormEntries::class,
        ]);
    }
}
