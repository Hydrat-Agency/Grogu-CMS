<?php

namespace Hydrat\GroguCMS\Layouts;

use Filament\Forms;

class Heading extends Layout
{
    public function configureLayout(Layout $layout): Layout
    {
        return $layout
            ->columns(2)
            ->schema([
                Forms\Components\TextInput::make('content')
                    ->label('Heading')
                    ->required(),

                Forms\Components\Select::make('level')
                    ->required()
                    ->options([
                        'h1' => 'Heading 1',
                        'h2' => 'Heading 2',
                        'h3' => 'Heading 3',
                        'h4' => 'Heading 4',
                        'h5' => 'Heading 5',
                        'h6' => 'Heading 6',
                    ]),
            ]);
    }
}
