<?php

namespace Hydrat\GroguCMS\Models;

use Hydrat\GroguCMS\Models\CmsModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends CmsModel
{
    use SoftDeletes;
    use HasFactory;

    /**
     * @var string<BlueprintContract>
     */
    protected static string $blueprintSchema = \Hydrat\GroguCMS\Blueprints\SectionBlueprint::class;

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
