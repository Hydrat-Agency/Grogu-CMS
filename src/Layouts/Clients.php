<?php

namespace Hydrat\GroguCMS\Layouts;

use Filament\Forms;

class Clients extends Layout
{
    public function configureLayout(Layout $layout): Layout
    {
        return $layout
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required(),

                Forms\Components\Textarea::make('text')
                    ->required()
                    ->autosize()
                    ->rows(3),

                Forms\Components\TagsInput::make('clients')
                    ->reorderable(),
            ]);
    }
}
