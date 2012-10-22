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
 * Users installation.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 */
class Pages_v1_1_0
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
    	/**
    	 * -----------------------------------------
    	 * # 1) Create Pages and Content Table
    	 * -----------------------------------------
    	 */

		Schema::create('pages_content', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('name');
			$table->string('slug');
			$table->text('content');
		});

		Schema::create('pages', function($table)
    	{
    		$table->increments('id')->unsigned();
    		$table->string('name');
    		$table->string('slug');
    		$table->text('content');
    		$table->string('template');
    		$table->boolean('status');
    	});


        /*
         * --------------------------------------------------------------------------
         * # 2) Create Pages Menu Items
         * --------------------------------------------------------------------------
         */

        // Get the Admin menu.
        //
        $admin = Menu::admin_menu();

        // Get the System menu to insert before it.
        //
        $system = Menu::find('admin-system');

        // Admin > Pages
        //
        $pages = new Menu(array(
            'name'          => 'Pages',
            'extension'     => 'pages',
            'slug'          => 'admin-pages',
            'uri'           => 'pages',
            'user_editable' => 0,
            'status'        => 1,
        ));

        if (is_null($system))
        {
            $pages->last_child_of($admin);
        }
        else
        {
            $pages->previous_sibling_of($system);
        }

        // Admin > Pages > Pages list
        //
        $pages_pages = new Menu(array(
            'name'          => 'Pages',
            'extension'     => 'pages',
            'slug'          => 'admin-pages-pages',
            'uri'           => 'pages',
            'user_editable' => 0,
            'status'        => 1,
        ));
        $pages_pages->last_child_of($pages);

        // Admin > Pages > Content list
        //
        $pages_content = new Menu(array(
            'name'          => 'Content',
            'extension'     => 'content',
            'slug'          => 'admin-pages-content',
            'uri'           => 'pages/content',
            'user_editable' => 0,
            'status'        => 1,
        ));
        $pages_content->last_child_of($pages);

        /*
         * --------------------------------------------------------------------------
         * # 3) Configuration settings.
         * --------------------------------------------------------------------------
         */

		$settings = array(
			// Status Disabled
			//
			array(
				'extension' => 'pages',
				'type'      => 'status',
				'name'      => 'disabled',
				'value'     => '0'
			),

			// Status Enabled
			//
			array(
				'extension' => 'pages',
				'type'      => 'status',
				'name'      => 'enabled',
				'value'     => '1'
			),

			// default page (/index)
			//
			array(
				'extension' => 'pages',
				'type'      => 'default',
				'name'      => 'page',
				'value'     => 'home',
			),

			// default template (default)
			//
			array(
				'extension' => 'pages',
				'type'      => 'default',
				'name'      => 'template',
				'value'     => 'default'
			),
		);

		// Insert the settings into the database.
		//
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

    }
}
