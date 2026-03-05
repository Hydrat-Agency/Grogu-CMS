<?php

namespace Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Hydrat\GroguCMS\Filament\Resources\FormResource;

class ListForms extends ListRecords
{
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
            Actions\CreateAction::make(),
        ];
    }
}
