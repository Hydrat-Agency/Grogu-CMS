<?php

namespace Hydrat\GroguCMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
            get: fn () => $this->linkeable_type !== 'url'
                ? $this->linkeable?->url
                : $this->url,
            set: fn ($value) => $this->url = $value,
        );
    }
}