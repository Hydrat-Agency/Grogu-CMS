<?php

namespace Hydrat\GroguCMS\Filament\Concerns;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use App\Facades\FilamentCms;

trait HasContentTab
{
    public static function contentTabIsContained(): bool
    {
        return false;
    }

    protected static function getContentTabSchema(Form $form): array
    {
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
                    ...static::getContentTabInnerSchema($form)
                ]),
        ];
    }

    protected static function getContentTabInnerSchema(Form $form): array
    {
        $selectedTemplate = fn (Get $get) => FilamentCms::getTemplate($get('template'));

        return [
            Forms\Components\MarkdownEditor::make('content')
                ->required()
                ->maxLength(65535)
                ->columnSpanFull()
                ->visible(
                    fn (Get $get) => optional($selectedTemplate($get))->hasContent()
                ),

            Forms\Components\Builder::make('blocks')
                ->addActionLabel(__('Add layout'))
                ->collapsible()
                ->persistCollapsed()
                ->cloneable()
                ->blockPickerColumns(2)
                ->blocks(
                    fn (Get $get) => (array) optional($selectedTemplate($get))->blocks()
                )
                ->visible(
                    fn (Get $get) => optional($selectedTemplate($get))->hasBlocks()
                ),
        ];
    }
}