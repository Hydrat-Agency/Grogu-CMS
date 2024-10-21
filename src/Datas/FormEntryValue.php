<?php

namespace Hydrat\GroguCMS\Datas;

use Hydrat\GroguCMS\Enums\FormFieldType;
use Spatie\LaravelData\Data;

class FormEntryValue extends Data
{
    public function __construct(
        public string $key,
        public FormFieldType $type,
        public string $label,
        public mixed $value = null,
        public bool $required = false,
    ) {
    }

    public function displayValue(): string
    {
        return match (true) {
            is_array($this->value) => implode(', ', $this->value),
            default => (string) $this->value,
        };
    }
}
