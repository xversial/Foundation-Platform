<?php namespace Platform\Operate\Install;
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Platform
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Foundation\Application;
use Illuminate\Validation\Factory as ValidationFactory;

class Repository {

	/**
	 * Laravel application instance.
	 * 
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * The extension's validation factory object.
	 *
	 * @var Illuminate\Validation\Factory
	 */
	protected $validation;

	/**
	 * The database configuration for each database
	 * driver. This is because each database has different
	 * configuration options available. The configurations
	 * below match up with the default configurations
	 * specified by Laravel.
	 *
	 * Also, you'll notice the PDO driver prefix for each
	 * database configuration is skipped. This is because we
	 * are going to assume the driver matches the connection
	 * name. If somebody wants customization on this, they can
	 * go edit their database.php file themselves.
	 *
	 * @var array
	 */
	protected $databaseConfig = array(

		'sqlite' => array(
			'database' => '',
			'prefix'   => '',
		),

		'mysql' => array(
			'host'      => 'localhost',
			'database'  => '',
			'username'  => '',
			'password'  => '',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

		'pgsql' => array(
			'host'     => 'localhost',
			'database' => '',
			'username' => '',
			'password' => '',
			'charset'  => 'utf8',
			'prefix'   => '',
            'schema'   => 'public',
		),

		'sqlsrv' => array(
			'host'     => 'localhost',
			'database' => '',
			'username' => '',
			'password' => '',
			'prefix'   => '',
		),

	);

	/**
	 * The rules to match the databse configuration
	 * above. This helps us validate the configuration
	 * provided to this repository before we even
	 * attempt to install Platform.
	 *
	 * @var array
	 */
	protected $databaseRules = array(

		'sqlite' => array(
			'driver'   => 'Required',
			'database' => 'Required',
		),

		'mysql' => array(
			'host'      => 'Required',
			'database'  => 'Required',
			'username'  => 'Required',
			'charset'   => 'Required',
			'collation' => 'Required',
		),

		'pgsql' => array(
			'host'     => 'Required',
			'database' => 'Required',
			'username' => 'Required',
		),

		'sqlsrv' => array(
			'host'     => 'Required',
			'database' => 'Required',
			'username' => 'Required',
		),
	);

	/**
	 * Holds the chosen database driver.
	 *
	 * @var string
	 */
	protected $databseDriver;

	/**
	 * Initializes a new installer repository.
	 *
	 * @param  Illuminate\Foundation\Application  $app
	 * @param  Illumiante\Validation\Factory  $validation
	 * @return void
	 */
	public function __construct(Application $app, ValidationFactory $validation)
	{
		$this->app        = $app;
		$this->validation = $validation;
	}

	/**
	 * Gets the available databse drivers.
	 *
	 * @return array
	 */
	public function getDatabaseDrivers()
	{
		return array_keys($this->databaseConfig);
	}

	/**
	 * Sets the chosen database driver.
	 *
	 * @param  string  $driver
	 * @return void
	 */
	public function setDatabaseDriver($driver)
	{
		// We don't support adding new drivers
		if ( ! isset($this->databaseConfig[$driver]))
		{
			throw new \RuntimeException("Database configuration does not exist for driver [$driver].");
		}

		$this->databaseDriver = $driver;
	}

	/**
	 * Gets the database driver.
	 *
	 * @return string
	 */
	public function getDatabaseDriver()
	{
		return $this->databaseDriver;
	}

	/**
	 * Sets the database configuration for a driver.
	 *
	 * @param  string  $driver
	 * @param  array   $config
	 * @return void
	 */
	public function setDatabaseConfig($driver, array $config)
	{
		// We don't support adding new drivers
		if ( ! isset($this->databaseConfig[$driver]))
		{
			throw new \RuntimeException("Database configuration does not exist for driver [$driver].");
		}

		$this->databaseConfig[$driver] = $config;
	}

	/**
	 * Merges the database configuration for a driver.
	 *
	 * @param  string  $driver
	 * @param  array   $config
	 * @return void
	 */
	public function mergeDatabaseConfig($driver, array $config)
	{
		// We don't support adding new drivers
		if ( ! isset($this->databaseConfig[$driver]))
		{
			throw new \RuntimeException("Database configuration does not exist for driver [$driver].");
		}

		$this->databaseConfig[$driver] = array_merge(
			$this->databaseConfig[$driver],
			$config
		);
	}

	/**
	 * Gets the database configuration for a driver.
	 *
	 * @return array
	 */
	public function getDatabaseConfig($driver = null)
	{
		// Default driver
		if ($driver === null)
		{
			$driver = $this->getDatabaseDriver();
		}

		// We don't support adding new drivers
		if ( ! isset($this->databaseConfig[$driver]))
		{
			throw new \RuntimeException("Database configuration does not exist for driver [$driver].");
		}

		return $this->databaseConfig[$driver];
	}

	/**
	 * Returns the validator for the databse
	 * configuration.
	 *
	 * @param  string  $driver
	 * @return Illumiante\Validation\Validator
	 */
	public function getDatabaseConfigValidator($driver = null)
	{
		// Default driver
		if ($driver === null)
		{
			$driver = $this->getDatabaseDriver();
		}

		// We don't support adding new drivers
		if ( ! isset($this->databaseConfig[$driver]))
		{
			throw new \RuntimeException("Database configuration does not exist for driver [$driver].");
		}

		return $this->validation->make($this->databaseConfig[$driver], $this->databaseRules[$driver]);
	}

	/**
	 * Checks for a databse connection.
	 *
	 * @return bool
	 */
	public function checkDatabaseConnection($driver = null)
	{
		// Default driver
		if ($driver === null)
		{
			$driver = $this->getDatabaseDriver();
		}

		// We don't support adding new drivers
		if ( ! isset($this->databaseConfig[$driver]))
		{
			throw new \RuntimeException("Database configuration does not exist for driver [$driver].");
		}

		// Let's try turn the connection. An exception will
		// be thrown if we are not successful.
		return (bool) $this->app['db.factory']->make(array_merge(
			array('driver' => $driver),
			$this->databaseConfig[$driver]
		));
	}

}