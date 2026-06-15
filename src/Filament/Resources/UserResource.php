<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\CheckboxList;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Hydrat\GroguCMS\Filament\Resources\UserResource\Pages\ListUsers;
use Hydrat\GroguCMS\Filament\Resources\UserResource\Pages\CreateUser;
use Hydrat\GroguCMS\Filament\Resources\UserResource\Pages\EditUser;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Actions\User\WelcomeUser;
use Hydrat\GroguCMS\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;

class UserResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'name';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 510;

    public static function getModel(): string
    {
        return config('grogu-cms.models.user') ?? 'App\Models\User';
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Configuration');
    }

    public static function getBreadcrumb(): string
    {
        return __('Users');
    }

    public static function getModelLabel(): string
    {
        return __('User');
    }

    public static function form(Schema $schema): Schema
    {
        $guard = config('grogu-cms.users.guard');

        return $schema
            ->components([
                Section::make(__('Manage user'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('email')
                                    ->disabled($schema->getOperation() === 'edit')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->email()
                                    ->maxLength(255),
                            ]),

                        Grid::make(2)
                            ->schema([
                                FileUpload::make('avatar_url')
                                    ->label('Avatar')
                                    ->previewable()
                                    ->avatar(),

                                CheckboxList::make('roles')
                                    ->relationship(
                                        name: 'roles',
                                        titleAttribute: 'name',
                                        modifyQueryUsing: fn (Builder $query) => $query
                                            ->where('guard_name', $guard)
                                            ->where('id', '!=', 1)
                                    ),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('avatar_url')
                    ->label('Avatar')
                    ->defaultImageUrl(fn (User $record) => $record->getDefaultAvatarUrl())
                    ->size(32)
                    ->circular(),

                TextColumn::make('name')
                    ->searchable(),

                TextColumn::make('email')
                    ->searchable(),

                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('roles')
                    ->relationship(name: 'roles', titleAttribute: 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->recordActions([
                // Actions\Action::make('resetPassword')
                //     ->iconSoftButton('heroicon-o-lock-closed')
                //     ->visible(
                //         fn (User $record) => auth()->user()->can('update', $record)
                //     ),

                Action::make('welcomeReset')
                    ->iconSoftButton('heroicon-o-rocket-launch')
                    ->label(__('Resend welcome email'))
                    ->authorize(fn (User $record) => Gate::check('update', $record) && $record->welcome_valid_until !== null)
                    ->action(fn (User $record) => WelcomeUser::run($record))
                    ->requiresConfirmation(),

                EditAction::make()->iconSoftButton('heroicon-o-pencil-square'),
                DeleteAction::make()->iconSoftButton('heroicon-o-trash'),
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
