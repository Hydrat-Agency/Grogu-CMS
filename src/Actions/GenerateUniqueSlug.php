<?php

namespace Hydrat\GroguCMS\Actions;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class GenerateUniqueSlug
{
    use AsAction;

    public function handle(?string $title = null, ?Model $model = null): string
    {
        if (! $title) {
            return '';
        }

        $parentId = $model?->parent_id ?: null;
        $slug = $model?->slug ?: Str::slug($title);
        $i = 1;

        while (
            $model::class::where('slug', $slug)
                ->when($model, fn ($q) => $q->where('id', '!=', $model->id))
                ->when($parentId, fn ($q) => $q->where('parent_id', $parentId))
                ->when(! $parentId, fn ($q) => $q->whereNull('parent_id'))
                ->exists()
        ) {
            $slug = Str::slug($title.'-'.$i++);
        }

        return $slug;
    }
}
