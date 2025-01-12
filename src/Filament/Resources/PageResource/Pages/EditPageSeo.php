<?php

namespace Hydrat\GroguCMS\Filament\Resources\PageResource\Pages;

use Hydrat\GroguCMS\Filament\Resources\CmsResource\Pages\EditRecordSeo;
use Hydrat\GroguCMS\Filament\Resources\PageResource;

class EditPageSeo extends EditRecordSeo
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.page_resource') ?: PageResource::class;
    }
}
