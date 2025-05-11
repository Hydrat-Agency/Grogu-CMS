<?php

namespace Hydrat\GroguCMS\Providers;

use Filament\Actions\Action;
use Filament\Actions\StaticAction;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Placeholder;
use Filament\Infolists\Components\Entry;
use Filament\Tables\Actions\Action as TableAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Illuminate\Support\ServiceProvider;

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

        Column::macro('translatable', function (): Column {
            /** @var Column $this */
            $name = $this->getName();

            return $this->formatStateUsing(function ($record, $livewire) use ($name) {
                $blueprint = $record->blueprint();
                $locale = $blueprint && $blueprint->translatable() && method_exists($livewire, 'getActiveActionsLocale')
                    ? $livewire->getActiveActionsLocale()
                    : null;

                return $record->translate($name, $locale);
            });
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

        // LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
        //     $switch->locales(['en', 'fr']);
        // });
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
