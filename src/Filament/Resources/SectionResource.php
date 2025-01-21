<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
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

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path-rounded-square';

    protected static ?int $navigationSort = 110;

    public static function getModel(): string
    {
        return config('grogu-cms.models.section') ?? \Hydrat\GroguCMS\Models\Section::class;
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

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\Select::make('location')
                    ->options(config('grogu-cms.sections.locations'))
                    ->native(false)
                    ->searchable(),

                Forms\Components\TextInput::make('title')->required(),

                Forms\Components\Builder::make('blocks')
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
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
