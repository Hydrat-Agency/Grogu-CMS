<?php

namespace Hydrat\GroguCMS\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Hydrat\GroguCMS\Events;
use Illuminate\Database\Eloquent\Relations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Hydrat\GroguCMS\Models\Concerns as CmsConcerns;
use Hydrat\GroguCMS\Models\Contracts as CmsContracts;

abstract class CmsModel extends Model implements HasMedia, CmsContracts\HasBlueprint, CmsContracts\HasSeo
{
    use InteractsWithMedia;
    use CmsConcerns\HasSlug;
    use CmsConcerns\InteractsWithBlueprint;
    use CmsConcerns\InteractsWithSeo;

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
        'blocks' => 'array',
        'published_at' => 'datetime',
        'manually_updated_at' => 'datetime',
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
}
