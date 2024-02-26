<?php

namespace Hydrat\GroguCMS\Layouts;

use Illuminate\Support\Str;
use Filament\Forms\Components\Builder\Block;

abstract class Layout extends Block
{
    public static function create(): static
    {
        $layoutName = static::getLayoutName();

        return static::make($layoutName);
    }

    protected function setUp(): void
    {
        $this->configureLayout($this);
    }

    public static function getLayoutName(): string
    {
        return Str::of(static::class)
            ->afterLast('\\')
            ->snake()
            ->toString();
    }

    public function configureLayout(Layout $layout): Layout
    {
        return $layout
            ->columns(2)
            ->schema([
                //
            ]);
    }
}
