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
 * @version    1.1.4
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */


/*
 * --------------------------------------------------------------------------
 * Return the extension data.
 * --------------------------------------------------------------------------
 */
return array(
	/*
     * -----------------------------------------
	 * Extension information.
     * -----------------------------------------
	 */
	'info' => array(
		'name'        => 'Pages',
		'author'      => 'Cartalyst LLC',
		'description' => 'An extension to manage pages and content.',
		'version'     => '1.1.2',
		'is_core'     => true,
	),

	 /*
     * -----------------------------------------
     * Extension dependencies.
     * -----------------------------------------
     */
    'dependencies' => array(
        'platform.menus',
        'platform.settings',
        'platform.media',
    ),

    /*
     * -----------------------------------------
     * Extension routes.
     * -----------------------------------------
     */
	'routes' => function()
	{
		// route index page
		Route::any('/', 'platform/pages::pages@page');

		// route invalid permissions
		Route::any('/invalid_permissions', 'platform/pages::pages@invalid_permissions');

		// route non-index pages
		Route::any('(:any)', function($page = 'index')
		{
			// Check if the page is a bundle
			if ( ! Bundle::exists($page))
			{
				return Controller::call('platform/pages::pages@page', array($page));
			}
		});
	},

	/*
     * -----------------------------------------
     * Rules
     * -----------------------------------------
     */
	'rules' => array(
		'platform/pages::admin.pages@index',
		'platform/pages::admin.pages@create',
		'platform/pages::admin.pages@edit',
		'platform/pages::admin.pages@delete',
		'platform/pages::admin.content@index',
		'platform/pages::admin.content@create',
		'platform/pages::admin.content@edit',
		'platform/pages::admin.content@delete'
	),

);
