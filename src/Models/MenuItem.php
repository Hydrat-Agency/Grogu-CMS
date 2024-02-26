<?php

namespace Hydrat\GroguCMS\Models;

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
    ];

    public function menu(): Relations\BelongsTo
    {
        return $this->belongsTo(config('grogu-cms.models.menu') ?: Menu::class);
    }
}
