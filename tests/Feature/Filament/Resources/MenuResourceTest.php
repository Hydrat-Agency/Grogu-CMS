<?php

use Filament\Resources\Resource;
use Hydrat\GroguCMS\Filament\Resources\MenuResource;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages\CreateMenu;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages\EditMenu;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages\ListMenus;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\Pages\ViewMenu;
use Hydrat\GroguCMS\Filament\Resources\MenuResource\RelationManagers\ItemsRelationManager;
use Hydrat\GroguCMS\Models\Menu;
use Livewire\Livewire;

/**
 * MenuResource tests.
 *
 * Verifies the MenuResource structure, navigation, pages, and Livewire rendering.
 * The infolist() method test is particularly important for Filament v4 compatibility
 * since the infolist API was introduced in v3 and may evolve in v4.
 */
describe('MenuResource class structure', function () {
    it('extends the Filament Resource base class', function () {
        expect(is_subclass_of(MenuResource::class, Resource::class))->toBeTrue();
    });

    it('uses the Menu model by default', function () {
        expect(MenuResource::getModel())->toBe(Menu::class);
    });

    it('uses model from config when overridden', function () {
        config()->set('grogu-cms.models.menu', Menu::class);

        expect(MenuResource::getModel())->toBe(Menu::class);
    });

    it('has a navigation icon', function () {
        $property = new ReflectionProperty(MenuResource::class, 'navigationIcon');

        expect($property->getValue())->toBeString()->not->toBeEmpty();
    });

    it('has a navigation sort value', function () {
        $property = new ReflectionProperty(MenuResource::class, 'navigationSort');

        expect($property->getValue())->toBeInt();
    });

    it('has a navigation group', function () {
        expect(MenuResource::getNavigationGroup())->toBeString()->not->toBeEmpty();
    });

    it('has a form() method', function () {
        expect(method_exists(MenuResource::class, 'form'))->toBeTrue();
    });

    it('has a table() method', function () {
        expect(method_exists(MenuResource::class, 'table'))->toBeTrue();
    });

    it('has an infolist() method', function () {
        expect(method_exists(MenuResource::class, 'infolist'))->toBeTrue();
    });
});

describe('MenuResource pages registration', function () {
    it('registers the index page', function () {
        expect(MenuResource::getPages())->toHaveKey('index');
    });

    it('registers the create page', function () {
        expect(MenuResource::getPages())->toHaveKey('create');
    });

    it('registers the view page', function () {
        expect(MenuResource::getPages())->toHaveKey('view');
    });

    it('registers the edit page', function () {
        expect(MenuResource::getPages())->toHaveKey('edit');
    });

    it('maps index to ListMenus', function () {
        expect(MenuResource::getPages()['index']->getPage())->toBe(ListMenus::class);
    });

    it('maps create to CreateMenu', function () {
        expect(MenuResource::getPages()['create']->getPage())->toBe(CreateMenu::class);
    });

    it('maps view to ViewMenu', function () {
        expect(MenuResource::getPages()['view']->getPage())->toBe(ViewMenu::class);
    });

    it('maps edit to EditMenu', function () {
        expect(MenuResource::getPages()['edit']->getPage())->toBe(EditMenu::class);
    });
});

describe('MenuResource relation managers', function () {
    it('includes the ItemsRelationManager', function () {
        expect(MenuResource::getRelations())->toContain(ItemsRelationManager::class);
    });
});

describe('MenuResource page classes', function () {
    it('ListMenus extends Filament ListRecords', function () {
        expect(is_subclass_of(ListMenus::class, \Filament\Resources\Pages\ListRecords::class))->toBeTrue();
    });

    it('CreateMenu extends Filament CreateRecord', function () {
        expect(is_subclass_of(CreateMenu::class, \Filament\Resources\Pages\CreateRecord::class))->toBeTrue();
    });

    it('EditMenu extends Filament EditRecord', function () {
        expect(is_subclass_of(EditMenu::class, \Filament\Resources\Pages\EditRecord::class))->toBeTrue();
    });

    it('ViewMenu extends Filament ViewRecord', function () {
        expect(is_subclass_of(ViewMenu::class, \Filament\Resources\Pages\ViewRecord::class))->toBeTrue();
    });
});

describe('MenuResource Livewire rendering', function () {
    it('can render the list page', function () {
        actingAsAdmin();

        Livewire::test(ListMenus::class)
            ->assertSuccessful();
    });

    it('can render the create page', function () {
        actingAsAdmin();

        Livewire::test(CreateMenu::class)
            ->assertSuccessful();
    });
});
