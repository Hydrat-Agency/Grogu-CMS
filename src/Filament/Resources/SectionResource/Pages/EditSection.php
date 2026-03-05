<?php

namespace Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Hydrat\GroguCMS\Filament\Resources\SectionResource;

class EditSection extends EditRecord
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.section_resource') ?: SectionResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
