<?php

namespace Hydrat\GroguCMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

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

    public function items(): Relations\HasMany
    {
        return $this->hasMany(config('grogu-cms.models.menu_item') ?: MenuItem::class);
    }
}
