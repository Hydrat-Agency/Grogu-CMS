<?php

namespace Hydrat\GroguCMS\Actions\Form;

use Hydrat\GroguCMS\Datas\FormEntryValue;
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

        $validated = $this->manageAttachments($validated);

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

        event(new FormEntryCreated($entry));

        return $entry;
    }

    protected function manageAttachments(array $validated): array
    {
        foreach ($validated as $key => $value) {
            if ($value instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $validated[$key] = $value->store('attachments');
            }
        }

        return $validated;
    }
}
