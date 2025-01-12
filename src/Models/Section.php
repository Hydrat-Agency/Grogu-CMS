<?php

namespace Hydrat\GroguCMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends CmsModel
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string<BlueprintContract>
     */
    protected static string $blueprintSchema = \Hydrat\GroguCMS\Content\Blueprints\SectionBlueprint::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'title',
        'location',
        'blocks',
    ];
}
