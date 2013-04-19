<?php namespace Overrides;
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

/**
 * @todo Remove when https://github.com/laravel/framework/pull/1007 is merged.
 */
class SessionServiceProvider extends \Illuminate\Session\SessionServiceProvider {

	/**
	 * Register the session close event.
	 *
	 * @return void
	 */
	protected function registerCloseEvent()
	{
		$app = $this->app;

		$this->app->finish(function() use ($app)
		{
			// var_dump('closing session');
			$app['session']->save();
		});
	}

}
