<?php

namespace Hydrat\GroguCMS\Filament\Resources\PageResource\Pages;

use Hydrat\GroguCMS\Filament\Resources\CmsResource\Pages\EditRecordContent;
use Hydrat\GroguCMS\Filament\Resources\PageResource;

class EditPageContent extends EditRecordContent
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.page_resource') ?: PageResource::class;
    }
}
