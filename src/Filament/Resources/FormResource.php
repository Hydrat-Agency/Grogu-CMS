<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Hydrat\GroguCMS\Models\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\ListForms;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\CreateForm;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\EditForm;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\ManageFormFields;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\ManageFormEntries;
use Filament\Forms;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;
use Hydrat\GroguCMS\Filament\Resources\FormResource\RelationManagers;

class FormResource extends Resource
{
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 120;

    public static function getModel(): string
    {
        return config('grogu-cms.models.form') ?? Form::class;
    }

    public static function getLabel(): string
    {
        return __('Form');
    }

    public static function getPluralLabel(): string
    {
        return __('Forms');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Site');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('submit_button_label')
                    ->required()
                    ->default(fn () => __('Submit'))
                    ->maxLength(255),

                Textarea::make('submit_success_message')
                    ->rows(3)
                    ->columnSpanFull()
                    ->maxLength(5000),

                TextInput::make('notify_subject')
                    ->default(fn () => __('New form submission'))
                    ->maxLength(255),

                TextInput::make('notify_emails')
                    ->maxLength(255),

                Repeater::make('entry_columns')
                    ->helperText(__('Define the columns displayed in the entries list. You need to define fields first in the "Fields" section.'))
                    ->columnSpanFull()
                    ->grid(3)
                    ->columns(1)
                    ->addActionLabel(__('Add field'))
                    ->schema([
                        Select::make('field')
                            ->options(fn ($record) => $record?->fields()->pluck('name', 'id') ?? [])
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
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
            // RelationManagers\FieldsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListForms::route('/'),
            'create' => CreateForm::route('/create'),
            'edit' => EditForm::route('/{record}/edit'),
            'fields' => ManageFormFields::route('/{record}/fields'),
            'entries' => ManageFormEntries::route('/{record}/entries'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            EditForm::class,
            ManageFormFields::class,
            ManageFormEntries::class,
        ]);
    }
}
