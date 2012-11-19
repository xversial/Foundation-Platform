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
 * Platform > Core > Route Class
 * --------------------------------------------------------------------------
 *
 * Let's extend Laravel Route class.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.0
 */
class Route extends Laravel\Routing\Route
{
    /**
     * --------------------------------------------------------------------------
     * Function: call()
     * --------------------------------------------------------------------------
     *
     * Call a given route and return the route's response.
     *
     * @access   public
     * @return   Response
     */
    public function call()
    {
        // The route is responsible for running the global filters, and any
        // filters defined on the route itself, since all incoming requests
        // come through a route (either defined or ad-hoc).
        $response = Filter::run($this->filters('before'), array(), true);

        if (is_null($response))
        {
            $response = $this->response();
        }

        // We always return a Response instance from the route calls, so
        // we'll use the prepare method on the Response class to make
        // sure we have a valid Response instance.
        $response = Response::prepare($response);

        Filter::run($this->filters('after'), array($response));

        Router::queue_next();

        // Return the response.
        //
        return $response;
    }

    /**
     * Override just fixed namespace issue with controller
	 * Execute the route action and return the response.
	 *
	 * Unlike the "call" method, none of the attached filters will be run.
	 *
	 * @return mixed
	 */
	public function response()
	{
		// If the action is a string, it is pointing the route to a controller
		// action, and we can just call the action and return its response.
		// We'll just pass the action off to the Controller class.
		$delegate = $this->delegate();

		if ( ! is_null($delegate))
		{
			return \Controller::call($delegate, $this->parameters);
		}

		// If the route does not have a delegate, then it must be a Closure
		// instance or have a Closure in its action array, so we will try
		// to locate the Closure and call it directly.
		$handler = $this->handler();

		if ( ! is_null($handler))
		{
			return call_user_func_array($handler, $this->parameters);
		}
	}

}