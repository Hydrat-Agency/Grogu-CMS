<?php

namespace Hydrat\GroguCMS\Models;

use Hydrat\GroguCMS\Content\Blueprints\SectionBlueprint;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Section extends CmsModel
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var string<BlueprintContract>
     */
    protected static string $blueprintSchema = SectionBlueprint::class;

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

    /**
     * The list of translatable fields for the model.
     *
     * @var array
     */
    protected $translatableFields = [
        'blocks',
    ];
}
