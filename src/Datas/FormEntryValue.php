<?php

namespace Hydrat\GroguCMS\Datas;

use Spatie\LaravelData\Data;
use Hydrat\GroguCMS\Enums\FormFieldType;

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
}
