<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Platform
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return array(

	/*
	|--------------------------------------------------------------------------
	| Site
	|--------------------------------------------------------------------------
	|
	| Basic configuration for your Platform application.
	|
	*/

	'site' => array(

		/*
		|--------------------------------------------------------------------------
		| Site Title
		|--------------------------------------------------------------------------
		|
		| Here you may specify the title of the site you are building, to be used
		| throughout the templates (as an example).
		|
		*/

		'title' => 'Platform',

		/*
		|--------------------------------------------------------------------------
		| Site Email
		|--------------------------------------------------------------------------
		|
		| Here you may specify your website general email address, this can be
		| used on other extensions to send emails.
		|
		*/

		'email' => null,

		/*
		|--------------------------------------------------------------------------
		| Site Tagline
		|--------------------------------------------------------------------------
		|
		| If your site has a tagline feel free to specify it here.
		|
		*/

		'tagline' => 'An application framework built on Laravel',

		/*
		|--------------------------------------------------------------------------
		| Site Copyright
		|--------------------------------------------------------------------------
		|
		| Specify the copyright clause for your website
		|
		*/

		'copyright' => 'Copyright (c) 2011-2014, Cartalyst LLC',

	),

	/*
	|--------------------------------------------------------------------------
	| Frontend
	|--------------------------------------------------------------------------
	|
	| Configuration the frontend of your Platform application.
	|
	*/

	'frontend' => array(

		/*
		|--------------------------------------------------------------------------
		| Menu
		|--------------------------------------------------------------------------
		|
		| Here you can list the order for which the menu children will appear
		| in the admin of your application. Feel free to add any menus for
		| any extensions your application ships with!
		|
		| If a menu children doesn't exist, it'll be skipped, the
		| order however, will be preserved.
		|
		*/

		'menu' => array(

			'main-home',
			'main-dashboard',
			'main-login',
			'main-logout',

		),

	),

	/*
	|--------------------------------------------------------------------------
	| Admin
	|--------------------------------------------------------------------------
	|
	| Configuration the administration of your Platform application.
	|
	*/

	'admin' => array(

		/*
		|--------------------------------------------------------------------------
		| Menu
		|--------------------------------------------------------------------------
		|
		| Here you can list the order for which the menu children will appear
		| in the admin of your application. Feel free to add any menus for
		| any extensions your application ships with!
		|
		| If a menu children doesn't exist, it'll be skipped, the
		| order however, will be preserved.
		|
		*/

		'menu' => array(

			'admin-pages',
			'admin-content',
			'admin-attributes',
			'admin-menus',
			'admin-operations',
			'admin-users',

		),

	),

);
