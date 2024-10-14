<?php

namespace Hydrat\GroguCMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;

class Form extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
    ];

    public function fields(): Relations\HasMany
    {
        return $this->hasMany(FormField::class)->orderBy('order');
    }

    public function entries(): Relations\HasMany
    {
        return $this->hasMany(FormEntry::class);
    }
}
