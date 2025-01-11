<?php

namespace Hydrat\GroguCMS\Filament\Resources\UserResource\Pages;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Hydrat\GroguCMS\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.user_resource') ?: UserResource::class;
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        Arr::set($data, 'password', Hash::make(Str::random(30)));

        return $data;
    }
}
