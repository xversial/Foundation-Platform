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
 *
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 */
class Platform_Menus_v1_1_0
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
         * # 1) Grab all menu itmes.
         * --------------------------------------------------------------------------
         */
        $menus = Menu::all();

        /*
         * --------------------------------------------------------------------------
         * # 2) Update the menu table.
         * --------------------------------------------------------------------------
         */
		Schema::table('menus', function($table)
		{
            // Remove the old columns as their column types are not consistent.
            //
            $table->drop_column('target');
            $table->drop_column('visibility');
		});

        Schema::table('menus', function($table)
        {
            // Add menu type column.
            //
            $table->integer('type')->default(Menu::TYPE_STATIC);

            // Re-add columns.
            //
            $table->integer('target')->default(Menu::TARGET_SELF);
            $table->integer('visibility')->default(Menu::VISIBILITY_ALWAYS);

            // We're now supporting "page" types.
            //
            $table->integer('page_id')->unsigned()->nullable();

            // Vendor column.
            //
            $table->string('vendor')->nullable();
        });


        /*
         * --------------------------------------------------------------------------
         * # 2) Update the menu items.
         * --------------------------------------------------------------------------
         */
		foreach ($menus as $menu)
		{
			if ( ! $menu->is_root())
			{
                $menu->type = Menu::TYPE_STATIC;
			}

            switch ($menu->slug)
            {
                case 'main-login':
                    $menu->class = 'icon-signin';
                    break;
                case 'main-logout':
                    $menu->class = 'icon-signout';
                    break;
                case 'main-admin-dashboard':
                    $menu->class = 'icon-cog';
                    break;
                case 'main-register':
                    $menu->class = 'icon-pencil';
                    break;
            }

            // Save all menu items to update the columns
			$menu->save();
		}


        /*
         * --------------------------------------------------------------------------
         * # 2) Update the menu.
         * --------------------------------------------------------------------------
         */
        $menus = array(
            'admin',
            'admin-system',
            'admin-menus',
            'main',
            'main-login',
            'main-logout',
            'main-register',
            'main-home',
            'main-admin-dashboard'
        );
        foreach ($menus as $slug)
        {
            if ($menu = Menu::find($slug))
            {
                $menu->vendor = 'platform';
                $menu->save();
            }
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
         * # 1) Update the menu table.
         * --------------------------------------------------------------------------
         */
		Schema::table('menus', function($table)
		{
			$table->drop_column('type');
			$table->drop_column('page_id');
		});


        /*
         * --------------------------------------------------------------------------
         * # 2) Update the menu.
         * --------------------------------------------------------------------------
         */
        $menus = array(
            'admin',
            'admin-system',
            'admin-menus',
            'main',
            'main-login',
            'main-logout',
            'main-register',
            'main-home',
            'main-admin-dashboard'
        );
        foreach ($menus as $slug)
        {
            if ($menu = Menu::find($slug))
            {
                $menu->vendor = '';
                $menu->save();
            }
        }
	}
}
