<?php

namespace Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\FilamentLexiTranslate\Resources\RelationManagers\Concerns\Translatable;
use Hydrat\FilamentLexiTranslate\Tables\Actions\LocaleSwitcher;
use Hydrat\GroguCMS\Enums\FormFieldType;
use Hydrat\GroguCMS\Facades\GroguCMS;
use Hydrat\GroguCMS\Filament\Resources\FormResource;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

class ManageFormFields extends ManageRelatedRecords
{
    use Translatable;

    protected static string $relationship = 'fields';

    protected static ?string $navigationIcon = 'radix-section'; // heroicon-o-queue-list

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

    public function getTitle(): string|Htmlable
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
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->live(debounce: 300),

                        Forms\Components\TextInput::make('label')
                            ->translateLabel(false)
                            ->placeholder(fn (Get $get) => $get('name')),

                        Forms\Components\Select::make('type')
                            ->required()
                            ->live()
                            ->searchable()
                            ->options(FormFieldType::class)
                            ->columnSpan('full'),

                        Forms\Components\TextInput::make('helper_text')
                            ->label('Instructions')
                            ->columnSpan('full')
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasHelperText()
                            ),

                        Forms\Components\TextInput::make('placeholder')
                            ->columnSpan('full')
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasPlaceholder()
                            ),

                        Forms\Components\TextInput::make('min')
                            ->numeric()
                            ->translateLabel(false)
                            ->label(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->minLabel()
                            )
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasMinMax() || $get('multiple') === true
                            ),

                        Forms\Components\TextInput::make('max')
                            ->numeric()
                            ->translateLabel(false)
                            ->label(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->maxLabel()
                            )
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasMinMax() || $get('multiple') === true
                            ),

                        Forms\Components\DateTimePicker::make('min_date')
                            ->translateLabel(false)
                            ->label(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->minLabel()
                            )
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasDateMinMax()
                            ),

                        Forms\Components\DateTimePicker::make('max_date')
                            ->translateLabel(false)
                            ->label(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->maxLabel()
                            )
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasDateMinMax()
                            ),

                        Forms\Components\TextInput::make('rows')
                            ->numeric()
                            ->columnSpanFull()
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasRows()
                            ),

                        Forms\Components\Select::make('column_span')
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

                        Forms\Components\RichEditor::make('content')
                            ->columnSpan('full')
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->hasContent()
                            ),

                        Forms\Components\Toggle::make('required')
                            ->columnSpanFull()
                            ->inline(true)
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->canBeRequired()
                            ),

                        Forms\Components\Toggle::make('hidden_label')
                            ->columnSpanFull()
                            ->label('Hide field label')
                            ->inline(true)
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->canHideLabel()
                            ),

                        Forms\Components\Toggle::make('multiple')
                            ->inline(true)
                            ->columnSpanFull()
                            ->live()
                            ->visible(
                                fn (Get $get) => FormFieldType::tryFrom($get('type'))?->canBeMultiple()
                            ),

                        Forms\Components\Repeater::make('options')
                            ->addActionLabel(__('Add option'))
                            ->columnSpan('full')
                            ->columns(2)
                            ->collapsible()
                            ->collapsed(fn (string $operation): bool => $operation === 'edit')
                            ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->prefixIcon('heroicon-o-tag')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        $set('value', $get('value') ?: Str::slug($state));
                                    }),

                                Forms\Components\TextInput::make('value')
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
                    ->searchable()
                    ->translatable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->toggleable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('column_span')
                    ->label('Field size')
                    ->badge()
                    ->color('gray')
                    ->toggleable()
                    ->formatStateUsing(fn ($state): string => match ($state) {
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
                ...(GroguCMS::isTranslatableEnabled() ? [LocaleSwitcher::make()] : []),

                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(fn (array $data): array => $this->mutateDataBeforeSaving($data)),
            ])
            ->actions([
                Tables\Actions\ReplicateAction::make()->iconSoftButton('heroicon-o-square-2-stack'),
                Tables\Actions\EditAction::make()->iconSoftButton('heroicon-o-pencil-square'),
                Tables\Actions\DeleteAction::make()->iconSoftButton('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateDescription(__('Create a new field to get started.'));
    }

    protected function mutateDataBeforeSaving(array $data): array
    {
        $data['form_id'] = $this->getRecord()?->id;

        return $data;
    }
}
