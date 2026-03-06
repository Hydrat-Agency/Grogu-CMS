<?php

use Filament\Resources\Resource;
use Hydrat\GroguCMS\Filament\Resources\UserResource;
use Hydrat\GroguCMS\Filament\Resources\UserResource\Pages\CreateUser;
use Hydrat\GroguCMS\Filament\Resources\UserResource\Pages\EditUser;
use Hydrat\GroguCMS\Filament\Resources\UserResource\Pages\ListUsers;
use Hydrat\GroguCMS\Tests\Models\User;
use Livewire\Livewire;

/**
 * UserResource tests.
 *
 * The UserResource is notable for:
 * - Using getModel() to return config-driven model (rather than static $model property)
 * - getNavigationBadge() showing user count
 * These patterns may change in Filament v4.
 */
describe('UserResource class structure', function () {
    it('extends the Filament Resource base class', function () {
        expect(is_subclass_of(UserResource::class, Resource::class))->toBeTrue();
    });

    it('uses the user model from config', function () {
        expect(UserResource::getModel())->toBe(User::class);
    });

    it('has a navigation icon', function () {
        $property = new ReflectionProperty(UserResource::class, 'navigationIcon');

        expect($property->getValue())->toBeString()->not->toBeEmpty();
    });

    it('has a navigation sort value', function () {
        $property = new ReflectionProperty(UserResource::class, 'navigationSort');

        expect($property->getValue())->toBeInt();
    });

    it('has a navigation group', function () {
        expect(UserResource::getNavigationGroup())->toBeString()->not->toBeEmpty();
    });

    it('has a getNavigationBadge method', function () {
        expect(method_exists(UserResource::class, 'getNavigationBadge'))->toBeTrue();
    });

    it('getNavigationBadge returns a string', function () {
        expect(UserResource::getNavigationBadge())->toBeString();
    });

    it('has a getBreadcrumb method', function () {
        expect(method_exists(UserResource::class, 'getBreadcrumb'))->toBeTrue();
    });

    it('getBreadcrumb returns a non-empty string', function () {
        expect(UserResource::getBreadcrumb())->toBeString()->not->toBeEmpty();
    });

    it('has a getModelLabel method', function () {
        expect(method_exists(UserResource::class, 'getModelLabel'))->toBeTrue();
    });

    it('getModelLabel returns a non-empty string', function () {
        expect(UserResource::getModelLabel())->toBeString()->not->toBeEmpty();
    });

    it('has a form() method', function () {
        expect(method_exists(UserResource::class, 'form'))->toBeTrue();
    });

    it('has a table() method', function () {
        expect(method_exists(UserResource::class, 'table'))->toBeTrue();
    });
});

describe('UserResource pages registration', function () {
    it('registers the index page', function () {
        expect(UserResource::getPages())->toHaveKey('index');
    });

    it('registers the create page', function () {
        expect(UserResource::getPages())->toHaveKey('create');
    });

    it('registers the edit page', function () {
        expect(UserResource::getPages())->toHaveKey('edit');
    });

    it('maps index to ListUsers', function () {
        expect(UserResource::getPages()['index']->getPage())->toBe(ListUsers::class);
    });

    it('maps create to CreateUser', function () {
        expect(UserResource::getPages()['create']->getPage())->toBe(CreateUser::class);
    });

    it('maps edit to EditUser', function () {
        expect(UserResource::getPages()['edit']->getPage())->toBe(EditUser::class);
    });
});

describe('UserResource page classes', function () {
    it('ListUsers extends Filament ListRecords', function () {
        expect(is_subclass_of(ListUsers::class, \Filament\Resources\Pages\ListRecords::class))->toBeTrue();
    });

    it('CreateUser extends Filament CreateRecord', function () {
        expect(is_subclass_of(CreateUser::class, \Filament\Resources\Pages\CreateRecord::class))->toBeTrue();
    });

    it('EditUser extends Filament EditRecord', function () {
        expect(is_subclass_of(EditUser::class, \Filament\Resources\Pages\EditRecord::class))->toBeTrue();
    });
});

describe('UserResource Livewire rendering', function () {
    it('can render the list page', function () {
        actingAsAdmin();

        Livewire::test(ListUsers::class)
            ->assertSuccessful();
    });

    it('can render the create page', function () {
        actingAsAdmin();

        Livewire::test(CreateUser::class)
            ->assertSuccessful();
    });
});
