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

namespace Platform\Themes\Widgets;


/*
 * --------------------------------------------------------------------------
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use API,
	APIClientException,
	Platform,
    Theme;


/**
 * --------------------------------------------------------------------------
 * Themes > Settings widget class
 * --------------------------------------------------------------------------
 *
 * Wigdet class for changing themes.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.0
 */
class Settings
{
    /**
     * --------------------------------------------------------------------------
     * Function: index()
     * --------------------------------------------------------------------------
     *
     * Shows the themes settings form.
     *
     * @access   public
     * @return   View
     */
    public function index($settings = null)
    {
    	try
    	{
	        // Get all themes for the frontend.
	        //
	        $frontend = API::get('themes/frontend', array('organize' => true));
    	}
    	catch (APIClientException $e)
    	{
    		$frontend = array();
    		Platform::messages()->error($e->getMessage());
    	}

    	try
    	{
	        // Get all themes for the backend.
	        //
	        $backend = API::get('themes/backend', array('organize' => true));
    	}
    	catch (APIClientException $e)
    	{
    		$backend = array();
    		Platform::messages()->error($e->getMessage());
    	}

        // Show the form page.
        //
        return Theme::make('platform/themes::widgets.form.settings')
                ->with('settings', $settings)
                ->with('frontend_themes', $frontend)
                ->with('backend_themes', $backend);
    }
}
