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


/*
 * --------------------------------------------------------------------------
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use Platform\Menus\Menu,
    Platform\Settings\Model\Setting;


/**
 * --------------------------------------------------------------------------
 * Settings > Admin Class
 * --------------------------------------------------------------------------
 *
 * Class to manage your website settings.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.1
 */
class Platform_Settings_Admin_Settings_Controller extends Admin_Controller
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
        $this->active_menu('admin-settings');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_index()
     * --------------------------------------------------------------------------
     *
     * The main page of the settings extension.
     *
     * @access   public
     * @return   View
     */
    public function get_index()
    {
        // Initiate an empty array.
        //
        $settings = array();
        $tabs     = array();

        // Get the settings from the database.
        //
        $_settings = API::get('settings', array('organize' => true));

        // Get all the extensions.
        //
        foreach (API::get('extensions') as $extension => $vendors)
        {
            // Loop through this extension vendors.
            //
            foreach ($vendors as $vendor => $info)
            {
                // Make sure this extension settings widget exists.
                //
                if( ! class_exists(ucfirst($vendor) . '\\' . ucfirst($extension) . '\\Widgets\\Settings'))
                {
                    continue;
                }

                // Get this extension settings, if any.
                //
                $extension_settings = array_get($_settings, $extension . '.' . $vendor, array());

                // Loop through all this extension settings
                //
                foreach ($extension_settings as $type => $setting)
                {
                    // Populate the array.
                    //
                    foreach($setting as $data)
                    {
                        // One tab per extension, only !
                        //
                        if ( ! isset($tabs[ $extension ]))
                        {
                            $tabs[ $extension ] = $vendor . '/' . $extension;
                        }

                        // Store the settings.
                        //
                        $settings[ $extension ][ $vendor ][ $type ][ $data['name'] ] = $data['value'];
                    }
                }
            }
        }

        // Unset the unnecessary data.
        //
        unset($_settings);

        // Sort the tabs order.
        //
        ksort($tabs);

        // Now, let's make sure the "General Settings" tab comes first..
        //
        $_tabs = array();
        $_tabs['settings'] = $tabs['settings'];
        foreach($tabs as $key => $value)
        {
            if($key != 'settings')
            {
                $_tabs[ $key ] = $value;
            }
        }
        $tabs = $_tabs;

        // Show the page.
        //
        return Theme::make('platform/settings::index')->with('tabs', $tabs)->with('settings', $settings);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: post_index()
     * --------------------------------------------------------------------------
     *
     * Form processing.
     *
     * @access   public
     * @return   Redirect
     */
    public function post_index()
    {
        // Initiate an empty array.
        //
        $settings = array();

        // Loop through the submited data.
        //
        foreach (Input::get() as $field => $value)
        {
            // Extension field shall not pass !
            //
            if ($field === 'extension')
            {
                continue;
            }

            // Find the type and name for the respective field.
            // If a field contains a ':', then a type was given.
            //
            if (strpos($field, ':') !== false)
            {
                list($type, $name) = explode(':', $field);
            }
            else
            {
                $type = '';
                $name = $field;
            }

            // Get this extension name.
            //
            $extension = Input::get('extension', 'platform/settings');

            // Make sure we have the proper vendor.
            //
            if (strpos($extension, '/'))
            {
                list($vendor, $extension) = explode('/', $extension);
            }
            else
            {
                $vendor = ExtensionsManager::DEFAULT_VENDOR;
            }

            // Set validation if the field doesn't exist.
            //
            $validation = null;

            // Check if this widget has validation rules.
            //
            $widget = ucfirst($vendor) . '\\' . ucfirst($extension) . '\\Widgets\\Settings';
            if (isset($widget::$validation) and array_key_exists($name, $widget::$validation))
            {
                // Get the rules.
                //
                $validation = array($name => array_get($widget::$validation, $name));
            }

            // Set the values.
            //
            $settings[] = array(
                'vendor'     => $vendor,
                'extension'  => $extension,
                'type'       => $type,
                'name'       => $name,
                'value'      => $value,
                'validation' => $validation
            );
        }

        try
        {
            // Make the API request.
            //
            $request = API::put('settings', array('settings' => $settings));

            // If we have fields that were updated with success.
            //
            if ($updated = array_get($request, 'updated'))
            {
                // Loop through each updated setting.
                //
                foreach ($updated as $setting)
                {
                    // Set the success message.
                    //
                    Platform::messages()->success(Lang::line('platform/settings::message.success', array('setting' => $setting)));
                }
            }

            // If we have fields that were not updated with success.
            //
            if ($errors = array_get($request, 'errors'))
            {
                // Loop through the error messages.
                //
                foreach ($errors as $error)
                {
                    // Set the error message.
                    //
                    Platform::messages()->error($error);
                }
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
        }

        // Redirect back to the settings page.
        //
        return Redirect::to_admin('settings');
    }
}
