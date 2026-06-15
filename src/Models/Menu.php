<?php

namespace Hydrat\GroguCMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'location',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(config('grogu-cms.models.menu_item') ?: MenuItem::class)
            ->orderBy('order');
    }

    public function elements(): HasMany
    {
        return $this->hasMany(config('grogu-cms.models.menu_item') ?: MenuItem::class)
            ->orderBy('order')
            ->whereNull('parent_id');
    }
}
