<?php

namespace Hydrat\GroguCMS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Hydrat\GroguCMS\Models\Contracts\Resourceable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenuItem extends Model implements Resourceable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'menu_id',
        'title',
        'linkeable_id',
        'linkeable_type',
        'url',
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
    ];

    public function toResource(): JsonResource
    {
        return new \Hydrat\GroguCMS\Http\Resources\MenuItemResource($this);
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
            get: fn ($value, $attributes) => $attributes['linkeable_type'] && $attributes['linkeable_type'] !== 'url'
                ? $this->linkeable?->url
                : $attributes['url'],
            set: fn ($value) => $value
        );
    }
}
