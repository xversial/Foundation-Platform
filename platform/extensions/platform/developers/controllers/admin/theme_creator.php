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


/**
 * --------------------------------------------------------------------------
 * Developers > Admin > Theme Creator
 * --------------------------------------------------------------------------
 *
 * Theme creator.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.1
 */
class Platform_Developers_Admin_Theme_Creator_Controller extends Admin_Controller
{
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
        $this->active_menu('admin-developers-theme-creator');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_index()
     * --------------------------------------------------------------------------
     *
     * Show the theme creator main page.
     *
     * @access   public
     * @return   View
     */
    public function get_index()
    {
        // Show the page.
        //
        return Theme::make('platform/developers::theme.creator');
    }


    /**
     * --------------------------------------------------------------------------
     * Function:  post_index()
     * --------------------------------------------------------------------------
     *
     * Form processing method.
     *
     * @access   public
     * @return   void
     */
    public function post_index()
    {
        // Make the API request.
        //
        $request = API::post('developers/theme_creator', array(
            'name'        => Input::get('name'),
            'slug'        => Input::get('slug'),
            'author'      => Input::get('author'),
            'description' => Input::get('description'),
            'version'     => Input::get('version'),
            'area'        => Input::get('area'),

            // Tell the API how we want our extension returned to us.
            // We can either base64 encode or utf-8 encode the ZIP contents.
            //
            'encoding' => 'base64'
        ));

        // Check if we have valid contents.
        //
        if (($contents = base64_decode($request)) === false)
        {
            Platform::message()->error(Lang::line('platform/developers::messages.creator.decode_fail'));

            return Redirect::to_admin('developers/theme_creator');
        }
    }
}
