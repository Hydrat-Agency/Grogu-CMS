<?php

namespace Hydrat\GroguCMS\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Hydrat\GroguCMS\Filament\Resources\UserResource;

class ListUsers extends ListRecords
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.user_resource') ?: UserResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
