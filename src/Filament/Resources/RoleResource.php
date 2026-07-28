<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Filament\Resources\RoleResource\Pages\CreateRole;
use Hydrat\GroguCMS\Filament\Resources\RoleResource\Pages\EditRole;
use Hydrat\GroguCMS\Filament\Resources\RoleResource\Pages\ListRoles;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'name';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shield-check';

    protected static ?int $navigationSort = 520;

    public static function getModel(): string
    {
        return config('grogu-cms.models.role') ?? Role::class;
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Users');
    }

    public static function getModelLabel(): string
    {
        return __('Role');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Roles');
    }

    public static function form(Schema $schema): Schema
    {
        $guard = config('grogu-cms.users.guard');

        return $schema
            ->components([
                Section::make(__('Manage role'))
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        CheckboxList::make('permissions')
                            ->relationship(
                                name: 'permissions',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query) => $query->where('guard_name', $guard)
                            )
                            ->columns(3)
                            ->bulkToggleable(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('permissions_count')
                    ->counts('permissions')
                    ->label(__('Permissions')),

                TextColumn::make('users_count')
                    ->counts('users')
                    ->label(__('Users')),

                TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->iconSoftButton('heroicon-o-pencil-square'),
                DeleteAction::make()
                    ->iconSoftButton('heroicon-o-trash')
                    ->visible(fn (Model $record) => $record->getKey() !== 1),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
