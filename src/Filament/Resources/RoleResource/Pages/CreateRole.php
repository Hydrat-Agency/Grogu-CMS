<?php

namespace Hydrat\GroguCMS\Filament\Resources\RoleResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Hydrat\GroguCMS\Filament\Resources\RoleResource;

class CreateRole extends CreateRecord
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.role_resource') ?: RoleResource::class;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['guard_name'] = config('grogu-cms.users.guard');

        return $data;
    }
}
