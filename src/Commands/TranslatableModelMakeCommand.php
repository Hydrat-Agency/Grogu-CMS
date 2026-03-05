<?php

namespace Hydrat\GroguCMS\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'grogu:make-translatable-model')]
class TranslatableModelMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'grogu:make-translatable-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model extending a Grogu CMS base model with LexiTranslatable support.';

    /**
     * Map of known short names to their full Grogu CMS model class.
     *
     * @var array<string, string>
     */
    protected array $knownModels = [
        'page' => \Hydrat\GroguCMS\Models\Page::class,
        'section' => \Hydrat\GroguCMS\Models\Section::class,
        'form' => \Hydrat\GroguCMS\Models\Form::class,
        'formfield' => \Hydrat\GroguCMS\Models\FormField::class,
    ];

    /**
     * Map of known model base classes to their config key under 'models'.
     *
     * @var array<string, string>
     */
    protected array $configKeys = [
        \Hydrat\GroguCMS\Models\Page::class => 'page',
        \Hydrat\GroguCMS\Models\Section::class => 'section',
        \Hydrat\GroguCMS\Models\Form::class => 'form',
        \Hydrat\GroguCMS\Models\FormField::class => 'form_field',
    ];

    /**
     * Execute the console command.
     */
    public function handle(): ?bool
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return false;
        }

        $qualifiedClass = $this->qualifyClass($this->getNameInput());
        $extendsClass = $this->resolveExtendsClass();
        $configKey = $this->configKeys[$extendsClass] ?? null;

        $this->newLine();

        if ($configKey) {
            $this->components->info(
                "Don't forget to update <comment>config/grogu-cms.php</comment> to use your new model:"
            );
            $this->components->bulletList([
                "'models' => ['{$configKey}' => {$qualifiedClass}::class]",
            ]);
        } else {
            $this->components->info(
                "Don't forget to update <comment>config/grogu-cms.php</comment> to point to your new model class."
            );
        }

        $this->newLine();

        return true;
    }

    /**
     * Build the class with the given name.
     */
    protected function buildClass($name): string
    {
        $extendsClass = $this->resolveExtendsClass();
        $baseClass = class_basename($extendsClass);

        $stub = parent::buildClass($name);
        $stub = str_replace('{{ extends }}', $extendsClass, $stub);
        $stub = str_replace('{{ baseClass }}', $baseClass, $stub);

        return $stub;
    }

    /**
     * Resolve the fully-qualified class name of the base model to extend.
     */
    protected function resolveExtendsClass(): string
    {
        $extends = $this->option('extends');

        if (! $extends) {
            $shortName = Str::lower(class_basename($this->getNameInput()));

            return $this->knownModels[$shortName]
                ?? 'Hydrat\\GroguCMS\\Models\\'.class_basename($this->getNameInput());
        }

        // If no backslash, assume it's a short name or bare class name
        if (! str_contains($extends, '\\')) {
            $lower = Str::lower($extends);

            return $this->knownModels[$lower]
                ?? 'Hydrat\\GroguCMS\\Models\\'.$extends;
        }

        return $extends;
    }

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/translatable-model.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     */
    protected function resolveStubPath(string $stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    /**
     * Get the default namespace for the class.
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\\Models';
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
            ['extends', null, InputOption::VALUE_OPTIONAL, 'The Grogu CMS base model class to extend (e.g. Page, Section, Form, or a FQCN)'],
        ];
    }
}
