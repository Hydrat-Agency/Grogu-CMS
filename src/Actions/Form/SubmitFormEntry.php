<?php

namespace Hydrat\GroguCMS\Actions\Form;

use Hydrat\GroguCMS\Models\Form;
use Hydrat\GroguCMS\Models\FormEntry;
use Lorisleiva\Actions\Concerns\AsAction;

class SubmitFormEntry
{
    use AsAction;

    public function handle(Form $form, array $validated): FormEntry
    {
        $entry = $form->entries()->create([
            'user_id' => auth()->id(),
            'values' => $validated,
            'submitted_at' => now(),
        ]);

        // trigger submission events

        return $entry;
    }
}
