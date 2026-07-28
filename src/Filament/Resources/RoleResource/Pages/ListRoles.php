<?php

namespace Hydrat\GroguCMS\Filament\Resources\RoleResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Hydrat\GroguCMS\Filament\Resources\RoleResource;

class ListRoles extends ListRecords
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
            CreateAction::make(),
        ];
    }
}
