<?php

namespace Hydrat\GroguCMS\Models;

use Hydrat\GroguCMS\Events\CmsModelSaved;
use Hydrat\GroguCMS\Events\CmsModelDeleted;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Hydrat\GroguCMS\Enums\PostStatus;
use Hydrat\GroguCMS\Events;
use Hydrat\GroguCMS\Models\Concerns as CmsConcerns;
use Hydrat\GroguCMS\Models\Contracts as CmsContracts;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Support\Fluent;
use RalphJSmit\Filament\MediaLibrary\Media\Models\MediaLibraryItem;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sitemap\Contracts\Sitemapable;

abstract class CmsModel extends Model implements CmsContracts\HasBlocks, CmsContracts\HasBlueprint, CmsContracts\HasSeo, HasMedia, Sitemapable
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
        'saved' => CmsModelSaved::class,
        'deleted' => CmsModelDeleted::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(static::class, 'parent_id');
    }

    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(MediaLibraryItem::class, 'thumbnail_id');
    }

    // public function blocks(): Attribute
    // {
    //     return new Attribute(
    //         get: fn ($value) => collect(json_decode($value, true) ?: [])->map(fn ($block) => new Fluent($block)),
    //         set: fn ($value) => json_encode($value),
    //     );
    // }

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
