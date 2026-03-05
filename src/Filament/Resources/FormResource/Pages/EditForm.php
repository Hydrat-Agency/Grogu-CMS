<?php

namespace Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Hydrat\GroguCMS\Filament\Resources\FormResource;

class EditForm extends EditRecord
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.form_resource') ?: FormResource::class;
    }

    public static function getNavigationLabel(): string
    {
        return __('Form');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
