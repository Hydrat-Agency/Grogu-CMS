<?php

use Hydrat\GroguCMS\Filament\Resources\FormResource;
use Hydrat\GroguCMS\Filament\Resources\MenuResource;
use Hydrat\GroguCMS\Filament\Resources\PageResource;
use Hydrat\GroguCMS\Filament\Resources\SectionResource;
use Hydrat\GroguCMS\Filament\Resources\UserResource;
use Hydrat\GroguCMS\Models\Form;
use Hydrat\GroguCMS\Models\FormEntry;
use Hydrat\GroguCMS\Models\FormField;
use Hydrat\GroguCMS\Models\Menu;
use Hydrat\GroguCMS\Models\MenuItem;
use Hydrat\GroguCMS\Models\Page;
use Hydrat\GroguCMS\Models\Section;
use Hydrat\GroguCMS\PermissionRegistrar;
use Hydrat\GroguCMS\Tests\Models\User;

describe('configuration structure', function () {
    it('has the models config key', function () {
        expect(config('grogu-cms.models'))->toBeArray();
    });

    it('has the resources config key', function () {
        expect(config('grogu-cms.resources'))->toBeArray();
    });

    it('has the users config key', function () {
        expect(config('grogu-cms.users'))->toBeArray();
    });

    it('has the menus config key', function () {
        expect(config('grogu-cms.menus'))->toBeArray();
    });

    it('has the sections config key', function () {
        expect(config('grogu-cms.sections'))->toBeArray();
    });

    it('has the seo config key', function () {
        expect(config('grogu-cms.seo'))->toBeArray();
    });

    it('has the translatable config key', function () {
        expect(config('grogu-cms'))->toHaveKey('translatable');
    });
});

describe('default model configuration', function () {
    it('configures the page model', function () {
        expect(config('grogu-cms.models.page'))->toBe(Page::class);
    });

    it('configures the menu model', function () {
        expect(config('grogu-cms.models.menu'))->toBe(Menu::class);
    });

    it('configures the menu_item model', function () {
        expect(config('grogu-cms.models.menu_item'))->toBe(MenuItem::class);
    });

    it('configures the form model', function () {
        expect(config('grogu-cms.models.form'))->toBe(Form::class);
    });

    it('configures the form_field model', function () {
        expect(config('grogu-cms.models.form_field'))->toBe(FormField::class);
    });

    it('configures the form_entry model', function () {
        expect(config('grogu-cms.models.form_entry'))->toBe(FormEntry::class);
    });

    it('configures the section model', function () {
        expect(config('grogu-cms.models.section'))->toBe(Section::class);
    });

    it('configures the user model', function () {
        // Test environment overrides the default App\Models\User
        expect(config('grogu-cms.models.user'))->toBe(User::class);
    });
});

describe('default resource configuration', function () {
    it('configures the page resource', function () {
        expect(config('grogu-cms.resources.page_resource'))->toBe(PageResource::class);
    });

    it('configures the menu resource', function () {
        expect(config('grogu-cms.resources.menu_resource'))->toBe(MenuResource::class);
    });

    it('configures the user resource', function () {
        expect(config('grogu-cms.resources.user_resource'))->toBe(UserResource::class);
    });

    it('configures the form resource', function () {
        expect(config('grogu-cms.resources.form_resource'))->toBe(FormResource::class);
    });

    it('configures the section resource', function () {
        expect(config('grogu-cms.resources.section_resource'))->toBe(SectionResource::class);
    });
});

describe('default settings', function () {
    it('disables translatable mode by default', function () {
        expect(config('grogu-cms.translatable'))->toBeFalse();
    });

    it('enables menus by default', function () {
        expect(config('grogu-cms.menus.enabled'))->toBeTrue();
    });

    it('has at least one default menu location', function () {
        expect(config('grogu-cms.menus.locations'))->toBeArray()->not->toBeEmpty();
    });

    it('uses web guard for users', function () {
        expect(config('grogu-cms.users.guard'))->toBe('web');
    });

    it('has a permission registrar configured', function () {
        expect(config('grogu-cms.users.permissions_registrar'))->toBe(PermissionRegistrar::class);
    });

    it('has seo on_save configured', function () {
        expect(config('grogu-cms'))->toHaveKey('seo.on_save');
    });

    it('has sitemap configuration', function () {
        expect(config('grogu-cms.seo.sitemap'))->toBeArray()
            ->toHaveKey('path')
            ->toHaveKey('uri')
            ->toHaveKey('crawl')
            ->toHaveKey('models');
    });
});
