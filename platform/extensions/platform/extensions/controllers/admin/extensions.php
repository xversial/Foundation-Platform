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
 * Extensions > Admin Class
 * --------------------------------------------------------------------------
 *
 * Extensions management.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.1
 */
class Platform_Extensions_Admin_Extensions_Controller extends Admin_Controller
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
        $this->active_menu('admin-extensions');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_index()
     * --------------------------------------------------------------------------
     *
     * Get the list of installed an uninstalled extensions.
     *
     * @access   public
     * @return   mixed
     */
    public function get_index()
    {
        try
        {
            // Get all the installed and uninstalled extensions.
            //
            $extensions = API::get('extensions');
        }
        catch (APIClientException $e)
        {
            // Set the error message.
            //
            Platform::messages()->error($e->getMessage());

            // Set all the other error messages.
            //
            foreach ($e->errors() as $error)
            {
                Platform::messages()->error($error);
            }

            // Redirect to the admin dashboard.
            //
            return Redirect::to_admin();
        }

        // Show the page.
        //
        return Theme::make('platform/extensions::index')
            ->with('manager', Platform::extensions_manager())
            ->with('extensions', $extensions);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: post_index()
     * --------------------------------------------------------------------------
     *
     * Manage the extension actions.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function post_index()
    {
        // Are we installing an extension ?
        //
        if ($slug = Input::get('install'))
        {
            $this->get_install($vendor, $slug);
        }

        // Are we uninstalling an extension ?
        //
        elseif ($slug = Input::get('uninstall'))
        {
            $this->get_uninstall($vendor, $slug);
        }

        // Are we enabling an extension ?
        //
        elseif ($slug = Input::get('enable'))
        {
            $this->get_enable($vendor, $slug);
        }

        // Are we disabling an extension ?
        //
        elseif ($slug = Input::get('disable'))
        {
            $this->get_disable($vendor, $slug);
        }

        // Are we updating an extension ?
        //
        elseif ($slug = Input::get('update'))
        {
            $this->get_update($vendor, $slug);
        }

        // Redirect to the extensions page.
        //
        return Redirect::to_admin('extensions');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_install()
     * --------------------------------------------------------------------------
     *
     * Installs an extension.
     *
     * @access   public
     * @param    string
     * @return   Redirect
     */
    public function get_install($vendor, $slug)
    {
        // Extension slug.
        //
        $slug = $vendor . '/' . $slug;

        try
        {
            // Make the request.
            //
            API::put('extensions/' . $slug, array('install' => true));

            // Set the success message.
            //
            Platform::messages()->success(Lang::line('extensions.install.success', array('extension' => $slug)));
        }
        catch (APIClientException $e)
        {
            throw $e;
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

        // Redirect to the extensions page.
        //
        return Redirect::to_admin('extensions');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_uninstall()
     * --------------------------------------------------------------------------
     *
     * Uninstalls an extension.
     *
     * @access   public
     * @param    string
     * @return   Redirect
     */
    public function get_uninstall($vendor, $slug)
    {
        // Extension slug.
        //
        $slug = $vendor . '/' . $slug;

        try
        {
            // Make the request.
            //
            API::put('extensions/' . $slug, array('uninstall' => true));

            // Set the success message.
            //
            Platform::messages()->success(Lang::line('extensions.uninstall.success', array('extension' => $slug)));
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

        // Redirect to the extensions page.
        //
        return Redirect::to_admin('extensions');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_enable()
     * --------------------------------------------------------------------------
     *
     * Enables an extension.
     *
     * @access   public
     * @param    string
     * @return   Redirect
     */
    public function get_enable($vendor, $slug)
    {
        // Extension slug.
        //
        $slug = $vendor . '/' . $slug;

        try
        {
            // Make tue request.
            //
            API::put('extensions/' .  $slug, array('enable' => true));

            // Set the success message.
            //
            Platform::messages()->success(Lang::line('extensions.enable.success', array('extension' => $slug)));
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

        // Redirect to the extensions page.
        //
        return Redirect::to_admin('extensions');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_disable()
     * --------------------------------------------------------------------------
     *
     * Disables an extension.
     *
     * @access   public
     * @param    string
     * @return   Redirect
     */
    public function get_disable($vendor, $slug)
    {
        // Extension slug.
        //
        $slug = $vendor . '/' . $slug;

        try
        {
            // Make tue request.
            //
            API::put('extensions/' . $slug, array('disable' => true));

            // Set the success message.
            //
            Platform::messages()->success(Lang::line('extensions.disable.success', array('extension' => $slug)));
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

        // Redirect to the extensions page.
        //
        return Redirect::to_admin('extensions');
    }



    /**
     * --------------------------------------------------------------------------
     * Function: get_update()
     * --------------------------------------------------------------------------
     *
     * Updates an extension.
     *
     * @access   public
     * @param    string
     * @return   Redirect
     */
    public function get_update($vendor, $slug)
    {
        // Extension slug.
        //
        $slug = $vendor . '/' . $slug;

        try
        {
            // Make the request.
            //
            API::put('extensions/' . $slug, array(
                'update' => true
            ));

            // Set the success message.
            //
            Platform::messages()->success(Lang::line('extensions.update.success', array('extension' => $slug)));
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

        // Redirect to the extensions page.
        //
        return Redirect::to_admin('extensions');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_view()
     * --------------------------------------------------------------------------
     *
     * Shows information about an extensions.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function get_view($vendor, $slug = null)
    {
        // Check if the extension exists.
        //
        try
        {
            $extension  = API::get('extensions/' . $vendor . '/' . $slug);
            $extensions = API::get('extensions');
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

            // Redirect to the extensions page.
            //
            return Redirect::to_admin('extensions');
        }

        // Show the page.
        //
        return Theme::make('platform/extensions::view')
            ->with('manager', Platform::extensions_manager())
            ->with('extension', $extension)
            ->with('extensions', $extensions);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: post_view()
     * --------------------------------------------------------------------------
     *
     * Manage the extension actions.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function post_view($vendor, $slug)
    {
        // If we are installing a required extension.
        //
        if ($required = Input::get('install_required'))
        {
            list($req_vendor, $req_slug) = explode('/', $required);
            $this->get_install($req_vendor, $req_slug);
        }

        // If we are enabling a required extension.
        //
        elseif ($required = Input::get('enable_required'))
        {
            list($req_vendor, $req_slug) = explode('/', $required);
            $this->get_enable($req_vendor, $req_slug);
        }

        // If we are installing the extension.
        //
        elseif (Input::get('install'))
        {
            $this->get_install($vendor, $slug);
        }

        // If we are uninstalling the extension.
        //
        elseif (Input::get('uninstall'))
        {
            $this->get_uninstall($vendor, $slug);
        }

        // If we are enabling the extension.
        //
        elseif (Input::get('enable'))
        {
            $this->get_enable($vendor, $slug);
        }

        // If we are disabling the extension.
        //
        elseif (Input::get('disable'))
        {
            $this->get_disable($vendor, $slug);
        }

        // If we are updating the extension.
        //
        elseif (Input::get('update'))
        {
            $this->get_update($vendor, $slug);
        }

        // Redirect to the extension page.
        //
        return Redirect::to_admin('extensions/view/' . $vendor . '/' . $slug);
    }
}
