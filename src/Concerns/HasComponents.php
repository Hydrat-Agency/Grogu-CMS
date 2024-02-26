<?php

namespace Hydrat\GroguCMS\Concerns;

use Illuminate\Filesystem\Filesystem;
use Livewire\Component;
use Livewire\Livewire;
use Livewire\Mechanisms\ComponentRegistry;
use ReflectionClass;

trait HasComponents
{
    /**
     * @var array<string, class-string>
     */
    protected array $livewireComponents = [];

    protected function registerLivewireComponents(): void
    {
        foreach ($this->livewireComponents as $componentName => $componentClass) {
            Livewire::component($componentName, $componentClass);
        }

        $this->livewireComponents = [];
    }

    public function discoverLivewireComponents(string $in, string $for): static
    {
        $component = [];

        $this->discoverComponents(
            Component::class,
            $component,
            directory: $in,
            namespace: $for,
        );

        return $this;
    }

    /**
     * @param  array<string, class-string<Component>>  $register
     */
    protected function discoverComponents(string $baseClass, array &$register, ?string $directory, ?string $namespace): void
    {
        if (blank($directory) || blank($namespace)) {
            return;
        }

        $filesystem = app(Filesystem::class);

        if ((! $filesystem->exists($directory)) && (! str($directory)->contains('*'))) {
            return;
        }

        $namespace = str($namespace);

        foreach ($filesystem->allFiles($directory) as $file) {
            $variableNamespace = $namespace->contains('*') ? str_ireplace(
                ['\\' . $namespace->before('*'), $namespace->after('*')],
                ['', ''],
                str($file->getPath())
                    ->after(base_path())
                    ->replace(['/'], ['\\']),
            ) : null;

            if (is_string($variableNamespace)) {
                $variableNamespace = (string) str($variableNamespace)->before('\\');
            }

            $class = (string) $namespace
                ->append('\\', $file->getRelativePathname())
                ->replace('*', $variableNamespace ?? '')
                ->replace(['/', '.php'], ['\\', '']);

            if (! class_exists($class)) {
                continue;
            }

            if ((new ReflectionClass($class))->isAbstract()) {
                continue;
            }

            if (is_subclass_of($class, Component::class)) {
                $this->queueLivewireComponentForRegistration($class);
            }

            if (! is_subclass_of($class, $baseClass)) {
                continue;
            }

            if (
                method_exists($class, 'isDiscovered') &&
                (! $class::isDiscovered())
            ) {
                continue;
            }

            $register[] = $class;
        }
    }

    /**
     * @param  array<string, class-string<Component>>  $components
     */
    public function livewireComponents(array $components): static
    {
        foreach ($components as $component) {
            $this->queueLivewireComponentForRegistration($component);
        }

        return $this;
    }

    protected function queueLivewireComponentForRegistration(string $component): void
    {
        $componentName = app(ComponentRegistry::class)->getName($component);

        $this->livewireComponents[$componentName] = $component;
    }
}
