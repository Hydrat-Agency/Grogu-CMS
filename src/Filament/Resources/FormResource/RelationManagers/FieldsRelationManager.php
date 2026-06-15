<?php

namespace Hydrat\GroguCMS\Filament\Resources\FormResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hydrat\FilamentLexiTranslate\Actions\LocaleSwitcher;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\FilamentLexiTranslate\Resources\RelationManagers\Concerns\Translatable;

class FieldsRelationManager extends RelationManager
{
    use Translatable;

    protected static string $relationship = 'fields';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
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
                TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ...(GroguCMS::isTranslatableEnabled() ? [LocaleSwitcher::make()] : []),

                CreateAction::make()
                    ->mutateDataUsing(fn (array $data): array => $this->mutateDataBeforeSaving($data)),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function mutateDataBeforeSaving(array $data): array
    {
        $data['form_id'] = $this->getOwnerRecord()?->id;

        return $data;
    }
}
