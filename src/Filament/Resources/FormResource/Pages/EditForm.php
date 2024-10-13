<?php

namespace Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Hydrat\GroguCMS\Filament\Resources\FormResource;

class EditForm extends EditRecord
{
    protected static string $resource = FormResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
