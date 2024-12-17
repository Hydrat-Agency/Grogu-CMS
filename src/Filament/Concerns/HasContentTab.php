<?php

namespace Hydrat\GroguCMS\Filament\Concerns;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Hydrat\GroguCMS\Facades\GroguCMS;

trait HasContentTab
{
    public static function contentTabIsContained(): bool
    {
        return false;
    }

    protected static function getContentTabSchema(Form $form): array
    {
        $blueprint = static::getBlueprint($form);

        if (! $blueprint->hasContent() && ! $blueprint->hasBlocks()) {
            return [];
        }

        $scheme = static::contentTabIsContained()
            ? static::getContentTabSchemaContentSectionSchema($form)
            : static::getContentTabInnerSchema($form);

        return [
            Forms\Components\Tabs\Tab::make('Content')
                ->columns([
                    'md' => 1,
                ])
                ->schema([
                    ...$scheme,
                ]),
        ];
    }

    protected static function getContentTabSchemaContentSectionSchema(Form $form): array
    {
        return [
            Forms\Components\Section::make('content')
                ->schema([
                    ...static::getContentTabInnerSchema($form),
                ]),
        ];
    }

    protected static function getContentTabInnerSchema(Form $form): array
    {
        $avaibleTemplates = static::getBlueprint()->templates();
        $selectedTemplate = fn (Get $get) => GroguCMS::getTemplate($get('template'));

        return [
            Forms\Components\RichEditor::make('content')
                ->required()
                ->maxLength(65535)
                ->columnSpanFull()
                ->visible(
                    fn (Get $get) => optional($selectedTemplate($get))->hasContent() || (blank($avaibleTemplates) && blank(static::getBlueprint()->blocks()))
                ),

            Forms\Components\Builder::make('blocks')
                ->addActionLabel(__('Add layout'))
                ->collapsible()
                ->persistCollapsed()
                ->cloneable()
                ->blockPickerColumns(2)
                ->blocks(
                    fn (Get $get) => (array) (optional($selectedTemplate($get))->hasBlocks() ? $selectedTemplate($get)->blocks() : static::getBlueprint()->blocks())
                )
                ->visible(
                    fn (Get $get) => optional($selectedTemplate($get))->hasBlocks() || (blank($avaibleTemplates) && filled(static::getBlueprint()->blocks()))
                ),
        ];
    }
}
