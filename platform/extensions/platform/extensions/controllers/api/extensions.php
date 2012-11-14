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


/**
 * --------------------------------------------------------------------------
 * Extensions > API Class
 * --------------------------------------------------------------------------
 *
 * API class to manage extensions.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.1
 */
class Platform_Extensions_API_Extensions_Controller extends API_Controller
{
    /**
     * --------------------------------------------------------------------------
     * Function: get_index()
     * --------------------------------------------------------------------------
     *
     * Returns an array of all the extensions, installed and uninstalled.
     *
     * You can provide an optional key (filter) with a value.
     *
     * Providing a slug as the second parameter will return that extension itself.
     *
     * This filter can either be:
     *  - installed
     *  - uninstalled
     *  - disabled
     *  - enabled
     *
     *  <code>
     *      $all         = API::get('extensions');
     *      $enabled     = API::get('extensions', array('filter' => 'enabled'));
     *      $disabled    = API::get('extensions', array('filter' => 'disabled'));
     *      $installed   = API::get('extensions', array('filter' => 'installed'));
     *      $uninstalled = API::get('extensions', array('filter' => 'uninstalled'));
     *      $users       = API::get('extensions/platform/users');
     *  </code>
     *
     * @access   public
     * @param    string
     * @return   Response
     */
    public function get_index($vendor = false, $slug = false)
    {
        // Initiate our Extension Manager.
        //
        $manager = Platform::extensions_manager();

        // No slug ? Return all the extensions.
        //
        if ($vendor == false && $slug == false)
        {
            // Initiate an empty array.
            //
            $extensions = array();

            // If we have a filter, populate our extensions array.
            //
            if ($filter = Input::get('filter'))
            {
                // Check if the filter is valid.
                //
                if (in_array($filter, array('uninstalled', 'installed', 'disabled', 'enabled')))
                {
                    // Get the extensions.
                    //
                    foreach ($manager->$filter() as $extension)
                    {
                        // Remove callbacks as they're no use in JSON.
                        //
                        array_forget($extension, 'listeners');
                        array_forget($extension, 'routes');

                        // Populate the array.
                        //
                        $extensions[ $extension['info']['slug'] ][ $extension['info']['vendor'] ] = $extension;
                    }

                    // Return the extensions.
                    //
                    return new Response($extensions);
                }

                // Invalid filter, return the message.
                //
                return new Response(array(
                    'message' => Lang::line('extensions.invalid_filter')->get()
                ), API::STATUS_BAD_REQUEST);
            }

            // No filter, return all the extensions.
            //
            else
            {
                // Spin through all the extensions.
                //
                foreach ($manager->extensions() as $_extensions)
                {
                    foreach ( $_extensions as $extension)
                    {
                        // Remove callbacks as they're no use in JSON.
                        //
                        array_forget($extension, 'listeners');
                        array_forget($extension, 'routes');

                        // Populate the array.
                        //
                        $extensions[ $extension['info']['extension'] ][ $extension['info']['vendor'] ] = $extension;
                    }
                }
            }

            // Sort the extensions.
            //
            ksort($extensions);
            array_walk($extensions, function(&$vendor)
            {
                ksort($vendor);
            });

            // Return the extensions.
            //
            return new Response($extensions);
        }

        // Extension slug.
        //
        $slug = $vendor . '.' . $slug;

        // Check if this extension exists.
        //
        if ( ! $manager->exists($slug))
        {
            // Extension doesn't exist.
            //
            return new Response(array(
                'message' => Lang::line('extensions.not_found', array('extension' => $slug))->get()
            ), API::STATUS_BAD_REQUEST);
        }

        try
        {
            // Get this extension information.
            //
            $extension = $manager->get($slug);

            // Remove callbacks as they're no use in JSON.
            //
            array_forget($extension, 'listeners');
            array_forget($extension, 'routes');

            // Return the extension.
            //
            return new Response($extension);
        }
        catch (Exception $e)
        {
            // Extension doesn't exist.
            //
            return new Response(array(
                'message' => $e->getMessage()
            ), API::STATUS_BAD_REQUEST);
        }
    }


    /**
     * --------------------------------------------------------------------------
     * Function: put_index()
     * --------------------------------------------------------------------------
     *
     * Updates an extension based on the parameters passed.
     *
     *  <code>
     *      # This installs an extension.
     *      #
     *      API::put('extensions/platform/users', array('install'     => true));
     *      API::put('extensions/platform/users', array('installed'   => true));
     *      API::put('extensions/platform/users', array('uninstalled' => false));
     *
     *      # This uninstalls an extension.
     *      #
     *      API::put('extensions/platform/users', array('uninstall'   => true));
     *      API::put('extensions/platform/users', array('installed'   => false));
     *      API::put('extensions/platform/users', array('uninstalled' => true));
     *
     *      # This enables an extension.
     *      #
     *      API::put('extensions/platform/users', array('enable'   => true));
     *      API::put('extensions/platform/users', array( enabled'  => true));
     *      API::put('extensions/platform/users', array('disabled' => false));
     *      API::put('extensions/platform/users', array('installed' => true, 'enable'   => true));
     *      API::put('extensions/platform/users', array('installed' => true, 'enabled'  => true));
     *      API::put('extensions/platform/users', array('installed' => true, 'disabled' => false));
     *
     *      # This disables an extension.
     *      #
     *      API::put('extensions/platform/users', array('disable'  => true));
     *      API::put('extensions/platform/users', array('enabled'  => false));
     *      API::put('extensions/platform/users', array('disabled' => true));
     *      API::put('extensions/platform/users', array('installed' => true, 'disable'  => true));
     *      API::put('extensions/platform/users', array('installed' => true, 'enabled'  => false));
     *      API::put('extensions/platform/users', array('installed' => true, 'disabled' => true));
     *  </code>
     *
     * @access   public
     * @param    string
     * @return   Response
     */
    public function put_index($vendor = null, $extension = null)
    {
        // Initiate our Extension Manager.
        //
        $manager = Platform::extensions_manager();

        // Build a slug up for the extension
        //
        $slug = $vendor.'.'.$extension;

        // Check if the extension exists.
        //
        if( ! $extension = $manager->get($slug))
        {
            // Extension doesn't exist.
            //
            return new Response(array(
                'message' => Lang::line('extensions.not_found', array('extension' => $slug))->get()
            ), API::STATUS_BAD_REQUEST);
        }

        // Initialize some flags.
        //
        $installed = null;
        $enabled   = null;

        // If we have an installed key.
        //
        if ((($_installed = Input::get('install')) !== null) or (($_installed = Input::get('installed')) !== null) or (($_uninstalled = Input::get('uninstall')) !== null) or (($_uninstalled = Input::get('uninstalled')) !== null))
        {
            $installed = ($_installed !== null) ? (bool) $_installed : ( ! (bool) $_uninstalled);
        }

        // If we have an enabled key.
        //
        if ((($_enabled = Input::get('enable')) !== null) or (($_enabled = Input::get('enabled')) !== null) or (($_disabled = Input::get('disable')) !== null) or (($_disabled = Input::get('disabled')) !== null))
        {
            $enabled = ($_enabled !== null) ? (bool) $_enabled : ( ! (bool) $_disabled);
        }

        try
        {
            // If we want the extension to be installed.
            //
            if ($installed === true)
            {
                // Install the extension.
                //
                $extension = $manager->install($slug);
            }

            // If we want the extension to be uninstalled.
            //
            elseif ($installed === false)
            {
                // Uninstall the extension.
                //
                $extension = $manager->uninstall($slug);
            }

            // If the module is installed, we do some more checks.
            //
            if ($manager->is_installed($slug))
            {
                // If we want the module to be enabled or not.
                //
                if ( ! is_null($enabled))
                {
                    $method = ( $enabled === true ) ? 'enable' : 'disable';
                    $module = $manager->$method($slug);
                }
                // If we want the module to be updated.
                //
                if ($update = Input::get('update'))
                {
                    $module = $manager->update($slug);
                }
            }
        }
        catch (Exception $e)
        {
            return new Response(array(
                'message' => $e->getMessage()
            ), API::STATUS_BAD_REQUEST);
        }

        // Remove callbacks as they're no use in JSON.
        //
        array_forget($extension, 'listeners');
        array_forget($extension, 'routes');

        // Return the extension information.
        //
        return new Response($extension);
    }
}
