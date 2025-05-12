<?php

namespace Hydrat\GroguCMS\Models;

use Hydrat\GroguCMS\Events;
use Illuminate\Support\Fluent;
use Spatie\MediaLibrary\HasMedia;
use Hydrat\GroguCMS\Enums\PostStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sitemap\Contracts\Sitemapable;
use Illuminate\Database\Eloquent\Relations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Hydrat\GroguCMS\Models\Concerns as CmsConcerns;
use Hydrat\GroguCMS\Models\Contracts as CmsContracts;
use Omaralalwi\LexiTranslate\Traits\LexiTranslatable;
use RalphJSmit\Filament\MediaLibrary\Media\Models\MediaLibraryItem;

abstract class CmsModel extends Model implements CmsContracts\HasBlocks, CmsContracts\HasBlueprint, CmsContracts\HasSeo, HasMedia, Sitemapable
{
    use CmsConcerns\HasSlug;
    use CmsConcerns\InteractsWithBlocks;
    use CmsConcerns\InteractsWithBlueprint;
    use CmsConcerns\InteractsWithSeo;
    use InteractsWithMedia;
    use LexiTranslatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'parent_id',
        'thumbnail_id',
        'title',
        'status',
        'slug',
        'template',
        'content',
        'excerpt',
        'blocks',
    ];

    /**
     * The list of translatable fields for the model.
     *
     * @var array
     */
    protected $translatableFields = [
        'title',
        'slug',
        'content',
        'excerpt',
        'blocks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'blocks' => 'array',
        'status' => PostStatus::class,
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

    public function scopeStatus(Builder $query, PostStatus $status)
    {
        return $query->where('status', $status->value);
    }

    public function scopePublished(Builder $query)
    {
        return $this->scopeStatus($query, PostStatus::Published);
    }

    public function scopeDraft(Builder $query)
    {
        return $this->scopeStatus($query, PostStatus::Draft);
    }
}
