<?php

use Hydrat\GroguCMS\Filament\Resources\FormResource;
use Hydrat\GroguCMS\Filament\Resources\MenuResource;
use Hydrat\GroguCMS\Filament\Resources\PageResource;
use Hydrat\GroguCMS\Filament\Resources\SectionResource;
use Hydrat\GroguCMS\Filament\Resources\UserResource;
use Hydrat\GroguCMS\Models\Form;
use Hydrat\GroguCMS\Models\FormEntry;
use Hydrat\GroguCMS\Models\FormField;
use Hydrat\GroguCMS\Models\Menu;
use Hydrat\GroguCMS\Models\MenuItem;
use Hydrat\GroguCMS\Models\Page;
use Hydrat\GroguCMS\Models\Section;
use Hydrat\GroguCMS\PermissionRegistrar;

return [

    /**
     * Define the models that Grogu CMS core should use.
     */
    'models' => [
        'user' => 'App\Models\User',
        'page' => Page::class,
        'menu' => Menu::class,
        'menu_item' => MenuItem::class,
        'form' => Form::class,
        'form_field' => FormField::class,
        'form_entry' => FormEntry::class,
        'section' => Section::class,
    ],

    /**
     * Define the resources that should be registred by the plugin.
     */
    'resources' => [
        'user_resource' => UserResource::class,
        'page_resource' => PageResource::class,
        'menu_resource' => MenuResource::class,
        'form_resource' => FormResource::class,
        'section_resource' => SectionResource::class,
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
        'permissions_registrar' => PermissionRegistrar::class,
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
    'translatable' => false,

];
