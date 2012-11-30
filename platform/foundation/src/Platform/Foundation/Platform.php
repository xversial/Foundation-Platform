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
	 * @return void
	 */
	public function __construct(Application $app, ExtensionBag $extensionBag)
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
		$this->extensionBag->addAllExtensions();
		$this->extensionBag->startExtensions();
	}


}