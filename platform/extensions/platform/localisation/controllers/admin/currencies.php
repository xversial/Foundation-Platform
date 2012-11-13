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


/**
 * --------------------------------------------------------------------------
 * Localisation > Currencies > Admin Class
 * --------------------------------------------------------------------------
 *
 * Currencies management.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.0
 */
class Platform_Localisation_Admin_Currencies_Controller extends Admin_Controller
{
    /**
     * --------------------------------------------------------------------------
     * Function: __construct()
     * --------------------------------------------------------------------------
     *
     * Initializer.
     *
     * @access   public
     * @return   void
     */
    public function __construct()
    {
        // Call parent.
        //
        parent::__construct();
    }


    /**
     * --------------------------------------------------------------------------
     * Function: before()
     * --------------------------------------------------------------------------
     *
     * This function is called before the action is executed.
     *
     * @access   public
     * @return   void
     */
    public function before()
    {
        // Call parent.
        //
        parent::before();

        // Set the active menu.
        //
        $this->active_menu('admin-currencies');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_index()
     * --------------------------------------------------------------------------
     *
     * Shows all the currencies.
     *
     * @access   public
     * @return   mixed
     */
    public function get_index()
    {
        // If this is an ajax request, only return the body of the datatable.
        //
        if (Request::ajax())
        {
            // Grab the datatable.
            //
            $datatable = API::get('localisation/currencies/datatable', Input::get());

            // Prepare the array.
            //
            $data = array(
                'rows'             => $datatable['rows'],
                'default_currency' => $datatable['default_currency']
            );

            return json_encode(array(
                'content'        => Theme::make('platform/localisation::currencies.partials.table', $data)->render(),
                'count'          => $datatable['count'],
                'count_filtered' => $datatable['count_filtered'],
                'paging'         => $datatable['paging']
            ));
        }

        // Show the page.
        //
        return Theme::make('platform/localisation::currencies.index');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_create()
     * --------------------------------------------------------------------------
     *
     * Language creation page.
     *
     * @access   public
     * @return   mixed
     */
    public function get_create()
    {
        // Show the page.
        //
        return Theme::make('platform/localisation::currencies.create');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: post_create()
     * --------------------------------------------------------------------------
     *
     * Language creation form processing page.
     *
     * @access   public
     * @return   mixed
     */
    public function post_create()
    {
        return $this->post_edit();
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_edit()
     * --------------------------------------------------------------------------
     *
     * Language editing page.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function get_edit($currency_code)
    {
        try
        {
            // Make the request.
            //
            $currency = API::get('localisation/currency/' . $currency_code);
        }
        catch (APIClientException $e)
        {
            // Set the error message.
            //
            Platform::messages()->error($e->getMessage());

            // Set the other error messages.
            //
            foreach ($e->errors() as $error)
            {
                Platform::messages()->error($error);
            }

            // Redirect to the currencies page.
            //
            return Redirect::to_admin('localisation/currencies');
        }

        // Show the page.
        //
        return Theme::make('platform/localisation::currencies.edit')->with('currency', $currency);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: post_edit()
     * --------------------------------------------------------------------------
     *
     * Language editing form processing page.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function post_edit($currency_code = false)
    {
        try
        {
            // Are we creating a currency ?
            //
            if ($currency_code === false)
            {
                // Make the request.
                //
                $request = API::post('localisation/currency', Input::get());
            }

            // We must be editing the currency.
            //
            else
            {
                // Make the request.
                //
                $request = API::put('localisation/currency/' . $currency_code, Input::get());
            }

            // Get the currency slug.
            //
            $currency_slug = $request['slug'];

            // Set the success message.
            //
            Platform::messages()->success($request['message']);

            // Check what button we pressed.
            //
            if (Input::get('save'))
            {
                // Redirect to the currency page.
                //
                return Redirect::to_admin('localisation/currencies/edit/' . $currency_slug);
            }
            else
            {
                // Redirect to the currencies page.
                //
                return Redirect::to_admin('localisation/currencies');
            }
        }
        catch (APIClientException $e)
        {
            // Set the error message.
            //
            Platform::messages()->error($e->getMessage());

            // Set the other error messages.
            //
            foreach ($e->errors() as $error)
            {
                Platform::messages()->error($error);
            }

            // Redirect to the previous page.
            //
            return Redirect::back()->with_input()->with_errors($e->errors());
        }
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_delete()
     * --------------------------------------------------------------------------
     *
     * Language deletion page.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function get_delete($currency_code)
    {
       try
        {
            // Make the request.
            //
            $request = API::delete('localisation/currency/' . $currency_code);

            // Set the success message.
            //
            Platform::messages()->success($request['message']);
        }
        catch (APIClientException $e)
        {
            // Set the error message.
            //
            Platform::messages()->error($e->getMessage());

            // Set the other error messages.
            //
            foreach ($e->errors() as $error)
            {
                Platform::messages()->error($error);
            }
        }

        // Redirect to the currencies page.
        //
        return Redirect::to_admin('localisation/currencies');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_primary()
     * --------------------------------------------------------------------------
     *
     * Makes a currency the primary currency.
     *
     * @access   public
     * @param    mixed
     * @return   mixed
     */
    public function get_primary($currency_code)
    {
        try
        {
            // Make the request.
            //
            $request = API::put('localisation/currency/primary/' . $currency_code);

            // Set the success message.
            //
            Platform::messages()->success($request['message']);
        }
        catch (APIClientException $e)
        {
            // Set the error message.
            //
            Platform::messages()->error($e->getMessage());

            // Set the other error messages.
            //
            foreach ($e->errors() as $error)
            {
                Platform::messages()->error($error);
            }
        }

        // Redirect to the currencies page.
        //
        return Redirect::to_admin('localisation/currencies');
    }
}
