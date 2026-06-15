<?php

namespace Hydrat\GroguCMS\Filament\Resources\UserResource\Pages;

use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Hydrat\GroguCMS\Filament\Resources\UserResource;
use Illuminate\Support\Arr;

class EditUser extends EditRecord
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.user_resource') ?: UserResource::class;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        Arr::forget($data, ['email']);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
