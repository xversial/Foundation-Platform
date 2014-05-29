<?php
/**
 * Part of the Extensions package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Extensions
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
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
