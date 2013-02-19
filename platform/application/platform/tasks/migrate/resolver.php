<?php
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
 * @version    1.1.4
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Tasks\Migrate;

use Bundle;
use ExtensionsManager;
use Laravel\Cli\Tasks\Migrate\Resolver as lResolver;

class Resolver extends lResolver
{

	/**
	 * Resolve an array of migration instances.
	 *
	 * @param  array  $migrations
	 * @return array
	 */
	protected function resolve($migrations)
	{
		$instances = array();

		foreach ($migrations as $migration)
		{
			$migration = (array) $migration;

			// The migration array contains the bundle name, so we will get the
			// path to the bundle's migrations and resolve an instance of the
			// migration using the name.
			$bundle = $migration['bundle'];

			$path = Bundle::path($bundle).'migrations/';

			// Migrations are not resolved through the auto-loader, so we will
			// manually instantiate the migration class instances for each of
			// the migration names we're given.
			$name = $migration['name'];

			require_once $path.$name.EXT;

			// Since the migration name will begin with the numeric ID, we'll
			// slice off the ID so we are left with the migration class name.
			// The IDs are for sorting when resolving outstanding migrations.
			//
			// Migrations that exist within bundles other than the default
			// will be prefixed with the bundle name to avoid any possible
			// naming collisions with other bundle's migrations.
			$prefix = Bundle::class_prefix($bundle);

			// Replace Platform vendor namespaces
			$class = str_replace(ExtensionsManager::VENDOR_SEPARATOR, '_', $prefix.\Laravel\Str::classify(substr($name, 18)));

			$migration = new $class;

			// When adding to the array of instances, we will actually
			// add the migration instance, the bundle, and the name.
			// This allows the migrator to log the bundle and name
			// when the migration is executed.
			$instances[] = compact('bundle', 'name', 'migration');
		}

		// At this point the migrations are only sorted within their
		// bundles so we need to resort them by name to ensure they
		// are in a consistent order.
		usort($instances, function($a, $b)
		{
			return strcmp($a['name'], $b['name']);
		});

		return $instances;
	}

}