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

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class InstallCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'platform:install';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Installs Platform';

	/**
	 * The installer repository assosiated with the command.
	 *
	 * @var string
	 */
	protected $repository;

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// Set the installer repository
		$this->repository = $this->laravel['platform']['operate.installer.repository'];

		// Build up a nice welcome message
		$this->info(<<<WELCOME

*-----------------------------------*
|                                   |
| Welcome to the Platform Installer |
|     Copyright (c) 2011 - 2013     |
|           Cartalyst LLC.          |
|                                   |
|   Platform is release under the   |
|       BSD License (3-clause)      |
|                                   |
|    For Platform news, help and    |
|       updates, please visit       |
|   getplatform.com or find us on   |
| Twitter through @cartalyst. We're |
|  also on irc.freenode.net in the  |
|        #cartalyst channel.        |
|                                   |
|    Thanks for using Platform!     |
|                                   |
*-----------------------------------*


WELCOME
		);

		// Setup counte
		$stepCounter = 1;

		// If we're not skipping the database
		if ( ! $this->input->getOption('skip-database')) {

			// First step, configure database
			$this->info(sprintf(<<<STEP

*-----------------------------------*
|                                   |
|    Step #%d: Configure Database    |
|                                   |
*-----------------------------------*

STEP
			, $stepCounter++));

			// Ask for the database configuration
			$this->askDatabaseDriver();
			$this->setupDatabaseConfig();

			$this->comment('Thanks, that configuration looks acceptable.');
		}

		$this->comment('Great, we have all the information we need. We\'ll proceed with the actual install process now.');

		try
		{
			$installer = $this->laravel['platform']['operate.installer'];

			if ( ! $this->input->getOption('skip-database'))
			{
				$installer->setupDatabase($this->repository);
			}
			if ( ! $this->input->getOption('skip-extensions'))
			{
				$installer->installCoreExtensions($this->repository);
			}

			$installer->updatePlatformInstalledVersion();
		}
		catch (\Exception $e)
		{
			$this->error('An error occured during installation:');
			throw $e;
		}

		$this->comment('Installation complete.');
	}

	/**
	 * Sets up the database config in the repository
	 * based off a number of questions asked of the user.
	 *
	 * @return void
	 */
	protected function setupDatabaseConfig()
	{
		// Get the database driver
		$driver = $this->repository->getDatabaseDriver();

		// Set the databse config based off what
		// we ask the user
		$this->repository->setDatabaseConfig(
			$driver,
			$this->askNewConfig($this->repository->getDatabaseConfig())
		);

		// Setup a loop to ask and validate database configuration
		do
		{
			// Grab the database validator from the install repo
			$validator = $this->repository->getDatabaseConfigValidator();

			// If validation fails, let's just return the
			// messages in a list form.
			if ($validator->fails())
			{
				// Didn't validate
				$proceed = false;

				// Show errors
				$this->error('Validation failed for database configuration.');
				foreach ($validator->getMessages()->all(':message') as $message)
				{
					$this->error($message);
				}

				// Check they want to try again
				if ( ! $this->confirm('Would like to try again? [y, n]'))
				{
					throw new \RuntimeException('Install aborted by user.');
				}

				// Ask for new configuration for the failed items
				$this->repository->mergeDatabaseConfig($driver, $this->askNewConfig(
					$this->repository->getDatabaseConfig(),
					array_keys($validator->getMessages()->getMessages())
				));
			}
			else
			{
				// Let's get the config as provided
				$databaseConfig = $this->repository->getDatabaseConfig();

				// Get the maximum length of a key in the
				// array so we can format everything nicely
				$maxLength = max(array_map('strlen', array_keys($databaseConfig)));

				// We'll format it nicely
				array_walk($databaseConfig, function(&$value, $key) use ($maxLength)
				{
					// +3 because of the "[]:"
					$key = str_pad("[$key]:", $maxLength + 3);
					$value = "$key $value";
				});

				// Let's confirm with the person
				$this->comment(sprintf(
					"You have provided the following configuration:\n%s",
					implode("\n", $databaseConfig)
				));

				// Don't want to proceed? We'll start again
				if ( ! $this->confirm('Are you happy to proceed? [y, n]:'))
				{
					// Let's reset the config.
					$this->repository->setDatabaseConfig($driver, array_map(function($config)
					{
						return '';
					}, $this->repository->getDatabaseConfig()));

					// Recursive baby
					$this->setupDatabaseConfig();
				}

				// Did validate, this'll break
				// the loop
				$proceed = true;
			}
		}
		while ( ! $proceed);
	}

	/**
	 * Asks for new configuration based off the old configuration.
	 *
	 * The second parameter is an array of keys from the existing
	 * config to query the user for.
	 *
	 * @param  array  $existingConfig
	 * @param  array  $keys
	 * @return array
	 */
	protected function askNewConfig($existingConfig, array $keys = array('*'))
	{
		$newConfig = array();

		// All keys?
		if ((count($keys) === 1) and (reset($keys) === '*'))
		{
			$keysToAsk = array_keys($existingConfig);
		}

		// Specified keys
		else
		{
			$keysToAsk = $keys;
		}

		// Let's go through the first time and ask
		// for the configuration
		foreach ($keysToAsk as $key)
		{
			$value = $existingConfig[$key];
			$newConfig[$key] = $this->askDatabaseConfig($key, $value);
		}

		return $newConfig;
	}

	/**
	 * Asks for a configuration item with the given key,
	 * and the current value. The user can enter through
	 * for the current configuration to be used.
	 *
	 * @param  string  $key
	 * @param  string  $current
	 * @return string
	 */
	protected function askDatabaseConfig($key, $current)
	{
		return $this->ask(sprintf(
			'Please enter database [%s] (enter for %s):',
			$key,
			($current) ? "[$current]" : 'blank'
		), $current);
	}

	/**
	 * Gets (and sets in the repository) the
	 * database driver, as specified by the
	 * user.
	 *
	 * @return string
	 */
	protected function askDatabaseDriver()
	{
		// Get valid drivers
		$drivers = $this->repository->getDatabaseDrivers();

		do
		{
			// Get driver
			$driver = $this->ask(sprintf(
				'Please enter database driver [%s]:',
				implode(', ', $drivers)
			));

			// Invalid driver?
			if ( ! in_array($driver, $drivers))
			{
				$this->error("Driver [$driver] is not a valid driver. Please try again.");

				// Keep our loop going
				$driver = false;
			}

			// Valid driver
			else
			{
				// If the person cancels out
				if ( ! $this->confirm("Are you sure you want to use the [$driver] database driver? [y, n]:"))
				{
					$driver = false;
				}
			}
		}
		while ( ! $driver);

		// Set in the repository
		$this->repository->setDatabaseDriver($driver);

		return $driver;
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('skip-database', null, InputOption::VALUE_NONE, 'Skip database setup (setup manually)'),
			array('skip-extensions', null, InputOption::VALUE_NONE, 'Skip installing extensions (setup manually)'),
			array('skip-user', null, InputOption::VALUE_NONE, 'Skip user setup (setup manually)'),
		);
	}
}