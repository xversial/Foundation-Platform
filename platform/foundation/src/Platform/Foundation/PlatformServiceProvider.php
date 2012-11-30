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
 * @version    2.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Support\ServiceProvider;
use Platform\Extensions\ExtensionBag;

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
		$this->app['config']->package('platform/foundation', __DIR__.'/../../config');

		$this->app['platform'] = $this->app->share(function($app)
		{
			return new Platform(
				$app,
				new ExtensionBag(
					array(),
					$app['path.base'].'/extensions',
					$app['validator'],
					$app['events']
				)
			);
		});
	}

}