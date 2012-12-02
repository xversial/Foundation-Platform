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
 * @version    2.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Illuminate\Foundation\Application;

class Installer {

	/**
	 * Laravel application instance.
	 * 
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * Create a new Platform instance.
	 *
	 * @param  Illuminate\Validation\Factory  $validation
	 * @return void
	 */
	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function isInstalled()
	{
		return (bool) $this->app['config']->get('platform/foundation::platform.installed_version', false);
	}

}