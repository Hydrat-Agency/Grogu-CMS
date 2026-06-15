<?php

namespace Hydrat\GroguCMS\View\Composers;

use Hydrat\GroguCMS\GroguCMS;
use Illuminate\View\View;

class MenuComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct(
        protected GroguCMS $groguCMS,
    ) {}

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('menus', $this->groguCMS->menus());
    }
}
