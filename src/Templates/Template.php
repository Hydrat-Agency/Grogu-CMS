<?php

namespace Hydrat\GroguCMS\Templates;

use Illuminate\Support\Str;

abstract class Template
{
    protected string $name = 'default';

    protected ?string $label = null;

    protected ?string $description = null;

    protected ?string $view = null;

    protected array $for = [];

    protected bool $supportsExcerpt = true;

    public function name(): string
    {
        return $this->name;
    }

    public function label(): string
    {
        return $this->label
            ?: Str::title($this->name());
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function view(): ?string
    {
        return $this->view;
    }

    public function for(): array
    {
        return $this->for;
    }

    public function hasExcerpt(): bool
    {
        return $this->supportsExcerpt;
    }

    public function hasContent(): bool
    {
        return blank($this->blocks());
    }

    public function hasBlocks(): bool
    {
        return filled($this->blocks());
    }

    public function isEnabledFor(string $model): bool
    {
        return in_array($model, $this->for());
    }

    public function blocks(): array
    {
        return [
            //
        ];
    }
}
