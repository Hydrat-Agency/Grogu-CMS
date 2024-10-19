<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;
use Hydrat\GroguCMS\Filament\Resources\FormResource\RelationManagers;
use Hydrat\GroguCMS\Models\Form as FormModel;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $recordTitleAttribute = 'name';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('submit_button_label')
                    ->required()
                    ->default(__('Submit'))
                    ->maxLength(255),

                Forms\Components\Textarea::make('submit_success_message')
                    ->rows(3)
                    ->columnSpanFull()
                    ->maxLength(5000),

                Forms\Components\TextInput::make('notify_subject')
                    ->default(__('New form submission'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('notify_email')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
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
            // RelationManagers\FieldsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
            'fields' => Pages\ManageFormFields::route('/{record}/fields'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditForm::class,
            Pages\ManageFormFields::class,
            Pages\ManageFormEntries::class,
        ]);
    }
}
