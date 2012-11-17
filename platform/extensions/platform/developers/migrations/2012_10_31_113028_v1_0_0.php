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
use Platform\Menus\Menu;


/**
 * --------------------------------------------------------------------------
 * Install Class v1.0.0
 * --------------------------------------------------------------------------
 *
 * Developers installation.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 */
class Platform_Developers_v1_0_0
{
    /**
     * --------------------------------------------------------------------------
     * Function: up()
     * --------------------------------------------------------------------------
     *
     * Make changes to the database.
     *
     * @access   public
     * @return   void
     */
    public function up()
    {
        /*
         * --------------------------------------------------------------------------
         * # 1) Create the menus.
         * --------------------------------------------------------------------------
         */
        // Get the System menu.
        //
        $system = Menu::find('admin-system');

        // Admin > System > Developers
        //
        $developers = new Menu(array(
            'name'          => 'Developers',
            'vendor'        => 'platform',
            'extension'     => 'developers',
            'slug'          => 'admin-developers',
            'uri'           => 'developers',
            'user_editable' => 0,
            'status'        => 1,
            'class'         => 'icon-github'
        ));
        $developers->last_child_of($system);
        $developers->reload();

        // Admin > System > Developers > Extension Creator
        //
        $developers_creator = new Menu(array(
            'name'          => 'Extension Creator',
            'vendor'        => 'platform',
            'extension'     => 'developers-creator',
            'slug'          => 'admin-developers-creator',
            'uri'           => 'developers/creator',
            'user_editable' => 0,
            'status'        => 1,
            'class'         => 'icon-magic'
        ));

        $developers_creator->last_child_of($developers);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: down()
     * --------------------------------------------------------------------------
     *
     * Revert the changes to the database.
     *
     * @access   public
     * @return   void
     */
    public function down()
    {
        /*
         * --------------------------------------------------------------------------
         * # 1) Delete the menus.
         * --------------------------------------------------------------------------
         */
        if ($developers = Menu::find('admin-developers'))
        {
            $developers->delete();
        }
        if ($developers_creator = Menu::find('admin-developers-creator'))
        {
            $developers_creator->delete();
        }
    }
}
