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
	'active' => 'public::platform/fancy',

	/*
	|--------------------------------------------------------------------------
	| Themes Path
	|--------------------------------------------------------------------------
	|
	| Here you set the default themes path for your application. Paths should
	| also be set relative to a publically accessible directory so assets can
	| be resolved.
	|
	| @todo, allow for a key / value pair of paths, where the key is the directory
	| and the asset is the equivilent public URI (relative to the base URI) for
	| the theme. This will allow for much quicker resolving of URLs for resources
	| rather than checking for the public path in them.
	|
	*/
	'paths' => array(
		__DIR__.'/../../../../../public/platform/themes',
	),

	/*
	|--------------------------------------------------------------------------
	| Packages Path
	|--------------------------------------------------------------------------
	|
	| Here, you set the path (relative to your theme's root folder) for all
	| packages to reside.
	|
	*/
	'packages_path' => 'extensions',

	/*
	|--------------------------------------------------------------------------
	| Namespaces Path
	|--------------------------------------------------------------------------
	|
	| We even let you theme up Laravel 4 view namespaces. You can register a
	| namespace for a view, for example:
	|
	|	View::addNamespace('foo/bar', '/var/www/some/namespace');
	|
	| This means that, when you call:
	|
	|	View::make('foo/bar::test');
	|
	| It will look in the namespace you specified. However, you can also call
	| Theme::namespace('foo/bar'); which means that all calls to the 'foo/bar'
	| namespace will first check for that namespace within your theme first,
	| before falling back to the hard-coded namespace. Yes, you can theme any
	| view in Laravel now!
	|
	*/
	'namespaces_path' => 'namespaces',

	/*
	|--------------------------------------------------------------------------
	| Views Path
	|--------------------------------------------------------------------------
	|
	| List the path (within each theme and it's packages) where views are
	| located.
	|
	*/
	'views_path' => 'views',

	/*
	|--------------------------------------------------------------------------
	| Assets Path
	|--------------------------------------------------------------------------
	|
	| List the path (within each theme and it's packages) where assets are
	| located.
	|
	*/
	'assets_path' => 'assets',

);