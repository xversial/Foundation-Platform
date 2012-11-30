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

use Platform\Menus\Menu;


/**
 * --------------------------------------------------------------------------
 * Install Class v[[version]]
 * --------------------------------------------------------------------------
 *
 * [[name]] installation.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 */
class [[namespace_underscore]]_v[[version_classified]]
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
        // Get the Admin menu.
        //
        $admin = Menu::admin_menu();

        // Get the System menu.
        //
        $system = Menu::find('admin-system');

        // Admin > [[name]]
        //
        $[[extension]] = new Menu(array(

            // The name as it appears
            'name'          => '[[name]]',

            // The extension that owns it
            'extension'     => '[[extension]]',

            // The slug, must be unique
            'slug'          => 'admin-[[extension]]',

            // The URI that will handle it. Admin menu
            // items are automatically prefixed with the
            // /admin url.
            'uri'           => '[[handles]]',

            // Users cannot delete the menu item through
            // the admin panel. Only can be deleted programatically.
            'user_editable' => 0,

            // Enabled menu item
            'status'        => 1,
        ));

        // Check if we have the system menu.
        //
        if (is_null($system))
        {
            $[[extension]]->last_child_of($admin);
        }
        else
        {
            $[[extension]]->previous_sibling_of($system);
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
         * # 1) Delete the menus.
         * --------------------------------------------------------------------------
         */
        if ($[[extension]] = Menu::find('admin-[[extension]]'))
        {
            $[[extension]]->delete();
        }
    }
}
