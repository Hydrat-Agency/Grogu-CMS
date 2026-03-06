<?php

use Filament\Resources\Resource;
use Hydrat\GroguCMS\Filament\Resources\FormResource;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\CreateForm;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\EditForm;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\ListForms;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\ManageFormEntries;
use Hydrat\GroguCMS\Filament\Resources\FormResource\Pages\ManageFormFields;
use Hydrat\GroguCMS\Models\Form;
use Livewire\Livewire;

/**
 * FormResource tests.
 *
 * The FormResource has sub-navigation with dedicated pages for entries and fields.
 * The getRecordSubNavigation() pattern and multi-page resource structure may
 * change between Filament v3 and v4.
 */
describe('FormResource class structure', function () {
    it('extends the Filament Resource base class', function () {
        expect(is_subclass_of(FormResource::class, Resource::class))->toBeTrue();
    });

    it('uses the Form model by default', function () {
        expect(FormResource::getModel())->toBe(Form::class);
    });

    it('uses model from config when overridden', function () {
        config()->set('grogu-cms.models.form', Form::class);

        expect(FormResource::getModel())->toBe(Form::class);
    });

    it('has a navigation icon', function () {
        $property = new ReflectionProperty(FormResource::class, 'navigationIcon');

        expect($property->getValue())->toBeString()->not->toBeEmpty();
    });

    it('has a navigation sort value', function () {
        $property = new ReflectionProperty(FormResource::class, 'navigationSort');

        expect($property->getValue())->toBeInt();
    });

    it('has a navigation group', function () {
        expect(FormResource::getNavigationGroup())->toBeString()->not->toBeEmpty();
    });

    it('has a label', function () {
        expect(FormResource::getLabel())->toBeString()->not->toBeEmpty();
    });

    it('has a plural label', function () {
        expect(FormResource::getPluralLabel())->toBeString()->not->toBeEmpty();
    });

    it('has a getRecordSubNavigation method', function () {
        expect(method_exists(FormResource::class, 'getRecordSubNavigation'))->toBeTrue();
    });

    it('has a recordTitleAttribute set', function () {
        $property = new ReflectionProperty(FormResource::class, 'recordTitleAttribute');

        expect($property->getValue())->toBeString()->not->toBeEmpty();
    });
});

describe('FormResource pages registration', function () {
    it('registers the index page', function () {
        expect(FormResource::getPages())->toHaveKey('index');
    });

    it('registers the create page', function () {
        expect(FormResource::getPages())->toHaveKey('create');
    });

    it('registers the edit page', function () {
        expect(FormResource::getPages())->toHaveKey('edit');
    });

    it('registers the fields page', function () {
        expect(FormResource::getPages())->toHaveKey('fields');
    });

    it('registers the entries page', function () {
        expect(FormResource::getPages())->toHaveKey('entries');
    });

    it('maps index to ListForms', function () {
        expect(FormResource::getPages()['index']->getPage())->toBe(ListForms::class);
    });

    it('maps create to CreateForm', function () {
        expect(FormResource::getPages()['create']->getPage())->toBe(CreateForm::class);
    });

    it('maps edit to EditForm', function () {
        expect(FormResource::getPages()['edit']->getPage())->toBe(EditForm::class);
    });

    it('maps fields to ManageFormFields', function () {
        expect(FormResource::getPages()['fields']->getPage())->toBe(ManageFormFields::class);
    });

    it('maps entries to ManageFormEntries', function () {
        expect(FormResource::getPages()['entries']->getPage())->toBe(ManageFormEntries::class);
    });
});

describe('FormResource page classes', function () {
    it('ListForms extends Filament ListRecords', function () {
        expect(is_subclass_of(ListForms::class, \Filament\Resources\Pages\ListRecords::class))->toBeTrue();
    });

    it('CreateForm extends Filament CreateRecord', function () {
        expect(is_subclass_of(CreateForm::class, \Filament\Resources\Pages\CreateRecord::class))->toBeTrue();
    });

    it('EditForm extends Filament EditRecord', function () {
        expect(is_subclass_of(EditForm::class, \Filament\Resources\Pages\EditRecord::class))->toBeTrue();
    });
});

describe('FormResource Livewire rendering', function () {
    it('can render the list page', function () {
        actingAsAdmin();

        Livewire::test(ListForms::class)
            ->assertSuccessful();
    });

    it('can render the create page', function () {
        actingAsAdmin();

        Livewire::test(CreateForm::class)
            ->assertSuccessful();
    });
});
