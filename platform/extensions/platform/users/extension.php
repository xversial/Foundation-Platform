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
 * @package    Platform
 * @version    1.1.1
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
        'name'        => 'Users',
        'author'      => 'Cartalyst LLC',
        'description' => 'Manages your website users, groups and roles.',
        'version'     => '1.1',
        'is_core'     => true
    ),


    /*
     * -----------------------------------------
     * Extension dependencies.
     * -----------------------------------------
     */
    'dependencies' => array(
        'platform.menus',
        'platform.settings'
    ),


    /*
     * -----------------------------------------
     * Events
     * -----------------------------------------
     */
    'events' => array(
        'user.create',
        'user.update',
        'user.delete',
        'group.create',
        'group.update',
        'group.delete'
    ),


    /*
     * -----------------------------------------
     * Extension routes.
     * -----------------------------------------
     */
    'routes' => function() {
        Route::any(ADMIN.'/insufficient_permissions', 'platform/users::admin.users@insufficient_permissions');

        Route::any('register', 'platform/users::auth@register');
        Route::any('activate/(:any)/(:any)', 'platform/users::auth@activate');
        Route::any('login', 'platform/users::auth@login');
        Route::any('logout', 'platform/users::auth@logout');
        Route::any('reset_password', 'platform/users::auth@reset_password');
        Route::any('reset_password_confirm/(:any)/(:any)', 'platform/users::auth@reset_password_confirm');
    },


    /*
     * -----------------------------------------
     * Rules
     * -----------------------------------------
     */
    'rules' => array(
        'platform/users::admin.users@index',
        'platform/users::admin.users@create',
        'platform/users::admin.users@edit',
        'platform/users::admin.users@delete',
        'platform/users::admin.groups@index',
        'platform/users::admin.groups@create',
        'platform/users::admin.groups@edit',
        'platform/users::admin.groups@delete'
    )
);
