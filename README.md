# Quickly mount a Content Management System on top of Filament on Laravel. Chose your front stack, or go Headless.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hydrat/grogu-cms.svg?style=flat-square)](https://packagist.org/packages/hydrat/grogu-cms)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/hydrat/grogu-cms/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/hydrat/grogu-cms/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/hydrat/grogu-cms/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/hydrat/grogu-cms/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/hydrat/grogu-cms.svg?style=flat-square)](https://packagist.org/packages/hydrat/grogu-cms)



This package brings CMS features to Laravel, based on top of Filament, as a drop-in replacement for Wordpress. It is designed to be used with a front-end stack of your choice, or as a headless CMS.
The package brings pre-defined resources to manage your content, settings pages, and a set of SEO tools to help you optimize your content for search engines.

While the package helps you defining your models Resources, It also comes with a predefined panel so you can also quickly get up and running.

Features :
  - Page/Post/Model management :
    - Status
    - Slug
    - Excerpt
    - Thumbnail
    - Templates
    - Flexible content blocks
    - Hierarchical structure (parent/child)
  - Custom "post types", configured via Blueprints and Template classes to avoid bloated models
  - SEO tools (meta title, meta description, meta tags, sitemap, structured data, SEO checks)
  - Menus
  - Settings pages
  - Users and Permissions management
  - Multilingual dashboard
  - You keep control on your models, migrations, routes, and views
  - Native front-end support for blade, livewire, inertia

## Screenshots



## Installation

You can install the package via composer:

```bash
composer require hydrat/grogu-cms
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="grogu-cms-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="grogu-cms-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="grogu-cms-views"
```

This is the contents of the published config file:

```php
return [
];
```

In addition, to setup dependancies, you will need to run the following commands:

- [vormkracht10/laravel-seo-scanner](https://github.com/vormkracht10/laravel-seo-scanner)

```bash
php artisan seo:install
```

If using a Javascript front-end, such as Vue or React, you will also need to install puppeteer :

```bash
npm install puppeteer
```

Then, of your public models you will need to enable Javascript on SEO checks :

```php
<?php

namespace App\Models;

use App\Cms\Models\Contracts\Resourceable;
use App\Cms\Models\CmsModel;
use Vormkracht10\Seo\Facades\Seo;
use Vormkracht10\Seo\SeoScore;

class Page extends CmsModel implements Resourceable
{
    public function seoScore(): SeoScore
    {
        return Seo::check(url: $this->url, useJavascript: true);
    }
}
```

Please read the [laravel-seo-scanner documentation](https://github.com/vormkracht10/laravel-seo-scanner) for more details.

## Usage

### Defining your models

You can easily create a model using the `make:cms-model` command :

```bash
php artisan make:cms-model Page
```

Basically, this model will be a regular Eloquent model, extending the `CmsModel` class :

```php
<?php

namespace App\Models;

class Page extends CmsModel
{
    /**
     * @var string<BlueprintContract>
     */
    protected static string $blueprintSchema = \App\Cms\Blueprints\PageBlueprint::class;
}
```

The Blueprint is where the model configuration will happen. You can generate this file automatically by adding the `--blueprint` option to the `make:cms-model` command, or using the `make:cms-blueprint` command :

```bash
php artisan make:cms-blueprint PageBlueprint
```

Blueprints helps GroguCMS by telling how to handle your model.
It will :
  - Define the front-end route to a single model (when applicable)
  - Define the front-end view to use, when using our Controller helpers
  - Enable/Disable features such as SEO, Exceprt, Content...
  - Define templates and flexible layouts
  - Define if the model is hierarchical

### Rendering your models

#### Create the routes

First, you need to create the route to your pages. Here, we define the root path to use FrontPageController, as it will read the settings defined on the admin panel.

```php
Route::get('/', Web\FrontPageShowController::class)->name('front-page.show');
Route::get('/{slug}', Web\PageShowController::class)->where('slug', '(.*)')->name('pages.show');
```

#### Using blade/livewire


#### Using inertia

When using Inertia, it is likely that you will want to filter the data sent to the browser.
To do so, GroguCMS automatically convert your model to a [JsonResource](https://laravel.com/docs/10.x/eloquent-resources) before sending it to the browser.

First, create a resource for your model :

```bash
php artisan make:resource PageResource
```

Then, add the `Resourceable` contract to your model, and implement the `toResource` method :

```php
<?php

namespace App\Models;

use App\Cms\Contracts\Resourceable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations;
use Illuminate\Http\Resources\Json\JsonResource;

class Page extends Model implements Resourceable
{
    public function toResource(): JsonResource
    {
        return new \App\Http\Resources\PageResource($this);
    }
}
```

You can then configure your resource as needed.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Thomas](https://github.com/Hydrat)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
