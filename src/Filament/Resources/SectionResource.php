<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages\ListSections;
use Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages\CreateSection;
use Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages\EditSection;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Filament\Concerns\InteractsWithBlueprint;
use Hydrat\GroguCMS\Filament\Contracts\HasBlueprint;
use Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages;
use Hydrat\GroguCMS\Models\Section;

class SectionResource extends Resource implements HasBlueprint
{
    use InteractsWithBlueprint;

    protected static ?string $model = Section::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?int $navigationSort = 110;

    public static function getModel(): string
    {
        return config('grogu-cms.models.section') ?? Section::class;
    }

    public static function getLabel(): string
    {
        return __('Section');
    }

    public static function getPluralLabel(): string
    {
        return __('Sections');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Site');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Select::make('location')
                    ->options(config('grogu-cms.sections.locations'))
                    ->native(false)
                    ->searchable(),

                TextInput::make('title')->required(),

                Builder::make('blocks')
                    ->addActionLabel(__('Add layout'))
                    ->collapsible()
                    ->persistCollapsed()
                    ->cloneable()
                    ->blockPickerColumns(2)
                    ->blocks(
                        fn () => static::getBlueprint()->blocks()
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('location')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSections::route('/'),
            'create' => CreateSection::route('/create'),
            'edit' => EditSection::route('/{record}/edit'),
        ];
    }
}
