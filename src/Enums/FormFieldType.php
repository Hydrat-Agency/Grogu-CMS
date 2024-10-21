<?php

namespace Hydrat\GroguCMS\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum FormFieldType: string implements HasColor, HasIcon, HasLabel
{
    case Text = 'text';
    case Textarea = 'textarea';
    case Email = 'email';
    case Telephone = 'telephone';
    case Number = 'number';
    case Date = 'date';
    case DateTime = 'date_time';
    case Radio = 'radio';
    case Checkbox = 'checkbox';
    case Select = 'select';
    case Image = 'image';
    case Attachment = 'attachment';
    case Signature = 'signature';
    case Placeholder = 'placeholder';
    case Confirm = 'confirm';

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Text => 'info',
            self::Textarea => 'info',
            self::Email => 'info',
            self::Telephone => 'info',
            self::Number => 'info',
            self::Date => 'warning',
            self::DateTime => 'warning',
            self::Radio => 'danger',
            self::Checkbox => 'danger',
            self::Select => 'danger',
            self::Image => 'success',
            self::Attachment => 'success',
            self::Signature => 'success',
            self::Placeholder => 'gray',
            self::Confirm => 'danger',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Text => __('Text'),
            self::Textarea => __('Text zone'),
            self::Email => __('Email'),
            self::Telephone => __('Telephone'),
            self::Number => __('Number'),
            self::Date => __('Date'),
            self::DateTime => __('Date time'),
            self::Radio => __('Radio selection'),
            self::Checkbox => __('Checkbox'),
            self::Select => __('Dropdown'),
            self::Image => __('Image'),
            self::Attachment => __('Attachment'),
            self::Signature => __('Signature'),
            self::Placeholder => __('Placeholder'),
            self::Confirm => __('Confirm'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Text => 'radix-text',
            self::Textarea => 'radix-text-align-left',
            self::Email => 'radix-envelope-closed',
            self::Telephone => 'phosphor-phone',
            self::Number => 'phosphor-number-circle-one-light',
            self::Date => 'phosphor-calendar-blank-light',
            self::DateTime => 'phosphor-calendar-light',
            self::Radio => 'radix-radiobutton',
            self::Checkbox => 'radix-checkbox',
            self::Select => 'heroicon-o-chevron-up-down',
            self::Image => 'radix-image',
            self::Attachment => 'radix-file',
            self::Signature => 'phosphor-signature-light',
            self::Placeholder => 'phosphor-chat-centered-text-light',
            self::Confirm => 'radix-check',
        };
    }

    public function hasHelperText(): bool
    {
        return match ($this) {
            default => true,
        };
    }

    public function hasPlaceholder(): bool
    {
        return match ($this) {
            self::Text => true,
            self::Textarea => true,
            self::Email => true,
            self::Number => true,
            self::Date => true,
            self::DateTime => true,
            self::Select => true,
            default => false,
        };
    }

    public function canBeMultiple(): bool
    {
        return match ($this) {
            self::Select => true,
            self::Checkbox => true,
            self::Image => true,
            self::Attachment => true,
            default => false,
        };
    }

    public function alwaysMultiple(): bool
    {
        return match ($this) {
            self::Checkbox => true,
            default => false,
        };
    }

    public function hasOptions(): bool
    {
        return match ($this) {
            self::Radio => true,
            self::Checkbox => true,
            self::Select => true,
            default => false,
        };
    }

    public function hasContent(): bool
    {
        return match ($this) {
            self::Placeholder => true,
            self::Confirm => true,
            default => false,
        };
    }

    public function hasMinMax(): bool
    {
        return match ($this) {
            self::Text => true,
            self::Textarea => true,
            self::Email => true,
            self::Telephone => true,
            self::Number => true,
            self::Checkbox => true,
            default => false,
        };
    }

    public function hasDateMinMax(): bool
    {
        return match ($this) {
            self::Date => true,
            self::DateTime => true,
            default => false,
        };
    }

    public function hasRows(): bool
    {
        return match ($this) {
            self::Textarea => true,
            default => false,
        };
    }

    public function minLabel(): string
    {
        return match ($this) {
            self::Text, self::Textarea, self::Email => __('Minimum length'),
            self::Number => __('Minimum value'),
            self::Checkbox, self::Select, self::Image, self::Attachment => __('Minimum number of selections'),
            self::Date, self::DateTime => __('Minimum date'),
            default => __('Minimum'),
        };
    }

    public function maxLabel(): string
    {
        return match ($this) {
            self::Text, self::Textarea, self::Email => __('Maximum length'),
            self::Number => __('Maximum value'),
            self::Checkbox, self::Select, self::Image, self::Attachment => __('Maximum number of selections'),
            self::Date, self::DateTime => __('Maximum date'),
            default => __('Maximum'),
        };
    }

    public function getValidationRules(): array
    {
        return match ($this) {
            self::Text, self::Textarea => ['string'],
            self::Email => ['email'],
            self::Telephone => ['regex:/^\+?[0-9]+$/'],
            self::Number => ['numeric'],
            self::Date, self::DateTime => ['date'],
            self::Confirm => ['boolean'],
            default => [],
        };
    }
}
