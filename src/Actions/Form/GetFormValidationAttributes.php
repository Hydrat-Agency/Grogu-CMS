<?php

namespace Hydrat\GroguCMS\Actions\Form;

use Hydrat\GroguCMS\Models\Form;
use Hydrat\GroguCMS\Models\FormField;
use Lorisleiva\Actions\Concerns\AsAction;

class GetFormValidationAttributes
{
    use AsAction;

    public function handle(
        Form $form,
        ?string $prefixKey = null,
        ?callable $getKeyUsing = null,
        ?callable $getAttributNameUsing = null,
    ): array {
        $form->loadMissing('fields');

        $getKeyUsing ??= fn (FormField $field) => ((string) $prefixKey).$field->key;
        $getAttributNameUsing ??= fn (FormField $field) => $field->name;

        return $form->fields->mapWithKeys(
            fn ($field) => [$getKeyUsing($field) => $getAttributNameUsing($field)]
        )->toArray();
    }
}
