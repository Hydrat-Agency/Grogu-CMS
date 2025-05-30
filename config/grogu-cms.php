<?php

return [

    /**
     * Define the models that Grogu CMS core should use.
     */
    'models' => [
        'user' => 'App\Models\User',
        'page' => Hydrat\GroguCMS\Models\Page::class,
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
        'user_resource' => Hydrat\GroguCMS\Filament\Resources\UserResource::class,
        'page_resource' => Hydrat\GroguCMS\Filament\Resources\PageResource::class,
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
     * Define user and permissions settings.
     */
    'users' => [
        'guard' => 'web',
        'permissions_registrar' => Hydrat\GroguCMS\PermissionRegistrar::class,
        // 'guarded_resource' => [
        //     Hydrat\GroguCMS\Filament\Resources\PageResource::class,
        //     Hydrat\GroguCMS\Filament\Resources\MenuResource::class,
        //     Hydrat\GroguCMS\Filament\Resources\UserResource::class,
        //     Hydrat\GroguCMS\Filament\Resources\RoleResource::class,
        // ],
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
     * Configure how the static sections should be handled.
     */
    'sections' => [
        /**
         * Define the available locations that sections can attach to.
         */
        'locations' => [
            // 'pre-footer' => 'Before footer',
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

    /**
     * Configure if Grogu CMS should handle translatable resources (displays the language switcher).
     */
    'translatable' => true,

];
