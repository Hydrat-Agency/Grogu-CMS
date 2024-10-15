<?php

namespace Hydrat\GroguCMS\Actions\Form;

use Hydrat\GroguCMS\Models\Form;
use Hydrat\GroguCMS\Models\FormField;
use Hydrat\GroguCMS\Enums\FormFieldType;
use Lorisleiva\Actions\Concerns\AsAction;

class GetFormValidationRules
{
    use AsAction;

    public function handle(
        Form $form,
        ?string $prefixKey = null,
        ?callable $getKeyUsing = null,
        ?callable $getRulesUsing = null,
    ): array {
        $form->loadMissing('fields');

        $getKeyUsing ??= fn (FormField $field) => ((string) $prefixKey) . $field->key;
        $getRulesUsing ??= fn (FormField $field, ?string $key = null) => $this->getRulesForField($field, $key);

        return $form->fields->reduce(function (array $carry, FormField $field) use ($getKeyUsing, $getRulesUsing) {
            $key = $getKeyUsing($field);
            $rules = $getRulesUsing($field, $key);

            return array_merge($carry, array_filter($rules));
        }, []);
    }

    protected function getRulesForField(FormField $field, ?string $key = null): array
    {
        $key ??= $field->key;

        $rules = [
            $key => [],
        ];

        if ($field->required) {
            $rules[$key][] = 'required';
        }

        if ($field->type === FormFieldType::Email) {
            $rules[$key][] = 'email';
        }

        if ($field->type === FormFieldType::Number) {
            $rules[$key][] = 'numeric';
        }

        if ($field->type === FormFieldType::Telephone) {
            $rules[$key][] = 'regex:/^\+?[0-9]+$/';
        }

        if ($field->type === FormFieldType::Date) {
            $rules[$key][] = 'date';
        }

        if ($field->type === FormFieldType::DateTime) {
            $rules[$key][] = 'date';
        }

        if ($field->type === FormFieldType::Confirm) {
            $rules[$key][] = 'boolean';
        }

        if ($field->type->canBeMultiple() && ($field->type->alwaysMultiple() || $field->multiple)) {
            $rules[$key][] = 'array';

            if ($field->type->hasOptions()) {
                if (!isset($rules[$key.'*'])) {
                    $rules[$key.'*'] = [];
                }

                $rules[$key.'*'][] = 'in:' . collect($field->options)->pluck('value')->join(',');
            }
        } else {
            if ($field->type->hasOptions()) {
                $rules[$key][] = 'in:' . collect($field->options)->pluck('value')->join(',');
            }
        }

        if ($field->type->hasMinMax()) {
            if ($field->min) {
                $rules[$key][] = 'min:'.$field->min;
            }
            if ($field->max) {
                $rules[$key][] = 'max:'.$field->max;
            }
        }

        if ($field->type->hasDateMinMax()) {
            if ($field->min) {
                $rules[$key][] = 'after_or_equal:'.$field->min;
            }
            if ($field->max) {
                $rules[$key][] = 'before_or_equal:'.$field->max;
            }
        }

        return $rules;
    }
}
