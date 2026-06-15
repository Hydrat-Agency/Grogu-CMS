<?php

namespace Hydrat\GroguCMS\Filament\Concerns;

use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Hydrat\GroguCMS\Facades\GroguCMS;

trait HasContentTab
{
    public static function contentTabIsContained(): bool
    {
        return false;
    }

    protected static function getContentTabSchema(Schema $schema): array
    {
        $blueprint = static::getBlueprint($schema);

        if (! $blueprint->hasContent() && ! $blueprint->hasBlocks()) {
            return [];
        }

        $scheme = static::contentTabIsContained()
            ? static::getContentTabSchemaContentSectionSchema($schema)
            : static::getContentTabInnerSchema($schema);

        return [
            Tab::make('Content')
                ->columns([
                    'md' => 1,
                ])
                ->schema([
                    ...$scheme,
                ]),
        ];
    }

    protected static function getContentTabSchemaContentSectionSchema(Schema $schema): array
    {
        return [
            Section::make('content')
                ->schema([
                    ...static::getContentTabInnerSchema($schema),
                ]),
        ];
    }

    public static function getBuilderField(): Builder
    {
        $avaibleTemplates = static::getBlueprint()->templates();
        $selectedTemplate = fn (Get $get) => GroguCMS::getTemplate($get('template'));

        return Builder::make('blocks')
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
            );
    }

    protected static function getContentTabInnerSchema(Schema $schema): array
    {
        $avaibleTemplates = static::getBlueprint()->templates();
        $selectedTemplate = fn (Get $get) => GroguCMS::getTemplate($get('template'));

        return [
            RichEditor::make('content')
                ->required()
                ->maxLength(65535)
                ->columnSpanFull()
                ->visible(
                    fn (Get $get) => optional($selectedTemplate($get))->hasContent() || (blank($avaibleTemplates) && blank(static::getBlueprint()->blocks()))
                ),

            static::getBuilderField(),
        ];
    }
}
