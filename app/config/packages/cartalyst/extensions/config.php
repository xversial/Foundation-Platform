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
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return array(

	/*
	|--------------------------------------------------------------------------
	| Auto Register
	|--------------------------------------------------------------------------
	|
	| Here you may specify if the extensions are registered when the service
	| provider is booted. This will locate all extensions and register them.
	|
	| Supported: true, false.
	|
	*/

	'auto_register' => false,

	/*
	|--------------------------------------------------------------------------
	| Auto Boot
	|--------------------------------------------------------------------------
	|
	| Here you may specify if the extensions are booted when all extensions
	| have been registered, similar to Laravel service providers. It allows you
	| to fire a callback once all extensions are available.
	|
	| Extensions must be auto-registered to be auto-booted.
	|
	| Supported: true, false.
	|
	*/

	'auto_boot' => false,

);
