<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();

        $this->app['Illuminate\Contracts\Http\Kernel']->disableMiddleware();

        $this->setUpPlatform();
    }

    /**
     * Setup platform.
     */
    protected function setUpPlatform()
    {
        $this->app['config']->set('database.connections.sqlite.prefix', null);
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');
        $this->app['config']->set('database.default', 'sqlite');

        // Installer instance
        $installer = $this->app['platform.installer'];

        // Get database config
        $config = $this->app['config']->get("database.connections.sqlite");

        $this->migrate();

        // Set database config
        $installer->setDatabaseData('sqlite', $config);

        // Migrate packages
        $installer->install(true);

        // Migrate application.
        $this->app['Illuminate\Contracts\Console\Kernel']->call('migrate', ['--env' => 'testing']);

        // Boot extensions
        $this->app['platform']->bootExtensions();
    }

    /**
     * Resets the database and install the migration table.
     *
     * @return void
     */
    protected function migrate()
    {
        $tableNames = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tableNames as $table) {
            Schema::drop($table);
        }

        $this->app['Illuminate\Contracts\Console\Kernel']->call('migrate:install', ['--env' => 'testing']);
    }
}
