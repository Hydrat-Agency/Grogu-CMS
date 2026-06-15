<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Resources\Pages\Page;
use Hydrat\FilamentLexiTranslate\Resources\Concerns\Translatable;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\ManageFormEntries;
use Hydrat\GroguCMS\Filament\Resources\TranslatableFormResource\Pages\CreateTranslatableForm;
use Hydrat\GroguCMS\Filament\Resources\TranslatableFormResource\Pages\EditTranslatableForm;
use Hydrat\GroguCMS\Filament\Resources\TranslatableFormResource\Pages\ListTranslatableForms;
use Hydrat\GroguCMS\Filament\Resources\TranslatableFormResource\Pages\ManageTranslatableFormFields;

class TranslatableFormResource extends FormResource
{
    use Translatable;

    public static function getPages(): array
    {
        return [
            'index' => ListTranslatableForms::route('/'),
            'create' => CreateTranslatableForm::route('/create'),
            'edit' => EditTranslatableForm::route('/{record}/edit'),
            'fields' => ManageTranslatableFormFields::route('/{record}/fields'),
            'entries' => ManageFormEntries::route('/{record}/entries'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            EditTranslatableForm::class,
            ManageTranslatableFormFields::class,
            ManageFormEntries::class,
        ]);
    }
}
