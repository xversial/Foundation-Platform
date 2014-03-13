<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Symfony\Component\HttpKernel\HttpKernelInterface
	 */
	public function createApplication()
	{
		$unitTesting = true;

		$testEnvironment = 'testing';

		return require __DIR__.'/../../bootstrap/start.php';
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
		// Migrations table
		$this->app['artisan']->call('migrate');
		$this->app['artisan']->call('migrate:reset');

		// Installer instance
		$installer = $this->app['platform.installer'];

		// Get database driver
		$driver = $this->app['db']->connection()->getDriverName();

		// Set database driver
		$installer->getRepository()->setDatabaseDriver($driver);

		// Get database config
		$config = $this->app['config']->get("database.connections.{$driver}");

		// Set database config
		$installer->getRepository()->setDatabaseConfig($driver, $config);

		// Migrate packages
		$installer->migrateRequiredPackages();

		// Migrate platform
		$installer->migrateFoundation();

		// Migrate extensions
		$installer->installExtensions();

		// Boot extensions
		$this->app['platform']->bootExtensions();
	}
}
