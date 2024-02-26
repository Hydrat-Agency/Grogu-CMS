<?php

namespace Hydrat\GroguCMS\Providers;

use Filament\Actions\Action;
use Filament\Actions\StaticAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Filament\Forms\Components\Component;
use Filament\Infolists\Components\Entry;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\ServiceProvider;
use Filament\Tables\Actions\Action as TableAction;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        TableAction::macro('iconSoftButton', function (string $icon): TableAction {
            /** @var TableAction $this */
            return $this->outlined()
                ->iconButton()
                ->icon($icon)
                ->extraAttributes([
                    'class' => 'table-soft-btn',
                ]);
        });

        $this->autoTranslateLabels([
            BaseFilter::class,
            Placeholder::class,
            Column::class,
            Component::class,
            Entry::class,
            Action::class,
            StaticAction::class,
        ]);
    }

    private function autoTranslateLabels(array $components = [])
    {
        foreach ($components as $component) {
            $component::configureUsing(function ($c): void {
                $c->translateLabel();
            });
        }
    }
}
