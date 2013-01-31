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
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return array(

	/*
	|--------------------------------------------------------------------------
	| Active Theme
	|--------------------------------------------------------------------------
	|
	| Here you can specify the default active theme for your application, or
	| set to null if none is defined.
	|
	*/

	'active' => 'public::platform/default',

	/*
	|--------------------------------------------------------------------------
	| Themes Path
	|--------------------------------------------------------------------------
	|
	| Here you set the default themes path for your application. Paths should
	| also be set relative to a publically accessible directory so assets can
	| be resolved.
	|
	*/

	'paths' => array(
		__DIR__.'/../../../../../public/platform/themes',
	),

);
