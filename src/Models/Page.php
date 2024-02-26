<?php

namespace Hydrat\GroguCMS\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Hydrat\GroguCMS\Models\CmsModel;

class Page extends CmsModel
{
    use SoftDeletes;
    use HasFactory;

    /**
     * @var string<BlueprintContract>
     */
    protected static string $blueprintSchema = \Hydrat\GroguCMS\Blueprints\PageBlueprint::class;
}