<?php

namespace Hydrat\GroguCMS\Filament\Resources\CmsResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\IconPosition;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Blade;

abstract class EditPage extends EditRecord
{
    public function getSubheading(): string | Htmlable | null
    {
        $blueprint = $this->getResource()::getBlueprint($this);
        $url = $blueprint->frontUrl();

        $status = $this->record->published_at ? __('Published') : __('Draft');
        $color = $this->record->published_at ? 'success' : 'warning';

        return new HtmlString(Blade::render(<<<"blade"
            <x-filament::badge color="$color" class="inline-flex">
                $status
            </x-filament::badge>

            <x-filament::link
                href="$url"
                size="sm"
                color="primary"
                icon="heroicon-m-arrow-up-right"
                icon-position="after"
                target="_blank"
                class="pl-1"
            >
                $url
            </x-filament::link>
        blade));
    }

    protected function getHeaderActions(): array
    {
        // $blueprint = $this->getResource()::getBlueprint($this);

        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
            // Actions\Action::make('visit')
            //     ->url(fn () => $blueprint->frontUrl())
            //     ->openUrlInNewTab()
            //     ->icon('heroicon-m-arrow-up-right')
            //     ->iconPosition(IconPosition::After),
        ];
    }
}
