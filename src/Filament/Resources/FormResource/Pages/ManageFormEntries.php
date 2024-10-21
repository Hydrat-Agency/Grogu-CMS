<?php

namespace Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Filament\Resources\FormResource;
use Illuminate\Contracts\Support\Htmlable;

class ManageFormEntries extends ManageRelatedRecords
{
    protected static string $relationship = 'entries';

    protected static ?string $navigationIcon = 'radix-enter';

    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.form_resource') ?: FormResource::class;
    }

    public static function getNavigationLabel(): string
    {
        return __('Entries');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Manage form entries');
    }

    public function form(Form $form): Form
    {
        $fields = $this->getRecord()->fields()->get()->mapWithKeys(
            fn ($field) => [$field->key => $field->name]
        );

        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('submitted_at')
                    ->required(),

                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),

                Forms\Components\KeyValue::make('values')
                    ->columnSpanFull()
                    ->keyLabel(fn () => __('Field'))
                    ->formatStateUsing(
                        fn ($state) => collect($state ?: [])
                            ->mapWithKeys(fn ($value, $key) => [
                                $fields[$key] ?? $key => $value,
                            ])
                            ->all()
                    ),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('submitted_at')
            ->defaultSort('submitted_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('submitted_at')
                    ->sortable()
                    ->searchable()
                    ->dateTime('d/m/Y H:i:s'),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->iconSoftButton('heroicon-o-eye'),
                Tables\Actions\EditAction::make()->iconSoftButton('heroicon-o-pencil-square'),
                Tables\Actions\DeleteAction::make()->iconSoftButton('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
