<?php

namespace Hydrat\GroguCMS\Filament\Resources\RoleResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Hydrat\GroguCMS\Filament\Resources\RoleResource;

class EditRole extends EditRecord
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.role_resource') ?: RoleResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()->visible(fn () => $this->record->getKey() !== 1),
        ];
    }
}
