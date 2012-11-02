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
 * Install Class v1.1.0
 * --------------------------------------------------------------------------
 *
 * Filesystem bundle settings.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 */
class Platform_Settings_v1_1_0
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
         * # 1) Configuration settings.
         * --------------------------------------------------------------------------
         */
        // Get the currents settings from the database
        //
        $settings = array();
        foreach(DB::table('settings')->get() as $setting)
        {
            $settings[] = (array) $setting;
        }

        // Drop the current settings table.
        //
        Schema::drop('settings');

        // Create the table again with the new column, but the columns are organized!
        //
        Schema::create('settings', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('vendor');
            $table->string('extension');
            $table->string('type');
            $table->string('name');
            $table->text('value');
        });

        // List of directories of the extensions! 
        //
        $vendors_directories = array_map(function($file)
        {
            return str_replace(path('extensions'), '', dirname($file));
        }, (array) glob(path('extensions') . '*' . DS . '*' . DS . 'extension' . EXT, GLOB_NOSORT));

        $default_directories = array_map(function($file)
        {
            return str_replace(path('extensions'), '', dirname($file));
        }, (array) glob(path('extensions') . '*' . DS . 'extension' . EXT, GLOB_NOSORT));
        $directories = array_merge($vendors_directories, $default_directories);

        // Loop through the directories.
        //
        foreach ($directories as $directory)
        {
            // Check if the extension has a vendor.
            //
            if (strpos($directory, DS))
            {
                list($vendor, $extension) = explode(DS, $directory);
            }

            // Extension without a vendor.
            //
            else {
                $vendor    = 'default';
                $extension = $directory;
            }

            // Loop through the settngs and add the vendor entry to it.
            //
            foreach ($settings as &$setting)
            {
                if ($setting['extension'] === $extension)
                {
                    $setting['vendor'] = $vendor;
                }
            }
        }

        // Insert the settings into the database.
        //
        DB::table('settings')->insert($settings);


        /*
         * --------------------------------------------------------------------------
         * # 2) File system configuration settings.
         * --------------------------------------------------------------------------
         */
        $settings = array(
            // Frontend fallback message.
            //
            array(
                'vendor'    => 'platform',
                'extension' => 'settings',
                'type'      => 'filesystem',
                'name'      => 'frontend_fallback_message',
                'value'     => 'off'
            ),

            // Frontend failed message.
            //
            array(
                'vendor'    => 'platform',
                'extension' => 'settings',
                'type'      => 'filesystem',
                'name'      => 'frontend_failed_message',
                'value'     => 'off'
            ),

            // Backend fallback message.
            //
            array(
                'vendor'    => 'platform',
                'extension' => 'settings',
                'type'      => 'filesystem',
                'name'      => 'backend_fallback_message',
                'value'     => 'warning'
            ),

            // Backend failed message.
            //
            array(
                'vendor'    => 'platform',
                'extension' => 'settings',
                'type'      => 'filesystem',
                'name'      => 'backend_failed_message',
                'value'     => 'warning'
            ),
        );

        // Insert the settings into the database.
        //
        DB::table('settings')->insert($settings);


        /*
         * --------------------------------------------------------------------------
         * # 3) Update the menu.
         * --------------------------------------------------------------------------
         */
        if ($menu = Menu::find('admin-settings'))
        {
            $menu->vendor = 'platform';
            $menu->save();
        }
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
         * # 1) Remove the column.
         * --------------------------------------------------------------------------
         */
        Schema::table('settings', function($table)
        {
            $table->drop_column('vendor');
        });


        /*
         * --------------------------------------------------------------------------
         * # 2) Delete filesystem configuration settings.
         * --------------------------------------------------------------------------
         */
        DB::table('settings')->where('extension', '=', 'settings')->where('type', '=', 'filesystem')->delete();


        /*
         * --------------------------------------------------------------------------
         * # 3) Update the menu.
         * --------------------------------------------------------------------------
         */
        if ($menu = Menu::find('admin-settings'))
        {
            $menu->vendor = '';
            $menu->save();
        }
    }
}