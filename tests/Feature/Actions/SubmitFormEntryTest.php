<?php

use Hydrat\GroguCMS\Actions\Form\SubmitFormEntry;
use Hydrat\GroguCMS\Enums\FormFieldType;
use Hydrat\GroguCMS\Events\FormEntryCreated;
use Hydrat\GroguCMS\Models\Form;
use Hydrat\GroguCMS\Models\FormEntry;
use Hydrat\GroguCMS\Models\FormField;
use Illuminate\Support\Facades\Event;

describe('SubmitFormEntry', function () {
    it('creates a FormEntry record in the database', function () {
        $form = Form::create(['name' => 'Contact Form']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Name',
            'type' => FormFieldType::Text,
            'order' => 1,
        ]);

        SubmitFormEntry::run($form, ["q{$field->id}" => 'Alice']);

        expect(FormEntry::count())->toBe(1);
    });

    it('associates the entry with the form', function () {
        $form = Form::create(['name' => 'Newsletter']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Email',
            'type' => FormFieldType::Email,
            'order' => 1,
        ]);

        $entry = SubmitFormEntry::run($form, ["q{$field->id}" => 'alice@example.com']);

        expect($entry->form_id)->toBe($form->id);
    });

    it('stores submitted_at timestamp', function () {
        $form = Form::create(['name' => 'Survey']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Rating',
            'type' => FormFieldType::Number,
            'order' => 1,
        ]);

        $entry = SubmitFormEntry::run($form, ["q{$field->id}" => 5]);

        expect($entry->submitted_at)->not->toBeNull();
    });

    it('stores field values in the entry', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Message',
            'type' => FormFieldType::Textarea,
            'order' => 1,
        ]);

        $entry = SubmitFormEntry::run($form, ["q{$field->id}" => 'Hello there!']);

        expect($entry->values)->not->toBeEmpty();
        $values = collect($entry->values);
        expect($values->first()->value)->toBe('Hello there!');
    });

    it('stores the field key in the entry values', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Email',
            'type' => FormFieldType::Email,
            'order' => 1,
        ]);

        $entry = SubmitFormEntry::run($form, ["q{$field->id}" => 'test@example.com']);

        $values = collect($entry->values);
        expect($values->first()->key)->toBe("q{$field->id}");
    });

    it('stores the field label in the entry values', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Full Name',
            'type' => FormFieldType::Text,
            'order' => 1,
        ]);

        $entry = SubmitFormEntry::run($form, ["q{$field->id}" => 'Alice Smith']);

        $values = collect($entry->values);
        expect($values->first()->label)->toBe('Full Name');
    });

    it('handles fields not present in the submitted data', function () {
        $form = Form::create(['name' => 'Contact']);
        FormField::create([
            'form_id' => $form->id,
            'name' => 'Optional',
            'type' => FormFieldType::Text,
            'required' => false,
            'order' => 1,
        ]);

        // Submit with no data for the field
        $entry = SubmitFormEntry::run($form, []);

        expect($entry)->toBeInstanceOf(FormEntry::class);
        $values = collect($entry->values);
        expect($values->first()->value)->toBeNull();
    });

    it('dispatches the FormEntryCreated event', function () {
        Event::fake([FormEntryCreated::class]);

        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Email',
            'type' => FormFieldType::Email,
            'order' => 1,
        ]);

        SubmitFormEntry::run($form, ["q{$field->id}" => 'alice@example.com']);

        Event::assertDispatched(FormEntryCreated::class);
    });

    it('returns the created FormEntry instance', function () {
        $form = Form::create(['name' => 'Survey']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Feedback',
            'type' => FormFieldType::Textarea,
            'order' => 1,
        ]);

        $entry = SubmitFormEntry::run($form, ["q{$field->id}" => 'Great!']);

        expect($entry)->toBeInstanceOf(FormEntry::class);
        expect($entry->exists)->toBeTrue();
    });

    it('stores fields in their order', function () {
        $form = Form::create(['name' => 'Survey']);
        $fieldA = FormField::create([
            'form_id' => $form->id,
            'name' => 'First',
            'type' => FormFieldType::Text,
            'order' => 1,
        ]);
        $fieldB = FormField::create([
            'form_id' => $form->id,
            'name' => 'Second',
            'type' => FormFieldType::Text,
            'order' => 2,
        ]);

        $entry = SubmitFormEntry::run($form, [
            "q{$fieldA->id}" => 'Alpha',
            "q{$fieldB->id}" => 'Beta',
        ]);

        $values = collect($entry->values);
        expect($values->first()->label)->toBe('First');
        expect($values->last()->label)->toBe('Second');
    });
});
