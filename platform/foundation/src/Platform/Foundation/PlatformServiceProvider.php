<?php namespace Platform\Foundation;
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

use Illuminate\Support\ServiceProvider;
use Platform\Extensions\ExtensionBag;
use Platform\Operate\Install\InstallCommand;
use Platform\Operate\Install\Installer;
use Platform\Operate\Install\Repository as InstallRepository;
use Platform\Operate\Upgrade\Upgrader;

class PlatformServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->app['platform']->boot();
	}
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Let's register the config for the Platform foundation
		$this->app['config']->package('platform/foundation', __DIR__.'/../../config', 'platform/foundation');

		// Bind up Platform
		$this->app['platform'] = $this->app->share(function($app)
		{
			// Create an extension bag
			$extensionBag = new ExtensionBag(

				// No extensions by default
				array(),

				// Default dextension path
				$app['path.base'].'/extensions',

				// Validator object to validate extension
				$app['validator'],

				// Events object used to fire events for
				// extensions
				$app['events']
			);

			// Add all local extensions. This ensures the extensions
			// are recognised by Laravel so that migrations can run,
			// classes may be loaded etc, for installing. The extensions
			// are not mapped to their database presence and are not
			// started. THis happens later on.
			$extensionBag->addAllLocalExtensions();
				
			// Create a Platform object.
			$platform = new Platform(
				$app,
				$extensionBag
			);

			// Now we've made Platform with it's bare necessities, let's
			// bind in some extra keys
			$platform['operate.installer'] = new Installer($app);
			$platform['operate.upgrader'] = new Upgrader($app);

			// Installer repository
			$platform['operate.installer.repository'] = $platform->share(function($platform) use ($app)
			{
				return new InstallRepository($app, $app['validator']);
			});

			return $platform;
		});

		// Bind install command
		$this->app['command.platform.install'] = $this->app->share(function($app)
		{
			return new InstallCommand;
		});

		// When artisan starts up, let's in fact check if Platform
		// is installed. If not, we'll add the necessary commands
		// to install it.
		$this->app['events']->listen('artisan.start', function($artisan)
		{
			$app = app();
			if ($app['platform']['operate.installer']->isInstalled())
			{
				dd('Platform is installed, implement me.');
			}
			else
			{
				$artisan->resolveCommands(array(
					'command.platform.install',
				));
			}
		});
	}

}