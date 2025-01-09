<?php

namespace Hydrat\GroguCMS\Models;

use RalphJSmit\Laravel\SEO\Support\HasSEO;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends CmsModel
{
    use HasFactory;
    use SoftDeletes;
    use HasSEO;

    /**
     * @var string<BlueprintContract>
     */
    protected static string $blueprintSchema = \Hydrat\GroguCMS\Blueprints\PageBlueprint::class;
}
