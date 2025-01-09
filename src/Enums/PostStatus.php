<?php

namespace Hydrat\GroguCMS\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PostStatus: string implements HasColor, HasIcon, HasLabel
{
    case Draft = 'draft';
    case Published = 'published';
    case Scheduled = 'scheduled';
    case Private = 'private';

    public static function default(): PostStatus
    {
        return self::Draft;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'gray',
            self::Published => 'success',
            self::Scheduled => 'warning',
            self::Private => 'indigo',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => __('Draft'),
            self::Published => __('Published'),
            self::Scheduled => __('Scheduled'),
            self::Private => __('Private'),
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Draft => 'phosphor-pencil-ruler',
            self::Published => 'phosphor-eye',
            self::Scheduled => 'phosphor-timer',
            self::Private => 'phosphor-eye-slash',
        };
    }
}
