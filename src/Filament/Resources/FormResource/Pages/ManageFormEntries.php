<?php

namespace Hydrat\GroguCMS\Filament\Resources\FormResource\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Filament\Resources\FormResource;
use Hydrat\GroguCMS\Models\FormField;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

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
                        fn ($state) => collect($state ?: [])->pluck('value', 'label')
                    ),
            ]);
    }

    public function table(Table $table): Table
    {
        $userDefinedColumns = Arr::pluck($this->getOwnerRecord()->entry_columns ?? [], 'field');

        $userDefinedColumns = $this->getOwnerRecord()
            ->fields()
            ->whereIn('id', $userDefinedColumns)
            ->orderByRaw('FIELD(id, '.implode(',', $userDefinedColumns).')')
            ->get()
            ->map(
                fn (FormField $field) => Tables\Columns\TextColumn::make($field->key)
                    ->label(filled($field->label) ? $field->label : $field->name)
                    ->getStateUsing(fn ($record) => $record->values->where('key', $field->key)->first()?->value)
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(query: function (Builder $query, string $direction) use ($field) {
                        $query->orderByRaw(
                            "(
                                SELECT JSON_UNQUOTE(JSON_EXTRACT(je.value, '$.value'))
                                FROM JSON_TABLE(
                                    form_entries.values,
                                    '$[*]' COLUMNS(
                                        `key` VARCHAR(255) PATH '$.key',
                                        value JSON PATH '$'
                                    )
                                ) AS je
                                WHERE je.key = ?
                                LIMIT 1
                            ) {$direction}",
                            [$field->key]
                        );
                    })
                    ->searchable(query: function (Builder $query, string $search) use ($field) {
                        $query->whereRaw(
                            "EXISTS (
                                SELECT 1
                                FROM JSON_TABLE(
                                    form_entries.values,
                                    '$[*]' COLUMNS(
                                        `key` VARCHAR(255) PATH '$.key',
                                        value VARCHAR(500) PATH '$.value'
                                    )
                                ) AS je
                                WHERE je.key = ? AND je.value LIKE ?
                            )",
                            [$field->key, "%{$search}%"]
                        );
                    })
            );

        return $table
            ->recordTitleAttribute('submitted_at')
            ->defaultSort('submitted_at', 'desc')
            ->columns([
                ...$userDefinedColumns,

                Tables\Columns\TextColumn::make('submitted_at')
                    ->sortable()
                    ->searchable()
                    ->dateTime('d/m/Y H:i:s')
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
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
