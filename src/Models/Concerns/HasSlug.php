<?php

namespace Hydrat\GroguCMS\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait HasSlug
{
    public static function scopeWhereSlug(Builder $query, string $slug)
    {
        $parts = str($slug)->trim('/')->explode('/');
        $slug = $parts->last();

        $query->where('slug', $slug);
    }

    public static function findBySlug(string $slug)
    {
        return static::whereSlug($slug)->first();
    }

    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function findBySlugOrFail(string $slug): static
    {
        if (! ($record = static::findBySlug($slug))) {
            throw new ModelNotFoundException(
                str()->of(static::class)->afterLast('\\')." with slug `{$slug}` not found.",
                404,
            );
        }

        return $record;
    }
}
