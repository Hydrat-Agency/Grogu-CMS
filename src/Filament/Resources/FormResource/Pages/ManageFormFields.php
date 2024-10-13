<?php

namespace Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;

use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components;
use Hydrat\GroguCMS\Enums\FormFieldType;
use Illuminate\Contracts\Support\Htmlable;
use Filament\Resources\Pages\ManageRelatedRecords;
use Hydrat\GroguCMS\Filament\Resources\FormResource;

class ManageFormFields extends ManageRelatedRecords
{
    protected static string $relationship = 'fields';

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    /**
     * @return class-string
     */
    public static function getResource(): string
    {
        return config('grogu-cms.resources.form_resource') ?: FormResource::class;
    }

    public static function getNavigationLabel(): string
    {
        return __('Fields');
    }

    public function getTitle(): string | Htmlable
    {
        return __('Manage form fields');
    }

    public function reorderTable(array $order): void
    {
        $this->getTable()->getModel()::setNewOrder($order);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Grid::make(2)
                    ->schema([
                        Components\TextInput::make('name')
                            ->required()
                            ->columnSpan('full'),

                        Components\Select::make('type')
                            ->required()
                            ->live()
                            ->searchable()
                            ->options(FormFieldType::class)
                            ->columnSpan('full'),

                        Components\TextInput::make('helper_text')
                            ->label('Instructions')
                            ->columnSpan('full')
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasHelperText()
                            ),

                        Components\TextInput::make('placeholder')
                            ->columnSpan('full')
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasPlaceholder()
                            ),

                        Components\TextInput::make('min')
                            ->numeric()
                            ->translateLabel(false)
                            ->label(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->minLabel()
                            )
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasMinMax() || $get('multiple') === true
                            ),

                        Components\TextInput::make('max')
                            ->numeric()
                            ->translateLabel(false)
                            ->label(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->maxLabel()
                            )
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasMinMax() || $get('multiple') === true
                            ),

                        Components\DateTimePicker::make('min_date')
                            ->translateLabel(false)
                            ->label(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->minLabel()
                            )
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasDateMinMax()
                            ),

                        Components\DateTimePicker::make('max_date')
                            ->translateLabel(false)
                            ->label(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->maxLabel()
                            )
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasDateMinMax()
                            ),

                        Components\TextInput::make('rows')
                            ->numeric()
                            ->columnSpanFull()
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasRows()
                            ),

                        Components\Select::make('column_span')
                            ->label('Field size')
                            ->required()
                            ->default(12)
                            ->columnSpan('full')
                            ->options([
                                '12' => __('Full width (1/1)'),
                                '6' => __('Half width (1/2)'),
                                '4' => __('Third width (1/3)'),
                                '8' => __('Two thirds width (2/3)'),
                                '3' => __('Quarter width (1/4)'),
                                '9' => __('Three quarters width (3/4)'),
                            ]),

                        Components\RichEditor::make('content')
                            ->columnSpan('full')
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasContent()
                            ),

                        Components\Toggle::make('required')
                            ->columnSpanFull()
                            ->inline(true),

                        Components\Toggle::make('multiple')
                            ->inline(true)
                            ->columnSpanFull()
                            ->live()
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->canBeMultiple()
                            ),

                        Components\Repeater::make('options')
                            ->addActionLabel(__('Add option'))
                            ->columnSpan('full')
                            ->columns(2)
                            ->collapsible()
                            ->collapsed(fn (string $operation): bool => $operation === 'edit')
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                            ->schema([
                                Components\TextInput::make('label')
                                    ->prefixIcon('heroicon-o-tag')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        $set('value', $get('value') ?: Str::slug($state));
                                    }),

                                Components\TextInput::make('value')
                                    ->prefixIcon('heroicon-o-variable')
                                    ->required(),
                            ])
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasOptions()
                            ),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->reorderable('order')
            ->defaultSort('order')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('column_span')
                    ->label('Field size')
                    ->badge()
                    ->color('gray')
                    ->toggleable()
                    ->formatStateUsing(fn ($state): string => match($state) {
                        '12', 'full' => __('Full width (1/1)'),
                        '6' => __('Half width (1/2)'),
                        '4' => __('Third width (1/3)'),
                        '8' => __('Two thirds width (2/3)'),
                        '3' => __('Quarter width (1/4)'),
                        '9' => __('Three quarters width (3/4)'),
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->date(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                // Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                // Tables\Actions\DissociateAction::make(),
                Tables\Actions\EditAction::make()
                    ->iconSoftButton('heroicon-o-pencil-square'),
                Tables\Actions\DeleteAction::make()
                    ->iconSoftButton('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DissociateBulkAction::make(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateDescription(__('Create a new field to get started.'));
    }
}
