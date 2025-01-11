# Quickly mount a Content Management System on top of Filament on Laravel. Chose your front stack, or go Headless.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/hydrat/grogu-cms.svg?style=flat-square)](https://packagist.org/packages/hydrat/grogu-cms)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/hydrat/grogu-cms/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/hydrat/grogu-cms/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/hydrat/grogu-cms/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/hydrat/grogu-cms/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/hydrat/grogu-cms.svg?style=flat-square)](https://packagist.org/packages/hydrat/grogu-cms)

This package aims to help you building a fast, reliable, and SEO-friendly website, by providing a set of pre-configured tools to manage your content, settings, and SEO from your [Filament](filamentphp.com) panel.

It is designed to be plugged with a front-end stack of your choice (TALL, Intertia, plain blade...) or as a headless CMS.

What this package provides :

  - Users and Permissions management
  - Multilingual content (using individual models with eloquent scope instead of json columns)
  - Content management
    - Pages/Post or any Custom models
    - Menus
    - Forms
    - Page Templates
    - Blueprints
    - Flexible content blocks
    - Hierarchical structure
    - SEO tools
    - Settings pages

This CMS is developer friendly : You are keeping the entire control on your models, migrations, routes, and views. All back-office fields and layouts are defined using Filament resources.

## Packages used

The CMS plugins makes use of the following packages :

  - [ralphjsmit/laravel-filament-media-library](https://filamentphp.com/plugins/ralphjsmit-media-library-manager) for media management (Paid plugin)
  - [spatie/laravel-permission](https://spatie.be/docs/laravel-permission/v6/introduction) for role and permissions in the CMS
  - [spatie/laravel-welcome-notification](https://github.com/spatie/laravel-welcome-notification) for sending welcome emails to new users, so they can set their password
  - [spatie/laravel-sitemap](https://github.com/spatie/laravel-sitemap)
  - [ralphjsmit/laravel-seo](https://github.com/ralphjsmit/laravel-seo) for SEO tools
  - [jeffgreco13/filament-breezy](https://github.com/jeffgreco13/filament-breezy) for profile page, password change, two factor authentication, api tokens management
  - [grantholle/laravel-altcha](https://github.com/grantholle/laravel-altcha) for spam protection on forms

## Screenshots

// TODO

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

You should also publish assets from dependancies :

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --provider="Spatie\WelcomeNotification\WelcomeNotificationServiceProvider" --tag="migrations"
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"
php artisan vendor:publish --tag="seo-migrations"
php artisan vendor:publish --tag="filament-media-library-migrations"
php artisan breezy:install
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="grogu-cms-config"
```

You can publish the assets with:

```bash
php artisan vendor:publish --tag="grogu-cms-assets"
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

You will need to register the plugin into your Filament Panel :

```php
use Hydrat\GroguCMS\GroguCMSPlugin;
use Pboivin\FilamentPeek\FilamentPeekPlugin;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use RalphJSmit\Filament\MediaLibrary\FilamentMediaLibrary;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ...
            ->plugin(
                GroguCMSPlugin::make()
                    ->discoverTemplates(in: app_path('Content/Templates'), for: 'App\\Content\\Templates')
                    ->discoverBlueprints(in: app_path('Content/Blueprints'), for: 'App\\Content\\Blueprints')
                    ->discoverBlockComposers(in: app_path('Content/BlockComposers'), for: 'App\\Content\\BlockComposers'),

                FilamentPeekPlugin::make(),

                BreezyCore::make()
                    ->enableTwoFactorAuthentication()
                    ->myProfile(
                        hasAvatars: true,
                        slug: 'my-profile'
                    ),

                FilamentMediaLibrary::make()
                    ->navigationGroup(__('Site'))
                    ->navigationLabel(__('Media Library'))
                    ->navigationSort(1)
                    ->acceptImage()
                    ->acceptPdf()
                    ->acceptVideo(),
            );
    }
}
```

Adapt your User model to include required traits and methods :

```php
<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Storage;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Hydrat\GroguCMS\Notifications\WelcomeNotification;
use Filament\Models\Contracts\FilamentUser;
use Filament\AvatarProviders\UiAvatarsProvider;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\WelcomeNotification\ReceivesWelcomeNotification;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasApiTokens;
    use HasRoles;
    use Notifiable;
    use ReceivesWelcomeNotification;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url',
        'email_verified_at',
    ];

    /**
     * Get the user's avatar URL.
     */
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url
            ? Storage::disk('public')->url($this->avatar_url)
            : null;
    }

    public function getDefaultAvatarUrl()
    {
        $provider = new UiAvatarsProvider;
        return $provider->get($this);
    }

    public function sendWelcomeNotification(\Carbon\Carbon $validUntil)
    {
        $this->notify(new WelcomeNotification($validUntil));
    }
}
```

If not done already, you must create a [custom Filament theme](https://filamentphp.com/docs/3.x/panels/themes#creating-a-custom-theme) for your Panel. Then, add the following lines to the `content` key of the `tailwind.config.js` file of the theme :

```js
content: [
    // Your other files
    './vendor/hydrat/grogu-cms/resources/**/*.blade.php',
    './vendor/ralphjsmit/laravel-filament-media-library/resources/**/*.blade.php'
],
```


You'll also need to

To include Grogu scripts to your front-end, you should add the `@groguScripts` directive to your layout, preferably before the closing `</body>` tag :

```html
@groguScripts
```

This includes the Altcha front-end, required for using our Livewire form component.

In addition, to setup dependancies, you will need to run the following commands:

### Seo

```bash
# vormkracht10/laravel-seo-scanner
php artisan seo:install

# ralphjsmit/laravel-seo
php artisan vendor:publish --tag="seo-config"

php artisan migrate
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

If you plan on using our Livewire form component with an embed [ALTCha](https://altcha.org), please make sure to set the required environement variables :

```env
ALTCHA_HMAC_KEY={generated_random_key}
ALTCHA_ALGORITHM="SHA-256" # SHA-256, SHA-384 or SHA-512
```

## Usage

### Defining your models

You can easily create a model using the `make:cms-model` command :

```bash
php artisan make:cms-model Page
```

The CMS model is a regular Eloquent model extending the `CmsModel` class :

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

The Blueprint is where the content-related configuration will happen. You can generate this file automatically by adding the `--blueprint` option to the `make:cms-model` command, or using the `make:cms-blueprint` command :

```bash
php artisan make:cms-blueprint PageBlueprint
```

Blueprints helps GroguCMS by telling how to handle your model.
It will :
  - Define the front-end route to a single model (when applicable)
  - Define the front-end blade or intertia view to use, when using our Controller helpers
  - Enable and configure features such as SEO, Exceprt
  - Define templates and flexible layouts
  - Enabled hierarchical structure for the model

### Rendering your models

#### Create the routes

First, you need to create the route to your pages. Here, we define the root path to use FrontPageController, as it will read the front page setting defined on the admin panel.

```php
use Hydrat\GroguCMS\Controllers\Web\Inertia;

Route::get('/', Inertia\FrontPageShowController::class)->name('front-page.show');
Route::get('/{slug}', Inertia\PageShowController::class)->where('slug', '(.*)')->name('pages.show');
```

#### Using blade/livewire


#### Using inertia

When using Inertia, you often need to filter the model attributes sent to the browser.

To do so, GroguCMS can automatically convert your model to a [JsonResource](https://laravel.com/docs/11.x/eloquent-resources).

First, create a Laravel JsonResource for your model :

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

The GroguCMS controllers will automatically convert your model to the configured JsonResource.

## Contact form

The package provide a contact form resource that you can use to create forms on your website.

To get started, create a new form from Filament panel. You can then create your own content block to display the form on your website.

```php
// Using blade / livewire
@livewire('grogu-cms::contact-form', ['form' => $form])
```

You can override models and resources by changing your configuration file :

```php
    /**
     * Define the models that Grogu CMS core should use.
     */
    'models' => [
        'form' => App\Models\Form::class,
        'form_field' => App\Models\FormField::class,
        'form_entry' => App\Models\FormEntry::class,
    ],

    /**
     * Define the resources that should be registred by the plugin.
     */
    'resources' => [
        'form_resource' => App\Filament\Resources\FormResource::class,
    ],
```

Of course, you can also create your own Livewire component, and extend our component to customize the behavior :

```php
<?php

namespace App\Livewire;

class MyContactForm extends \Hydrat\GroguCMS\Livewire\ContactForm
{
    public function submit()
    {
        parent::submit();

        // custom after submit logic
    }

    public function render()
    {
        return view('my-contact-form');
    }
}

// @livewire('my-contact-form', ['form' => $form])
```

## Deploy to production

### Icons

As this package makes use of multiple blade icon packages (Radix, Phosphor...) it is highly recommended to cache your icons on production environment. You should add this to your deployment script :

```bash
php artisan icons:clear && php artisan icons:cache
```

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

- [tgeorgel](https://github.com/tgeorgel)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
