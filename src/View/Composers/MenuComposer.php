<?php

namespace Hydrat\GroguCMS\View\Composers;

use Illuminate\View\View;

class MenuComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct(
        protected \Hydrat\GroguCMS\GroguCMS $groguCMS,
    ) {}

    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $view->with('menus', $this->groguCMS->menus());
    }
}
