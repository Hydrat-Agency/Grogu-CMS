<?php

namespace Hydrat\GroguCMS\Models;

use Hydrat\GroguCMS\Models\Contracts\Resourceable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Nevadskiy\Tree\AsTree;
use Nevadskiy\Tree\Collections\NodeCollection;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class MenuItem extends Model implements Resourceable, Sortable
{
    use AsTree {
        hasCircularReference as hasCircularReferenceTrait;
        joinAncestors as joinAncestorsTrait;
    }
    use HasFactory;
    use SortableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'menu_id',
        'title',
        'parent_id',
        'path',
        'linkeable_id',
        'linkeable_type',
        'url',
        'anchor',
        'external',
        'new_tab',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'url',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'linkeable',
        'children',
    ];

    public function toResource(): JsonResource
    {
        return new \Hydrat\GroguCMS\Http\Resources\MenuItemResource($this);
    }

    public function buildSortQuery()
    {
        return static::query()
            ->when($this->parent_id, fn ($query) => $query->where('parent_id', $this->parent_id))
            ->when(! $this->parent_id, fn ($query) => $query->whereNull('parent_id'));
    }

    protected function hasCircularReference(): bool
    {
        $this->loadMissing('parent');

        return $this->hasCircularReferenceTrait();
    }

    public function joinAncestors(): NodeCollection
    {
        $this->loadMissing('ancestors');

        return $this->joinAncestorsTrait();
    }

    public function menu(): Relations\BelongsTo
    {
        return $this->belongsTo(Menu::class);
    }

    public function linkeable(): Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function url(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes) => match ($attributes['linkeable_type']) {
                null, 'url' => $attributes['url'],
                default => ($anchor = $attributes['anchor'])
                    ? Str::finish(Str::beforeLast($this->linkeable?->url ?: '', '#'), '#'.$anchor)
                    : $this->linkeable?->url,
            },
            set: fn ($value) => $value
        );
    }
}
