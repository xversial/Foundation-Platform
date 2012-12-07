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
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use Installer\Installer;


/**
 * --------------------------------------------------------------------------
 * Installer Class
 * --------------------------------------------------------------------------
 *
 * The Platform Installer.
 *
 * @package    Platform
 * @author     Ben Corlett
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.1
 */
class Installer_Update_Controller extends Installer_Base_Controller
{
    /**
     * --------------------------------------------------------------------------
     * Function: before()
     * --------------------------------------------------------------------------
     *
     * This function is called before the action is executed.
     *
     * @access   public
     * @return   mixed
     */
    public function before()
    {
        // Call the parent.
        //
        parent::before();

        // Check if Platform is already installed.
        //
        if ( ! Platform::is_installed())
        {
            Redirect::to('installer')->send();
            exit;
        }
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_step_1()
     * --------------------------------------------------------------------------
     *
     * This step is a pre-installtion checklist to make sure the system is
     * prepare to be installed.
     *
     * @access   public
     * @return   View
     */
    public function get_step_1()
    {
        return View::make('installer::update.step_1')
            ->with('code_version', Platform::version())
            ->with('installed_version', Config::get('platform.installed_version'));
    }

    /**
     * --------------------------------------------------------------------------
     * Function: post_step_1()
     * --------------------------------------------------------------------------
     *
     * Check the person has backed up their database first.
     *
     * @access   public
     * @return   View
     */
    public function post_step_1()
    {
        if ( ! $disclaimer = Input::get('disclaimer'))
        {
            return Redirect::to('installer/update');
        }

        return Redirect::to('installer/update/update');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_update()
     * --------------------------------------------------------------------------
     *
     * Actually does the update process.
     *
     * @access   public
     * @return   void
     */
    public function get_update()
    {
        Installer::update();

        return Redirect::to('installer/update/step_2');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_step_2()
     * --------------------------------------------------------------------------
     *
     * The completion step.
     *
     * @access   public
     * @return   View
     */
    public function get_step_2()
    {
        return View::make('installer::update.step_2')->with('license', Platform::license());
    }
}
