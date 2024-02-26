<?php

namespace Hydrat\GroguCMS\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:cms-model')]
class CmsModelMakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:cms-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Eloquent model class that extends CmsModel';

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

        if ($this->option('blueprint')) {
            $this->createBlueprint();
        }
    }

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createBlueprint()
    {
        $blueprint = Str::studly($this->argument('name'));

        $this->call('make:blueprint', [
            'name' => "{$blueprint}Blueprint",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        return $class;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/cms-model.stub');
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
        return $rootNamespace.'\Models';
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
            ['blueprint', 'b', InputOption::VALUE_NONE, 'Create a new blueprint for the model'],
        ];
    }
}
