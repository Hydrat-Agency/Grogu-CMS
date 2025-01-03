<?php

namespace Hydrat\GroguCMS\Models;

use Hydrat\GroguCMS\Events;
use Hydrat\GroguCMS\Models\Concerns as CmsConcerns;
use Hydrat\GroguCMS\Models\Contracts as CmsContracts;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Support\Fluent;
use RalphJSmit\Filament\MediaLibrary\Media\Models\MediaLibraryItem;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

abstract class CmsModel extends Model implements CmsContracts\HasBlocks, CmsContracts\HasBlueprint, CmsContracts\HasSeo, HasMedia
{
    use CmsConcerns\HasSlug;
    use CmsConcerns\InteractsWithBlocks;
    use CmsConcerns\InteractsWithBlueprint;
    use CmsConcerns\InteractsWithSeo;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'parent_id',
        'title',
        'slug',
        'template',
        'thumbnail_id',
        'published_at',
        'excerpt',
        'description',
        'content',
        'blocks',
        'manually_updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
        'manually_updated_at' => 'datetime',
        'blocks' => 'array',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saved' => Events\CmsModelSaved::class,
        'deleted' => Events\CmsModelDeleted::class,
    ];

    public function user(): Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function parent(): Relations\BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children(): Relations\HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function thumbnail(): Relations\BelongsTo
    {
        return $this->belongsTo(MediaLibraryItem::class, 'thumbnail_id');
    }

    public function blocks(): Attribute
    {
        return new Attribute(
            get: fn ($value) => collect(json_decode($value, true) ?: [])->map(fn ($block) => new Fluent($block)),
            set: fn ($value) => json_encode($value),
        );
    }
}
