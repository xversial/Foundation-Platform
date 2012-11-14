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


/*
 * --------------------------------------------------------------------------
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use Platform\Menus\Menu;


/**
 * --------------------------------------------------------------------------
 * Localisation Install Class v1.0.0
 * --------------------------------------------------------------------------
 *
 * Localisation installation.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.0
 */
class Platform_Localisation_v1_0_0
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
        // Admin > System > Localisation
        //
        $system_menu = Menu::find('admin-system');
        $localisation = new Menu(array(
            'name'          => 'Localisation',
            'vendor'        => 'platform',
            'extension'     => 'localisation',
            'slug'          => 'admin-localisation',
            'uri'           => 'localisation',
            'user_editable' => 0,
            'status'        => 1,
            'class'         => 'icon-plane'
        ));
        $localisation->last_child_of($system_menu);


        /*
         * --------------------------------------------------------------------------
         * # 2) Configuration settings.
         * --------------------------------------------------------------------------
         */
        $settings = array(
            // Default date format.
            //
            array(
                'vendor'    => 'platform',
                'extension' => 'localisation',
                'type'      => 'site',
                'name'      => 'date_format',
                'value'     => '%Y-%m-%d'
            ),

            // Default time format.
            //
            array(
                'vendor'    => 'platform',
                'extension' => 'localisation',
                'type'      => 'site',
                'name'      => 'time_format',
                'value'     => '%H:%M:%S'
            )
        );
        DB::table('settings')->insert($settings);
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
        if ($menu = Menu::find('admin-localisation'))
        {
            $menu->delete();
        }


        /*
         * --------------------------------------------------------------------------
         * # 2) Delete configuration settings.
         * --------------------------------------------------------------------------
         */
        DB::table('settings')->where('extension', '=', 'localisation')->where('name', 'LIKE', '%_format')->delete();
    }
}
