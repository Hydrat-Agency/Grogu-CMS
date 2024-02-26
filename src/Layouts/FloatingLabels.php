<?php

namespace Hydrat\GroguCMS\Layouts;

use Filament\Forms;

class FloatingLabels extends Layout
{
    public function configureLayout(Layout $layout): Layout
    {
        return $layout
            ->columns(1)
            ->schema([
                Forms\Components\Repeater::make('labels')
                    ->schema([
                        Forms\Components\TextInput::make('label')
                            ->label('Label')
                            ->required(),
                    ]),
            ]);
    }
}
