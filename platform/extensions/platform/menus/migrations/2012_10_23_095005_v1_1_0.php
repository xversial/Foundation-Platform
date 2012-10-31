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
 * Adds a class column to menus.
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
            // Remove the old columns as their column types are
            // not consistent.
            $table->drop_column('target');
            $table->drop_column('visibility');
		});

        Schema::table('menus', function($table)
        {
            // Add menu type column
            $table->integer('type')
                  ->default(Menu::TYPE_STATIC);

            // Re-add columns
            $table->integer('target')
                  ->default(Menu::TARGET_SELF);
            $table->integer('visibility')
                  ->default(Menu::VISIBILITY_ALWAYS);

            // We're now supporting "page" types.
            $table->integer('page_id')
                  ->unsigned()
                  ->nullable();
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

            // Save all menu items to update the columns
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
         * # 1) Update the menu table.
         * --------------------------------------------------------------------------
         */
		Schema::table('menus', function($table)
		{
			$table->drop_column('type');
			$table->drop_column('page_id');
		});
	}
}

/* End of file 2012_09_07_103640_add_class_column.php */
/* Location: ./platform/extensions/platform/menus/migrations/2012_09_07_103640_add_class_column.php */