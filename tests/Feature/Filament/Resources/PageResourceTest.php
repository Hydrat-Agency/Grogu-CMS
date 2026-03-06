<?php

use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Resource;
use Hydrat\GroguCMS\Filament\Contracts\HasBlueprint;
use Hydrat\GroguCMS\Filament\Resources\CmsResource;
use Hydrat\GroguCMS\Filament\Resources\PageResource;
use Hydrat\GroguCMS\Filament\Resources\PageResource\Pages\CreatePage;
use Hydrat\GroguCMS\Filament\Resources\PageResource\Pages\EditPage;
use Hydrat\GroguCMS\Filament\Resources\PageResource\Pages\EditPageContent;
use Hydrat\GroguCMS\Filament\Resources\PageResource\Pages\EditPageSeo;
use Hydrat\GroguCMS\Filament\Resources\PageResource\Pages\ListPages;
use Hydrat\GroguCMS\Models\Page;
use Livewire\Livewire;

/**
 * PageResource tests.
 *
 * These tests verify the PageResource structure is correct.
 * They act as a safety net for Filament v4 upgrades since that version
 * may rename base classes, change method signatures, or alter
 * the navigation/sub-navigation API.
 */
describe('PageResource class structure', function () {
    it('extends CmsResource', function () {
        expect(is_subclass_of(PageResource::class, CmsResource::class))->toBeTrue();
    });

    it('extends the Filament Resource base class', function () {
        expect(is_subclass_of(PageResource::class, Resource::class))->toBeTrue();
    });

    it('implements HasBlueprint', function () {
        expect(is_a(PageResource::class, HasBlueprint::class, true))->toBeTrue();
    });

    it('uses the Page model by default', function () {
        expect(PageResource::getModel())->toBe(Page::class);
    });

    it('uses model from config when overridden', function () {
        config()->set('grogu-cms.models.page', Page::class);

        expect(PageResource::getModel())->toBe(Page::class);
    });

    it('has a navigation icon', function () {
        $property = new ReflectionProperty(PageResource::class, 'navigationIcon');

        expect($property->getValue())->toBeString()->not->toBeEmpty();
    });

    it('has a navigation sort value', function () {
        $property = new ReflectionProperty(PageResource::class, 'navigationSort');

        expect($property->getValue())->toBeInt();
    });

    it('has a navigation group', function () {
        expect(PageResource::getNavigationGroup())->toBeString()->not->toBeEmpty();
    });

    it('has a label', function () {
        expect(PageResource::getLabel())->toBeString()->not->toBeEmpty();
    });

    it('has a plural label', function () {
        expect(PageResource::getPluralLabel())->toBeString()->not->toBeEmpty();
    });
});

describe('PageResource pages registration', function () {
    it('registers the index page', function () {
        expect(PageResource::getPages())->toHaveKey('index');
    });

    it('registers the create page', function () {
        expect(PageResource::getPages())->toHaveKey('create');
    });

    it('registers the edit page', function () {
        expect(PageResource::getPages())->toHaveKey('edit');
    });

    it('registers the content page', function () {
        expect(PageResource::getPages())->toHaveKey('content');
    });

    it('registers the seo page', function () {
        expect(PageResource::getPages())->toHaveKey('seo');
    });

    it('maps index to ListPages', function () {
        expect(PageResource::getPages()['index']->getPage())->toBe(ListPages::class);
    });

    it('maps create to CreatePage', function () {
        expect(PageResource::getPages()['create']->getPage())->toBe(CreatePage::class);
    });

    it('maps edit to EditPage', function () {
        expect(PageResource::getPages()['edit']->getPage())->toBe(EditPage::class);
    });

    it('maps content to EditPageContent', function () {
        expect(PageResource::getPages()['content']->getPage())->toBe(EditPageContent::class);
    });

    it('maps seo to EditPageSeo', function () {
        expect(PageResource::getPages()['seo']->getPage())->toBe(EditPageSeo::class);
    });
});

describe('PageResource sub-navigation', function () {
    it('has a getRecordSubNavigation method', function () {
        expect(method_exists(PageResource::class, 'getRecordSubNavigation'))->toBeTrue();
    });
});

describe('PageResource page classes', function () {
    it('ListPages extends Filament ListRecords', function () {
        expect(is_subclass_of(ListPages::class, ListRecords::class))->toBeTrue();
    });

    it('ListPages references the correct resource', function () {
        expect(ListPages::getResource())->toBe(PageResource::class);
    });

    it('EditPage extends Filament EditRecord', function () {
        expect(is_subclass_of(EditPage::class, \Filament\Resources\Pages\EditRecord::class))->toBeTrue();
    });

    it('CreatePage extends Filament CreateRecord', function () {
        expect(is_subclass_of(CreatePage::class, \Filament\Resources\Pages\CreateRecord::class))->toBeTrue();
    });
});

describe('PageResource Livewire rendering', function () {
    it('can render the list page', function () {
        actingAsAdmin();

        Livewire::test(ListPages::class)
            ->assertSuccessful();
    });

    it('can render the create page', function () {
        actingAsAdmin();

        Livewire::test(CreatePage::class)
            ->assertSuccessful();
    });
});
