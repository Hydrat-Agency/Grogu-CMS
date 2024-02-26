<?php

return [

    /**
     * Define the models that the CMS should use.
     */
    'models' => [
        'menu' => Hydrat\GroguCMS\Models\Menu::class,
        'menu_item' => Hydrat\GroguCMS\Models\MenuItem::class,
    ],

    /**
     * Configure how the navigation should be handled.
     */
    'menus' => [
        'enabled' => true,
        'translate_labels' => true,

        /**
         * Define the available locations that navigation can attach to.
         */
        'locations' => [
            'main' => 'Main location',
        ],
    ],

];
