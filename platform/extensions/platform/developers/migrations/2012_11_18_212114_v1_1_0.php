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
use Platform\Menus\Menu;


/**
 * --------------------------------------------------------------------------
 * Install Class v1.1.0
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
class Platform_Developers_v1_1_0
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
         * # 1) Update the extension creator menu.
         * --------------------------------------------------------------------------
         */
        if($menu = Menu::find('admin-developers-creator'))
        {
            $menu->extension = 'developers';
            $menu->slug      = 'admin-developers-extension-creator';
            $menu->uri       = 'developers/extension_creator';
            $menu->save();
        }


        /*
         * --------------------------------------------------------------------------
         * # 2) Create the theme creator menu.
         * --------------------------------------------------------------------------
         */
        // Get the developers menu.
        //
        $developers = Menu::find('admin-developers');

        // Admin > System > Developers > Theme Creator
        //
        $developers_theme_creator = new Menu(array(
            'name'          => 'Theme Creator',
            'vendor'        => 'platform',
            'extension'     => 'developers',
            'slug'          => 'admin-developers-theme-creator',
            'uri'           => 'developers/theme_creator',
            'user_editable' => 0,
            'status'        => 1,
            'class'         => 'icon-eye-open'
        ));
        $developers_theme_creator->last_child_of($developers);
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
         * # 1) Delete the theme creator menu.
         * --------------------------------------------------------------------------
         */
        if ($menu = Menu::find('admin-developers-theme-creator'))
        {
            $menu->delete();
        }
    }
}
