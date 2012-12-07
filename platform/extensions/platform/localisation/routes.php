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
 * Default routing for localisation.
 * --------------------------------------------------------------------------
 */
Route::any(ADMIN . '/localisation', 'platform/localisation::admin.languages@index');


/**
 * Route /admin/localisation/:local/:method/:code
 *
 *  <code>
 *      /admin/localisation/country/create    => localisation::admin.countries@edit
 *      /admin/localisation/country/edit/gb   => localisation::admin.countries@edit(gb)
 *      /admin/localisation/country/delete/gb => localisation::admin.countries@delete(gb)
 *  </code>
 */
Route::get(ADMIN . '/localisation/(:any)/(:any)/(:any?)', function($local, $method, $code = null)
{
    return Controller::call('platform/localisation::admin.' . Str::plural($local) . '@' . $method, array($code));
});


/**
 * Route /api/localisation/:local/datatable
 *
 *  <code>
 *      /api/localisation/countries/datatable => localisation::api.countries@datatable
 *  </code>
 */
Route::get(API . '/localisation/(:any)/datatable', 'platform/localisation::api.(:1)@datatable');


/**
 * Route /api/localisation/:local/primary/:code
 *
 *  <code>
 *      /api/localisation/country/primary/gb => localisation::api.countries@primary(gb)
 *  </code>
 */
Route::put(API . '/localisation/(:any)/primary/(:any)', function($local, $code)
{
    return Controller::call('platform/localisation::api.' . Str::plural($local) . '@primary', array($code));
});


/**
 * Route /api/localisation/:local/:code
 *
 *  <code>
 *      /api/localisation/country/gb => localisation::api.countries@index(gb)
 *  </code>
 */
Route::any(API . '/localisation/(:any)/(:any)', function($local, $code)
{
    return Controller::call('platform/localisation::api.' . Str::plural($local) . '@index', array($code));
});


/**
 * Route /api/localisation/:local
 *
 *  <code>
 *      /api/localisation/country => localisation::api.countries@index
 *  </code>
 */
Route::post(API . '/localisation/(:any)', function($local)
{
    return Controller::call('platform/localisation::api.' . Str::plural($local) . '@index');
});