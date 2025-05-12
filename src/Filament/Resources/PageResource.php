<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Forms\Form;
use Filament\Resources\Pages\Page as FilamentPage;
use Filament\Tables;
use Filament\Tables\Table;
use Hydrat\FilamentLexiTranslate\Resources\Concerns\Translatable;
use Hydrat\GroguCMS\Filament\Resources\PageResource\Pages;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageResource extends CmsResource
{
    use Translatable;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 100;

    public static function getModel(): string
    {
        return config('grogu-cms.models.page') ?? \Hydrat\GroguCMS\Models\Page::class;
    }

    public static function getLabel(): string
    {
        return __('Page');
    }

    public static function getPluralLabel(): string
    {
        return __('Pages');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('Site');
    }

    public static function form(Form $form): Form
    {
        return parent::form($form);
    }

    public static function table(Table $table): Table
    {
        return parent::table($table)
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    protected static function getTableColumns(): array
    {
        return parent::getTableColumns();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
            'content' => Pages\EditPageContent::route('/{record}/content'),
            'seo' => Pages\EditPageSeo::route('/{record}/seo'),
        ];
    }

    public static function getRecordSubNavigation(FilamentPage $page): array
    {
        return $page->generateNavigationItems([
            Pages\EditPage::class,
            Pages\EditPageContent::class,
            Pages\EditPageSeo::class,
        ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
