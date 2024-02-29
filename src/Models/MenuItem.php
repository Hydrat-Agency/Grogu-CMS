<?php

namespace Hydrat\GroguCMS\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class MenuItem extends Model
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
            get: fn ($value) => $this->linkeable_type !== null
                ? $this->linkeable?->url
                : $value,
        );
    }
}
