<?php

namespace Elnooronline\LaravelConcerns\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class FilterMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:filter {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new filter.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'filter';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return  __DIR__.'/../Stubs/Filter.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Http\Filters';
    }

    /**
     * Replace the namespace for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return $this
     */
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            ['DummyNamespace', 'DummyClass'],
            [$this->getNamespace($name), $this->argument('name')],
            $stub
        );

        return $this;
    }
}
