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

use Illuminate\Container;
use Illuminate\Foundation\Application;
use Platform\Extensions\ExtensionBag;
use Platform\Operate\Install\Installer;
use Platform\Operate\Upgrade\Upgrader;

class Platform extends Container {

	/**
	 * Laravel application instance.
	 * 
	 * @var Illuminate\Foundation\Application
	 */
	protected $app;

	/**
	 * ExtensionBag that holds extensions for
	 * Platform.
	 * 
	 * @var Platform\Extensions\ExtensionBag
	 */
	protected $extensionBag;

	/**
	 * Create a new Platform instance.
	 *
	 * @param  Illuminate\Validation\Factory  $validation
	 * @param  Platform\Extensions\ExtensionBag  $extensionBag
	 * // @param  Platform\Operate\Install\Installer  $installer
	 * // @param  Platform\Operate\Upgrade\Upgrader  $upgrader
	 * @return void
	 */
	public function __construct(
		Application $app,
		ExtensionBag $extensionBag
	)
	{
		$this->app = $app;
		$this->extensionBag = $extensionBag;
	}

	/**
	 * Boots up Platform and it's Extensions
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->app['events']->fire('platform.booting', array($this));

		if ( ! $this['operate.installer']->isInstalled())
		{
			dd('not installed.');
		}

		$this->extensionBag->addDatabasePresenceToLocalExtensions();
		$this->extensionBag->startExtensions();

		$this->app['events']->fire('platform.booted', array($this));
	}

	/**
	 * Sets the Extension Bag for Platform.
	 *
	 * @param  Platform\Extensions\ExtensionBag
	 */
	public function setExtensionBag(ExtensionBag $extensionBag)
	{
		$this->extensionBag = $extensionBag;
	}

	/**
	 * Gets Platform's Extension Bag.
	 *
	 * @param  Platform\Extensions\ExtensionBag
	 */
	public function getExtensionBag()
	{
		return $this->extensionBag;
	}

}