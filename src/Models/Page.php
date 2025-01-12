<?php

namespace Hydrat\GroguCMS\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use RalphJSmit\Laravel\SEO\Support\HasSEO;

class Page extends CmsModel
{
    use HasFactory;
    use HasSEO;
    use SoftDeletes;

    /**
     * @var string<BlueprintContract>
     */
    protected static string $blueprintSchema = \Hydrat\GroguCMS\Content\Blueprints\PageBlueprint::class;
}
