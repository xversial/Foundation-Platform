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
 * @version    1.1.0
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
        'name'        => 'Localisation',
        'author'      => 'Cartalyst LLC',
        'description' => 'Manage your system languages, countries, currencies and timezones.',
        'version'     => '1.0',
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
     * Rules
     * -----------------------------------------
     */
    'rules' => array(
        'platform/localisation::admin.countries@index',
        'platform/localisation::admin.countries@view',
        'platform/localisation::admin.countries@create',
        'platform/localisation::admin.countries@delete',

        'platform/localisation::admin.currencies@index',
        'platform/localisation::admin.currencies@view',
        'platform/localisation::admin.currencies@create',
        'platform/localisation::admin.currencies@delete',

        'platform/localisation::admin.languages@index',
        'platform/localisation::admin.languages@view',
        'platform/localisation::admin.languages@create',
        'platform/localisation::admin.languages@delete'
    )
);
