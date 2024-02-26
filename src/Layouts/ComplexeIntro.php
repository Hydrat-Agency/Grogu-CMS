<?php

namespace Hydrat\GroguCMS\Layouts;

use Filament\Forms;

class ComplexeIntro extends Layout
{
    public function configureLayout(Layout $layout): Layout
    {
        return $layout
            ->columns(2)
            ->schema([
                Forms\Components\TextInput::make('surtitle')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Textarea::make('title')
                    ->required()
                    ->autosize()
                    ->rows(4),

                Forms\Components\Textarea::make('text')
                    ->required()
                    ->autosize()
                    ->rows(4),

                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->columnSpanFull(),
            ]);
    }
}
