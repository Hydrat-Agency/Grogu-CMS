<?php

namespace Hydrat\GroguCMS\Layouts;

use Filament\Forms;

class HighlightedIntro extends Layout
{
    public function configureLayout(Layout $layout): Layout
    {
        return $layout
            ->columns(1)
            ->schema([
                Forms\Components\RichEditor::make('highlighted_intro')
                    ->label('Texte')
                    ->required(),

                Forms\Components\Fieldset::make('CTA')
                    ->columns(4)
                    ->schema([
                        Forms\Components\TextInput::make('link')
                            ->label('Link')
                            ->columnSpan(2),

                        Forms\Components\TextInput::make('title')
                            ->label('Link text'),

                        Forms\Components\Toggle::make('blank')
                            ->label('New tab')
                            ->default(false)
                            ->inline(false),
                    ]),
            ]);
    }
}
