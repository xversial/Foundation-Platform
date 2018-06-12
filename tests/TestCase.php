<?php

namespace Tests;

use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');
        putenv('DB_PREFIX=""');

        parent::setUp();

        $this->app['Illuminate\Contracts\Http\Kernel']->disableMiddleware();

        $this->setUpPlatform();
    }

    /**
     * Setup platform.
     */
    protected function setUpPlatform()
    {
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
        $this->app['extensions']->boot();
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
