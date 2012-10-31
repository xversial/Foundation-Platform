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
use Platform\Menus\Menu;


/**
 * --------------------------------------------------------------------------
 * Install Class v1.0.0
 * --------------------------------------------------------------------------
 * 
 * Settings installation.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 */
class Platform_Settings_v1_0_0
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
         * # 1) Create the settings table.
         * --------------------------------------------------------------------------
         */
        Schema::create('settings', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('extension');
            $table->string('type');
            $table->string('name');
            $table->text('value');
        });


        /*
         * --------------------------------------------------------------------------
         * # 2) Configuration settings.
         * --------------------------------------------------------------------------
         */
        $settings = array(
            // Website title.
            //
            array(
                'extension' => 'settings',
                'type'      => 'site',
                'name'      => 'title',
                'value'     => 'Platform'
            ),

            // Website tagline.
            //
            array(
                'extension' => 'settings',
                'type'      => 'site',
                'name'      => 'tagline',
                'value'     => 'A base application on Laravel'
            )
        );

        // Insert the settings into the database.
        //
        DB::table('settings')->insert($settings);


        /*
         * --------------------------------------------------------------------------
         * # 3) Create the menus.
         * --------------------------------------------------------------------------
         */
        // Get the System menu.
        //
        $system = Menu::find('admin-system');

        // Admin > System > Settings
        //
        $settings = new Menu(array(
            'name'          => 'Settings',
            'extension'     => 'settings',
            'slug'          => 'admin-settings',
            'uri'           => 'settings',
            'user_editable' => 0,
            'status'        => 1
        ));
        $settings->last_child_of($system);
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
         * # 1) Drop the necessary tables.
         * --------------------------------------------------------------------------
         */
        Schema::drop('settings');


        /*
         * --------------------------------------------------------------------------
         * # 2) Delete the menus.
         * --------------------------------------------------------------------------
         */
        if ($menu = Menu::find('admin-settings'))
        {
            $menu->delete();
        }
    }
}
