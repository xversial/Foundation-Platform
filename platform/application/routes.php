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
 * @version    1.0.3
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */


/*
 * --------------------------------------------------------------------------
 * Admin routing.
 * --------------------------------------------------------------------------
 *
 * We can use this for the administration extensions.
 *
 */
Route::any(ADMIN . '/(:any?)/(:any?)/(:any?)(/.*)?', function($handle = 'dashboard', $controller = null, $action = null, $params = null)
{
    // Check if the extension exists.
    //
    if ( ! Bundle::exists($bundle = Bundle::handles($handle)))
    {
        return Response::error('404');
    }

    // Check if the controller exists.
    //
    if ($controller and ($controller_instance = Platform::extensions_manager()->resolve_controller($bundle, 'admin.' . $controller)))
    {
        $method          = (($action) ?: 'index');
        $params          = explode('/', substr($params, 1));
        $name            = 'admin.' . $controller;
    }
    elseif ($controller_instance = Platform::extensions_manager()->resolve_controller($bundle, 'admin.' . $handle))
    {
        $method          = (($controller) ?: 'index');
        $params          = explode('/', $action.$params);
        $name            = 'admin.' . $handle;
    }
    else
    {
        return Response::error('404');
    }

    // For convenience we will set the current controller and action on the
    // Request's route instance so they can be easily accessed from the
    // application. This is sometimes useful for dynamic situations.
    if ( ! is_null($route = Request::route()))
    {
    	$route->bundle = $bundle;

        $route->controller = $name;

        $route->controller_action = $method;
    }

    return $controller_instance->execute($method, $params);
});


/*
 * --------------------------------------------------------------------------
 * API routing.
 * --------------------------------------------------------------------------
 *
 * Route /api/extension/:id
 *
 *  <code>
 *      /api/users/1 => users::api.users@index(1)
 *  </code>
 */
Route::any(API . '/(:any)/(:num)', function($handle = DEFAULT_BUNDLE, $id = null, $params = null)
{
    if ( ! Bundle::exists($bundle = Bundle::handles($handle)))
    {
        return Controller::call('api@no_route');
    }

    // Check if the controller exists.
    //
    if ( ! $controller_instance = Platform::extensions_manager()->resolve_controller($bundle, 'api.' . $handle))
    {
        return Controller::call('api@no_route');
    }

    // For convenience we will set the current controller and action on the
    // Request's route instance so they can be easily accessed from the
    // application. This is sometimes useful for dynamic situations.
    if ( ! is_null($route = Request::route()))
    {
        $route->controller = $controller_instance;

        $route->controller_action = 'index';
    }

    return $controller_instance->execute('index', array($id));
});


/*
 * --------------------------------------------------------------------------
 * API routing.
 * --------------------------------------------------------------------------
 *
 * Route /api/extension/controller/:id
 *
 *  <code>
 *      /api/users/groups/1 => users::api.users.groups@index(1)
 *  </code>
 */
Route::any(API . '/(:any)/(:any)/(:num)', function($handle = DEFAULT_BUNDLE, $controller = null, $id = null, $params = null)
{
	if ( ! Bundle::exists($bundle = Bundle::handles($handle)))
    {
        return Controller::call('api@no_route');
    }

    // Check if the controller exists.
    //
    if ( ! $controller_instance = Platform::extensions_manager()->resolve_controller($bundle, 'api.' . $controller))
    {
        return Controller::call('api@no_route');
    }

    // For convenience we will set the current controller and action on the
    // Request's route instance so they can be easily accessed from the
    // application. This is sometimes useful for dynamic situations.
    if ( ! is_null($route = Request::route()))
    {
        $route->controller = $controller_instance;

        $route->controller_action = 'index';
    }

    return $controller_instance->execute('index', array($id));
});


/*
 * --------------------------------------------------------------------------
 * API routing.
 * --------------------------------------------------------------------------
 *
 * Re-route api controllers.
 *
 */
Route::any(array(API . '/(:any?)/(:any?)/(:any?)(/.*)?', API . '/(:any?)/(:any?)(/.*)?', API . '/(:any?)(/.*)?'), function($handle = 'dashboard', $controller = null, $action = null, $params = null)
{
    // Check if the extension exists.
    //
    if ( ! Bundle::exists($bundle = Bundle::handles($handle)))
    {
        return Controller::call('api@no_route');
    }

    // Check if the controller exists.
    //
    if ($controller_instance = Platform::extensions_manager()->resolve_controller($bundle, 'api.' . $controller))
    {
        $method          = (($action) ?: 'index');
        $params          = explode('/', substr($params, 1));
    }
    elseif ($controller_instance = Platform::extensions_manager()->resolve_controller($bundle, 'api.' . $handle))
    {
        $method          = (($controller) ?: 'index');
        $params          = explode('/', $action.$params);
    }
    else
    {
        return Controller::call('api@no_route');
    }

    // For convenience we will set the current controller and action on the
    // Request's route instance so they can be easily accessed from the
    // application. This is sometimes useful for dynamic situations.
    if ( ! is_null($route = Request::route()))
    {
        $route->controller = $controller_instance;

        $route->controller_action = $method;
    }

    return $controller_instance->execute($method, $params);
});


/*
 * --------------------------------------------------------------------------
 * Now detect controllers.
 * --------------------------------------------------------------------------
 */
Route::controller(Controller::detect());


/*
 *--------------------------------------------------------------------------
 * Application 404 & 500 Error Handlers
 *--------------------------------------------------------------------------
 *
 * To centralize and simplify 404 handling, Laravel uses an awesome event
 * system to retrieve the response. Feel free to modify this function to
 * your tastes and the needs of your application.
 *
 * Similarly, we use an event to handle the display of 500 level errors
 * within the application. These errors are fired when there is an
 * uncaught exception thrown in the application.
 *
 */
Event::listen('404', function(){ return Response::error('404'); });
Event::listen('500', function(){ return Response::error('500'); });


/*
 * --------------------------------------------------------------------------
 *  Route Filters
 * --------------------------------------------------------------------------
 *
 *  Filters provide a convenient method for attaching functionality to your
 *  routes. The built-in before and after filters are called before and
 *  after every request to your application, and you may even create
 *  other filters that can be attached to individual routes.
 *
 *  Let's walk through an example...
 *
 *  First, define a filter:
 *
 *         Route::filter('filter', function()
 *         {
 *             return 'Filtered!';
 *         });
 *
 *  Next, attach the filter to a route:
 *
 *         Router::register('GET /', array('before' => 'filter', function()
 *         {
 *             return 'Hello World!';
 *         }));
 *
 */
Route::filter('before', function(){});
Route::filter('after', function($response){});


/*
 *--------------------------------------------------------------------------
 * CSRF ( Cross-site request forgery ) Protection.
 *--------------------------------------------------------------------------
 */
Route::filter('csrf', function()
{
    // Bad request ?
    //
    if (Request::forged())
    {
        return Response::error('500');
    }

    // Remove the token from the input now.
    //
    Request::foundation()->request->remove(Session::csrf_token);
});


/*
 *--------------------------------------------------------------------------
 * Authentication filter.
 *--------------------------------------------------------------------------
 */
Route::filter('auth', function()
{
    // Check if the user is logged in.
    //
    if ( ! Sentry::check())
    {
        // Store the current uri in the session.
        //
        Session::put('login_redirect', URI::current());

        // Redirect to the login page.
        //
        return Redirect::to('login');
    }
});


/*
 *--------------------------------------------------------------------------
 * Admin authentication filter.
 *--------------------------------------------------------------------------
 *
 * Usefull to check if a user is logged in and has access to the admin page.
 *
 */
Route::filter('admin_auth', function()
{
    // Check if the user is logged in and has acces to admin.
    //
    if ( ! Sentry::check() or ! Sentry::user()->has_access('is_admin'))
    {
        // Store the current uri in the session.
        //
        Session::flash('login_redirect', URI::current());

        // Redirect to the login page.
        //
        return Redirect::to('login');
    }
});
