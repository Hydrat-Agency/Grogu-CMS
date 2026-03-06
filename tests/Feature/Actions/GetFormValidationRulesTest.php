<?php

use Hydrat\GroguCMS\Actions\Form\GetFormValidationRules;
use Hydrat\GroguCMS\Enums\FormFieldType;
use Hydrat\GroguCMS\Models\Form;
use Hydrat\GroguCMS\Models\FormField;

describe('GetFormValidationRules', function () {
    it('returns an empty array for a form with no fields', function () {
        $form = Form::create(['name' => 'Contact']);

        $rules = GetFormValidationRules::run($form);

        expect($rules)->toBeArray()->toBeEmpty();
    });

    it('generates a key based on field id', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Name',
            'type' => FormFieldType::Text,
            'order' => 1,
        ]);

        $rules = GetFormValidationRules::run($form);

        expect($rules)->toHaveKey("q{$field->id}");
    });

    it('adds required rule for required fields', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Name',
            'type' => FormFieldType::Text,
            'required' => true,
            'order' => 1,
        ]);

        $rules = GetFormValidationRules::run($form);

        expect($rules["q{$field->id}"])->toContain('required');
    });

    it('does not add required rule for optional fields', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Optional',
            'type' => FormFieldType::Text,
            'required' => false,
            'order' => 1,
        ]);

        $rules = GetFormValidationRules::run($form);

        expect($rules["q{$field->id}"])->not->toContain('required');
    });

    it('adds email validation rule for email fields', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Email',
            'type' => FormFieldType::Email,
            'order' => 1,
        ]);

        $rules = GetFormValidationRules::run($form);

        expect($rules["q{$field->id}"])->toContain('email');
    });

    it('adds numeric validation rule for number fields', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Age',
            'type' => FormFieldType::Number,
            'order' => 1,
        ]);

        $rules = GetFormValidationRules::run($form);

        expect($rules["q{$field->id}"])->toContain('numeric');
    });

    it('adds date validation rule for date fields', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Birthday',
            'type' => FormFieldType::Date,
            'order' => 1,
        ]);

        $rules = GetFormValidationRules::run($form);

        expect($rules["q{$field->id}"])->toContain('date');
    });

    it('adds min rule when field has min constraint', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Message',
            'type' => FormFieldType::Textarea,
            'min' => 10,
            'order' => 1,
        ]);

        $rules = GetFormValidationRules::run($form);

        expect($rules["q{$field->id}"])->toContain('min:10');
    });

    it('adds max rule when field has max constraint', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Message',
            'type' => FormFieldType::Text,
            'max' => 255,
            'order' => 1,
        ]);

        $rules = GetFormValidationRules::run($form);

        expect($rules["q{$field->id}"])->toContain('max:255');
    });

    it('adds in rule for select fields with options', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Color',
            'type' => FormFieldType::Select,
            'options' => collect([
                ['value' => 'red', 'label' => 'Red'],
                ['value' => 'blue', 'label' => 'Blue'],
            ]),
            'order' => 1,
        ]);

        $rules = GetFormValidationRules::run($form);

        expect(implode(',', $rules["q{$field->id}"]))->toContain('in:red,blue');
    });

    it('adds array rule for multiple-select fields', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Colors',
            'type' => FormFieldType::Select,
            'multiple' => true,
            'options' => collect([['value' => 'red', 'label' => 'Red']]),
            'order' => 1,
        ]);

        $rules = GetFormValidationRules::run($form);

        expect($rules["q{$field->id}"])->toContain('array');
    });

    it('supports a custom prefix key', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Name',
            'type' => FormFieldType::Text,
            'order' => 1,
        ]);

        $rules = GetFormValidationRules::run($form, prefixKey: 'form.');

        expect($rules)->toHaveKey("form.q{$field->id}");
    });

    it('supports a custom getKeyUsing callback', function () {
        $form = Form::create(['name' => 'Contact']);
        $field = FormField::create([
            'form_id' => $form->id,
            'name' => 'Name',
            'type' => FormFieldType::Text,
            'order' => 1,
        ]);

        $rules = GetFormValidationRules::run(
            form: $form,
            getKeyUsing: fn ($f) => 'custom_'.$f->id,
        );

        expect($rules)->toHaveKey("custom_{$field->id}");
    });
});
