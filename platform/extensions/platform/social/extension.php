<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst Software Licence.
 *
 * @package    Cartalyst Social
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst Software Licence - http://cartalyst.com/licence
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return array(

	'info' => array(
		'name'        => 'Social',
		'author'      => 'Cartalyst LLC',
		'description' => 'Social Integration for Platform for all your social needs.',
		'version'     => '1.0',
		'is_core'     => false,
	),

	'dependencies' => array(
		'platform.menus',
		'platform.users',
	),

	'overrides' => array(
		'platform.users',
	),

	'routes' => function() {
		Route::get('login', 'platform/social::social@login');
	}

);
