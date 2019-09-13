<?php

namespace Elnooronline\LaravelConcerns\Tests;

use Collective\Html\HtmlServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Elnooronline\LaravelConcerns\Providers\ServiceProvider;
use Elnooronline\LaravelConcerns\Tests\Providers\AuthServiceProvider;
use Elnooronline\LaravelBootstrapForms\Providers\BootstrapFormsServiceProvider;

class TestCase extends OrchestraTestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->loadLaravelMigrations(['--database' => 'testbench']);
    }

    /**
     * Load package service provider
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class,
            AuthServiceProvider::class,
            BootstrapFormsServiceProvider::class,
            HtmlServiceProvider::class,
        ];
    }

    /**
     * Load package alias
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'BsForm' => \Elnooronline\LaravelBootstrapForms\Facades\BsForm::class,
            'Form' => \Collective\Html\FormFacade::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}