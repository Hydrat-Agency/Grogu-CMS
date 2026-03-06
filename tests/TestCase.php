<?php

namespace Hydrat\GroguCMS\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\SpatieLaravelSettingsPluginServiceProvider;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Hydrat\GroguCMS\GroguCMSServiceProvider;
use Hydrat\GroguCMS\Tests\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RalphJSmit\Filament\MediaLibrary\FilamentMediaLibraryServiceProvider;
use RalphJSmit\Laravel\SEO\LaravelSEOServiceProvider;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use Spatie\MediaLibrary\MediaLibraryServiceProvider;
use Spatie\LaravelData\LaravelDataServiceProvider;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

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
