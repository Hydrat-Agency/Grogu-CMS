<?php

namespace Hydrat\GroguCMS\Filament\Resources\FormResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\FilamentLexiTranslate\Resources\RelationManagers\Concerns\Translatable;
use Hydrat\FilamentLexiTranslate\Tables\Actions\LocaleSwitcher;

class FieldsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'fields';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->translatable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ...(GroguCMS::isTranslatableEnabled() ? [LocaleSwitcher::make()] : []),

                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function mutateDataBeforeSaving(array $data): array
    {
        $data['form_id'] = $this->getOwnerRecord()?->id;

        return $data;
    }
}
