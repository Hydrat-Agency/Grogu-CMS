<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Actions\User\WelcomeUser;
use Hydrat\GroguCMS\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Gate;

class UserResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationIcon = 'heroicon-o-user';

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

    public static function form(Form $form): Form
    {
        $guard = config('grogu-cms.users.guard');

        return $form
            ->schema([
                Forms\Components\Section::make(__('Manage user'))
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('email')
                                    ->disabled($form->getOperation() === 'edit')
                                    ->unique(ignoreRecord: true)
                                    ->required()
                                    ->email()
                                    ->maxLength(255),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('avatar_url')
                                    ->label('Avatar')
                                    ->previewable()
                                    ->avatar(),

                                Forms\Components\CheckboxList::make('roles')
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
                Tables\Columns\ImageColumn::make('avatar_url')
                    ->label('Avatar')
                    ->defaultImageUrl(fn (User $record) => $record->getDefaultAvatarUrl())
                    ->size(32)
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                Tables\Filters\SelectFilter::make('roles')
                    ->relationship(name: 'roles', titleAttribute: 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->actions([
                // Tables\Actions\Action::make('resetPassword')
                //     ->iconSoftButton('heroicon-o-lock-closed')
                //     ->visible(
                //         fn (User $record) => auth()->user()->can('update', $record)
                //     ),

                Tables\Actions\Action::make('welcomeReset')
                    ->iconSoftButton('heroicon-o-rocket-launch')
                    ->label(__('Resend welcome email'))
                    ->authorize(fn (User $record) => Gate::check('update', $record) && $record->welcome_valid_until !== null)
                    ->action(fn (User $record) => WelcomeUser::run($record))
                    ->requiresConfirmation(),

                Tables\Actions\EditAction::make()
                    ->iconSoftButton('heroicon-o-pencil-square'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
