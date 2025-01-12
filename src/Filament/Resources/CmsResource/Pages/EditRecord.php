<?php

namespace Hydrat\GroguCMS\Filament\Resources\CmsResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Hydrat\GroguCMS\Contracts\BlueprintContract;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

abstract class EditPage extends EditRecord
{
    public static function getBlueprint($filament = null): BlueprintContract
    {
        return static::getResource()::getBlueprint($filament);
    }

    public function getSubheading(): string|Htmlable|null
    {
        $blueprint = $this->getResource()::getBlueprint($this);
        $url = $blueprint->frontUrl();

        $label = $this->record->status->getLabel();
        $color = $this->record->status->getColor();
        $icon = $this->record->status->getIcon();

        return new HtmlString(Blade::render(<<<"blade"
            <x-filament::badge color="$color" class="inline-flex align-middle" icon="$icon">
                $label
            </x-filament::badge>

            <x-filament::link
                href="$url"
                size="sm"
                color="primary"
                icon="heroicon-m-arrow-up-right"
                icon-position="after"
                target="_blank"
                class="pl-1 align-middle"
            >
                $url
            </x-filament::link>
        blade));
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
