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
class Installer_Base_Controller extends Base_Controller
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

        // Setup CSS.
        //
        Asset::add('bootstrap', 'platform/installer/css/bootstrap.min.css');
 		Asset::add('font-awesome', 'platform/installer/css/font-awesome.css');
        Asset::add('installer', 'platform/installer/css/installer.css');

        // Setup JS.
        //
        Asset::add('jquery', 'platform/installer/js/jquery.js');
        Asset::add('url', 'platform/installer/js/url.js');
        Asset::add('bootstrap', 'platform/installer/js/bootstrap.min.js', array('jquery'));
        Asset::add('validation', 'platform/installer/js/validate.js', array('jquery'));
        Asset::add('tempo', 'platform/installer/js/tempo.js', array('jquery'));
        Asset::add('installer', 'platform/installer/js/installer.js', array('jquery'));
    }

    /**
     * --------------------------------------------------------------------------
     * Function: get_index()
     * --------------------------------------------------------------------------
     *
     * An alias for the step 1.
     *
     * @access   public
     * @return   void
     */
    public function get_index()
    {
        return $this->get_step_1();
    }

    /**
     * --------------------------------------------------------------------------
     * Function: __call()
     * --------------------------------------------------------------------------
     *
     * Catch-all method for requests that can't be matched.
     *
     * @access   public
     * @param    string
     * @param    array
     * @return   Response
     */
    public function __call($method, $parameters)
    {
        return $this->get_index();
    }
}
