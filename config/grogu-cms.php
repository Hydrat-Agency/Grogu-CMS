<?php

return [

    /**
     * Define the models that Grogu CMS core should use.
     */
    'models' => [
        'menu' => Hydrat\GroguCMS\Models\Menu::class,
        'menu_item' => Hydrat\GroguCMS\Models\MenuItem::class,
        'form' => Hydrat\GroguCMS\Models\Form::class,
        'form_field' => Hydrat\GroguCMS\Models\FormField::class,
        'form_entry' => Hydrat\GroguCMS\Models\FormEntry::class,
        'section' => Hydrat\GroguCMS\Models\Section::class,
    ],

    /**
     * Define the resources that should be registred by the plugin.
     */
    'resources' => [
        'menu_resource' => Hydrat\GroguCMS\Filament\Resources\MenuResource::class,
        'form_resource' => Hydrat\GroguCMS\Filament\Resources\FormResource::class,
        'section_resource' => Hydrat\GroguCMS\Filament\Resources\SectionResource::class,
    ],

    /**
     * Define the pages that should be registred by the plugin.
     */
    'pages' => [
        //
    ],

    /**
     * Define the pages that should be registred by the plugin.
     */
    'widgets' => [
        //
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

    /**
     * Configure how the SEO features should be handled.
     */
    'seo' => [
        'on_save' => false,

        'sitemap' => [
            'path' => '/storage/app/public/sitemap.xml',
            'uri' => '/storage/sitemap.xml',

            'crawl' => false,
            'models' => [
                // \App\Models\Page::class,
            ],
        ],
    ],

];
