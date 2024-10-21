<?php

namespace Hydrat\GroguCMS\Actions\Form;

use Hydrat\GroguCMS\Events\FormEntryCreated;
use Hydrat\GroguCMS\Models\Form;
use Hydrat\GroguCMS\Models\FormEntry;
use Hydrat\GroguCMS\Models\FormField;
use Lorisleiva\Actions\Concerns\AsAction;

class SubmitFormEntry
{
    use AsAction;

    public function handle(Form $form, array $validated): FormEntry
    {
        $form->loadMissing('fields');

        $fields = $form->fields->sortBy('order')->map(
            fn (FormField $field) => [
                'key' => $field->key,
                'type' => $field->type,
                'label' => $field->name,
                'value' => $validated[$field->key] ?? null,
                'required' => $field->required,
            ]
        );

        $values = FormEntryValue::collect($fields);

        $entry = $form->entries()->create([
            'user_id' => auth()->id(),
            'submitted_at' => now(),
            'values' => $values,
        ]);

        dispatch(new FormEntryCreated($entry));

        return $entry;
    }
}
