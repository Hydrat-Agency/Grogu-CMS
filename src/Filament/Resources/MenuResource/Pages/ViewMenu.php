<?php

namespace Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Hydrat\GroguCMS\Filament\Resources\MenuResource;
use App\Filament\Resources\MenuResource\Widgets\MenuItemTree;

class ViewMenu extends ViewRecord
{
    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make('edit'),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            MenuResource\Widgets\MenuItemTreeWidget::class,
        ];
    }
}
