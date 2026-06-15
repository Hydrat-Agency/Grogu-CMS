<?php

namespace Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages;

use Filament\Actions\EditAction;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\Widgets\MenuItemTreeWidget;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Hydrat\GroguCMS\Filament\Resources\MenuResource;

class ViewMenu extends ViewRecord
{
    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.menu_resource') ?: MenuResource::class;
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make('edit'),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            MenuItemTreeWidget::class,
        ];
    }
}
