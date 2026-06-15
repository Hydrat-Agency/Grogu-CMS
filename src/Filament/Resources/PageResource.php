<?php

namespace Hydrat\GroguCMS\Filament\Resources;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Resources\Pages\Page as FilamentPage;
use Filament\Schemas\Schema;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Hydrat\GroguCMS\Filament\Resources\PageResource\Pages\CreatePage;
use Hydrat\GroguCMS\Filament\Resources\PageResource\Pages\EditPage;
use Hydrat\GroguCMS\Filament\Resources\PageResource\Pages\EditPageContent;
use Hydrat\GroguCMS\Filament\Resources\PageResource\Pages\EditPageSeo;
use Hydrat\GroguCMS\Filament\Resources\PageResource\Pages\ListPages;
use Hydrat\GroguCMS\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageResource extends CmsResource
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 100;

    public static function getModel(): string
    {
        return config('grogu-cms.models.page') ?? Page::class;
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

    public static function form(Schema $schema): Schema
    {
        return parent::form($schema);
    }

    public static function table(Table $table): Table
    {
        return parent::table($table)
            ->filters([
                TrashedFilter::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
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
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
            'content' => EditPageContent::route('/{record}/content'),
            'seo' => EditPageSeo::route('/{record}/seo'),
        ];
    }

    public static function getRecordSubNavigation(FilamentPage $page): array
    {
        return $page->generateNavigationItems([
            EditPage::class,
            EditPageContent::class,
            EditPageSeo::class,
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
