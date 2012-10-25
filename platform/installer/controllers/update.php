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

    public function post_step_1()
    {
        sleep(5);
    }
}
