<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		return require __DIR__.'/../bootstrap/app.php';
	}

	/**
	 * {@inheritdoc}
	 */
	public function setUp()
	{
		parent::setUp();

		$this->app['router']->enableFilters();

		$this->setUpPlatform();
	}

	/**
	 * Setup platform.
	 */
	protected function setUpPlatform()
	{
		$this->migrate();

		// Installer instance
		$installer = $this->app['platform.installer'];

		// Get database driver
		$driver = $this->app['db']->connection()->getDriverName();

		// Get database config
		$config = $this->app['config']->get("database.connections.{$driver}");

		// Set database config
		$installer->setDatabaseData($driver, $config);

		// Migrate packages
		$installer->install(true);

		// Migrate application.
		$this->app['artisan']->call('migrate', ['--env' => 'testing']);

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

		foreach ($tableNames as $table)
		{
			Schema::drop($table);
		}

		$this->app['artisan']->call('migrate:install', ['--env' => 'testing']);
	}

}
