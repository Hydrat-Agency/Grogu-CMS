<?php

namespace Hydrat\GroguCMS\Layouts;

use Filament\Forms;

class CtaText extends Layout
{
    public function configureLayout(Layout $layout): Layout
    {
        return $layout
            ->label(__('CTA Text'))
            ->columns(1)
            ->schema([
                Forms\Components\Textarea::make('text')
                    ->required()
                    ->autosize()
                    ->rows(3),

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
