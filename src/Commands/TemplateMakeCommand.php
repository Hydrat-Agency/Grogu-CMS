<?php

namespace Hydrat\GroguCMS\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:template')]
class TemplateMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Template class.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (parent::handle() === false && ! $this->option('force')) {
            return;
        }
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $model = $this->option('model') ?: 'Page';
        $templateName = $this->option('templateName') ?: Str::snake($this->getNameInput());

        if (! Str::startsWith($model, [
            $this->laravel->getNamespace(),
            'Illuminate',
            '\\',
        ])) {
            $model = $this->laravel->getNamespace().'Models\\'.str_replace('/', '\\', $model);
        }

        $stub = str_replace(
            '{{ model }}', class_basename($model), parent::buildClass($name)
        );

        $stub = str_replace(
            '{{ modelPlural }}', Str::of(class_basename($model))->lower()->plural(), $stub
        );

        $stub = str_replace(
            '{{ templateName }}', $templateName, $stub
        );

        $stub = str_replace(
            '{{ label }}', str($templateName)->title(), $stub
        );

        return $stub;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/template.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Content\Templates';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the model already exists'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model class creating a Blueprint for'],
            ['templateName', 't', InputOption::VALUE_OPTIONAL, 'The template technical name'],
        ];
    }
}
