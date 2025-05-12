<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\FilamentLexiTranslate\Resources\Concerns\Translatable;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;
use Hydrat\GroguCMS\Filament\Resources\FormResource\RelationManagers;

class FormResource extends Resource
{
    use Translatable;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?int $navigationSort = 120;

    public static function getModel(): string
    {
        return config('grogu-cms.models.form') ?? \Hydrat\GroguCMS\Models\Form::class;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('submit_button_label')
                    ->required()
                    ->default(fn () => __('Submit'))
                    ->maxLength(255),

                Forms\Components\Textarea::make('submit_success_message')
                    ->rows(3)
                    ->columnSpanFull()
                    ->maxLength(5000),

                Forms\Components\TextInput::make('notify_subject')
                    ->default(fn () => __('New form submission'))
                    ->maxLength(255),

                Forms\Components\TextInput::make('notify_emails')
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
            'entries' => Pages\ManageFormEntries::route('/{record}/entries'),
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
