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
 * @version    1.1.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */


/**
 * --------------------------------------------------------------------------
 * Platform > Core > Controller Class
 * --------------------------------------------------------------------------
 *
 * Let's extend Laravel Controller class, so we can make some magic happen !
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.0
 */
abstract class Controller extends Laravel\Routing\Controller
{
    /**
     * --------------------------------------------------------------------------
     * Function: call()
     * --------------------------------------------------------------------------
     *
     * Call an action method on a controller.
     *
     *  <code>
     *      # Call the "show" method on the "user" controller.
     *      #
     *      $response = Controller::call('user@show');
     *
     *      # Call the "profile" methd on the "user/admin" controller and pass parameters.
     *      #
     *      $response = Controller::call('user.admin@profile', array($username));
     * </code>
     *
     * @access   public
     * @param    string
     * @param    array
     * @return   Response
     */
    public static function call($destination, $parameters = array())
    {
        static::references($destination, $parameters);

        list($bundle, $destination) = Bundle::parse($destination);

        // We will always start the bundle, just in case the developer is pointing
        // a route to another bundle. This allows us to lazy load the bundle and
        // improve speed since the bundle is not loaded on every request.
        Bundle::start($bundle);

        list($name, $method) = explode('@', $destination);

        if (strpos($bundle, '/'))
        {
            list($vendor, $bundle_) = explode('/', $bundle);

            $controller = self::resolve($vendor.'/'.$bundle_, $name);
        } else {
            $controller = self::resolve($bundle, $name);
        }

        #$controller = static::resolve($bundle, $name);

        // For convenience we will set the current controller and action on the
        // Request's route instance so they can be easily accessed from the
        // application. This is sometimes useful for dynamic situations.
        if ( ! is_null($route = Request::route()))
        {
            $controller_route = $route;

            $controller_route->bundle = $bundle;

            $controller_route->controller = $name;

            $controller_route->controller_action = $method;

            Router::add_to_queue($controller_route);
        }

        // If the controller could not be resolved.
        //
        if (is_null($controller))
        {
            return Event::first('404');
        }

        // Controller was found, execute the requested method on the instance.
        //
        $response = $controller->execute($method, $parameters);

        if ( ! is_null($route))
        {
            Router::queue_next();
        }

        return $response;
    }

    /**
	 * Resolve a bundle and controller name to a controller instance.
	 *
	 * @param  string      $bundle
	 * @param  string      $controller
	 * @return Controller
	 */
	public static function resolve($bundle, $controller)
	{
		\Platform::extensions_manager()->load_controller_overrides($bundle, $controller);

		static::load($bundle, $controller);

		if ( ! static::load($bundle, $controller))
		{
			$bundle = \Platform::extensions_manager()->find_overridden_extension($bundle, $controller);

			if ( ! $bundle) return;
		}

		$identifier = Bundle::identifier($bundle, $controller);

		// If the controller is registered in the IoC container, we will resolve
		// it out of the container. Using constructor injection on controllers
		// via the container allows more flexible applications.
		$resolver = 'controller: '.$identifier;

		if (IoC::registered($resolver))
		{
			return IoC::resolve($resolver);
		}

		$controller = static::format($bundle, $controller);

		// If we couldn't resolve the controller out of the IoC container we'll
		// format the controller name into its proper class name and load it
		// by convention out of the bundle's controller directory.
		if (Event::listeners(static::factory))
		{
			return Event::first(static::factory, $controller);
		}
		else
		{
			return new $controller;
		}
	}

    /**
	 * Format a bundle and controller identifier into the controller's class name.
	 *
	 * @param  string  $bundle
	 * @param  string  $controller
	 * @return string
	 */
	public static function format($bundle, $controller)
	{
		$bundle = str_replace('/', '_', $bundle);

		return Bundle::class_prefix($bundle).Str::classify($controller).'_Controller';
	}
}
