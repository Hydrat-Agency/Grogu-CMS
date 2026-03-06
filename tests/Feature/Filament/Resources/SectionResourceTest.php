<?php

use Filament\Resources\Resource;
use Hydrat\GroguCMS\Filament\Contracts\HasBlueprint;
use Hydrat\GroguCMS\Filament\Resources\SectionResource;
use Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages\CreateSection;
use Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages\EditSection;
use Hydrat\GroguCMS\Filament\Resources\SectionResource\Pages\ListSections;
use Hydrat\GroguCMS\Models\Section;
use Livewire\Livewire;

/**
 * SectionResource tests.
 *
 * SectionResource implements HasBlueprint, which drives the form's blocks builder.
 * This contract and the InteractsWithBlueprint concern may need updates for v4.
 */
describe('SectionResource class structure', function () {
    it('extends the Filament Resource base class', function () {
        expect(is_subclass_of(SectionResource::class, Resource::class))->toBeTrue();
    });

    it('implements HasBlueprint', function () {
        expect(is_a(SectionResource::class, HasBlueprint::class, true))->toBeTrue();
    });

    it('uses the Section model by default', function () {
        expect(SectionResource::getModel())->toBe(Section::class);
    });

    it('uses model from config when overridden', function () {
        config()->set('grogu-cms.models.section', Section::class);

        expect(SectionResource::getModel())->toBe(Section::class);
    });

    it('has a navigation icon', function () {
        $property = new ReflectionProperty(SectionResource::class, 'navigationIcon');

        expect($property->getValue())->toBeString()->not->toBeEmpty();
    });

    it('has a navigation sort value', function () {
        $property = new ReflectionProperty(SectionResource::class, 'navigationSort');

        expect($property->getValue())->toBeInt();
    });

    it('has a navigation group', function () {
        expect(SectionResource::getNavigationGroup())->toBeString()->not->toBeEmpty();
    });

    it('has a label', function () {
        expect(SectionResource::getLabel())->toBeString()->not->toBeEmpty();
    });

    it('has a plural label', function () {
        expect(SectionResource::getPluralLabel())->toBeString()->not->toBeEmpty();
    });
});

describe('SectionResource pages registration', function () {
    it('registers the index page', function () {
        expect(SectionResource::getPages())->toHaveKey('index');
    });

    it('registers the create page', function () {
        expect(SectionResource::getPages())->toHaveKey('create');
    });

    it('registers the edit page', function () {
        expect(SectionResource::getPages())->toHaveKey('edit');
    });

    it('maps index to ListSections', function () {
        expect(SectionResource::getPages()['index']->getPage())->toBe(ListSections::class);
    });

    it('maps create to CreateSection', function () {
        expect(SectionResource::getPages()['create']->getPage())->toBe(CreateSection::class);
    });

    it('maps edit to EditSection', function () {
        expect(SectionResource::getPages()['edit']->getPage())->toBe(EditSection::class);
    });
});

describe('SectionResource page classes', function () {
    it('ListSections extends Filament ListRecords', function () {
        expect(is_subclass_of(ListSections::class, \Filament\Resources\Pages\ListRecords::class))->toBeTrue();
    });

    it('CreateSection extends Filament CreateRecord', function () {
        expect(is_subclass_of(CreateSection::class, \Filament\Resources\Pages\CreateRecord::class))->toBeTrue();
    });

    it('EditSection extends Filament EditRecord', function () {
        expect(is_subclass_of(EditSection::class, \Filament\Resources\Pages\EditRecord::class))->toBeTrue();
    });
});

describe('SectionResource Livewire rendering', function () {
    it('can render the list page', function () {
        actingAsAdmin();

        Livewire::test(ListSections::class)
            ->assertSuccessful();
    });

    it('can render the create page', function () {
        actingAsAdmin();

        Livewire::test(CreateSection::class)
            ->assertSuccessful();
    });
});
