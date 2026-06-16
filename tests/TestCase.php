<?php

namespace Hydrat\GroguCMS\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Schemas\SchemasServiceProvider;
use Filament\SpatieLaravelSettingsPluginServiceProvider;
use Filament\Support\Livewire\Partials\DataStoreOverride;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Hydrat\GroguCMS\GroguCMSServiceProvider;
use Hydrat\GroguCMS\Tests\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Livewire\Mechanisms\DataStore;
use Orchestra\Testbench\TestCase as Orchestra;
use RalphJSmit\Filament\Explore\FilamentExploreServiceProvider;
use RalphJSmit\Filament\MediaLibrary\FilamentMediaLibraryServiceProvider;
use RalphJSmit\Laravel\SEO\LaravelSEOServiceProvider;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Spatie\LaravelData\LaravelDataServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        // Filament 5's SupportServiceProvider uses bind() instead of singleton() for DataStore,
        // which causes a new instance to be created on every app(DataStore::class) resolution.
        // This breaks Livewire's WeakMap-based DataStore because set() and get() use different
        // instances. Re-register the already-created DataStoreOverride instance as a singleton.
        $this->afterApplicationCreated(function () {
            $ds = app(DataStoreOverride::class);
            app()->instance(DataStore::class, $ds);
        });

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Hydrat\\GroguCMS\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            SchemasServiceProvider::class,
            FilamentExploreServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SpatieLaravelSettingsPluginServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            LaravelDataServiceProvider::class,
            LaravelSEOServiceProvider::class,
            MediaLibraryServiceProvider::class,
            FilamentMediaLibraryServiceProvider::class,
            PermissionServiceProvider::class,
            GroguCMSServiceProvider::class,
            AdminPanelProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        config()->set('database.default', 'testing');
        config()->set('auth.providers.users.model', User::class);
        config()->set('grogu-cms.models.user', User::class);

        // Create a class alias so CmsModel::user() (hardcoded to App\Models\User) resolves in tests.
        if (! class_exists(\App\Models\User::class)) {
            class_alias(User::class, 'App\Models\User');
        }
    }
}
