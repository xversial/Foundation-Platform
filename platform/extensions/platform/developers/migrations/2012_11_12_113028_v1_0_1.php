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
 * Install Class v1.0.0
 * --------------------------------------------------------------------------
 * 
 * Menus installation.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 */
class Platform_Developers_v1_0_1
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
         * # 1) Create the menu items.
         * --------------------------------------------------------------------------
         */

        // Grab the developers extension
        $developers = Menu::find('admin-developers');

        // Update the extension creator menu item as we're adding a theme
        // creator.
        if ($developers_creator = Menu::find('admin-developers-creator'))
        {
            $developers_creator->slug      = 'admin-developers-extension-creator';
            $developers_creator->uri       = 'developers/extension_creator';
            $developers_creator->extension = 'developers';
            $developers_creator->save();
        }

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
        if ($developers_extension_creator = Menu::find('admin-developer-extension-creator'))
        {
            $developers_extension_creator->slug      = 'admin-developer-creator';
            $developers_extension_creator->uri       = 'developers/creator';

            // Note, don't reintroduce bug with the incorrect extension,
            // just revert features.

            $developers_extension_creator->save();
        }
    }
}
