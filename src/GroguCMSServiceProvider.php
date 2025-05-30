<?php

namespace Hydrat\GroguCMS;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Hydrat\GroguCMS\Livewire as LivewireComponents;
use Hydrat\GroguCMS\Testing\TestsGroguCMS;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GroguCMSServiceProvider extends PackageServiceProvider
{
    public static string $name = 'grogu-cms';

    public static string $viewNamespace = 'grogu-cms';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasAssets()
            ->hasRoute('web')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('Hydrat-Agency/Grogu-CMS');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {
        $this->app->register(Providers\FilamentServiceProvider::class);
        $this->app->register(Providers\EventServiceProvider::class);
    }

    public function boot()
    {
        parent::boot();

        app('config')->set('permissions.enable_wildcard_permission', true);
    }

    public function packageBooted(): void
    {
        $this->loadLivewireComponents();
        $this->loadBladeComponents();

        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__.'/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/grogu-cms/{$file->getFilename()}"),
                ], 'grogu-cms-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsGroguCMS);

        Blade::directive('groguScripts', function () {
            return "<?php echo '<script type=\"text/javascript\" src=\"/vendor/grogu-cms/grogu-cms.js\"></script>'; ?>";
        });
    }

    protected function getAssetPackageName(): ?string
    {
        return 'hydrat/grogu-cms';
    }

    protected function loadLivewireComponents(): void
    {
        Livewire::component('grogu-cms::menu-item-tree-widget', \Hydrat\GroguCMS\Filament\Resources\MenuResource\Widgets\MenuItemTreeWidget::class);
        Livewire::component('grogu-cms::welcome-user', \Hydrat\GroguCMS\Filament\Pages\WelcomeUser::class);
        Livewire::component('grogu-cms::contact-form', LivewireComponents\ContactForm::class);
    }

    protected function loadBladeComponents(): void
    {
        Blade::component('grogu-cms::forms.input', 'forms.input');
        Blade::component('grogu-cms::forms.textarea', 'forms.textarea');
        Blade::component('grogu-cms::forms.select', 'forms.select');
        Blade::component('grogu-cms::forms.checkbox-confirm', 'forms.checkbox-confirm');
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('grogu-cms', __DIR__ . '/../resources/dist/components/grogu-cms.js'),
            Css::make('grogu-cms-styles', __DIR__.'/../resources/dist/grogu-cms.css'),
            // Js::make('grogu-cms-scripts', __DIR__.'/../resources/dist/grogu-cms.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            Commands\CmsModelMakeCommand::class,
            Commands\BlueprintMakeCommand::class,
            // Commands\TemplateMakeCommand::class,
            Commands\GroguSearchReplaceCommand::class,
            Commands\SitemapGenerateCommand::class,
            Commands\UpdatePermissionsCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'add_avatar_url_to_users_table',
            'create_menus_table',
            'create_menu_items_table',
            'create_forms_table',
            'create_form_fields_table',
            'create_form_entries_table',
            'create_pages_table',
            'create_sections_table',
            'add_hidden_label_to_form_fields_table',
            'add_label_field_to_form_fields_table',
        ];
    }
}
