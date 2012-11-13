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
 * @version    1.1.0
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
class Platform_Pages_v1_1_0
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
        Schema::create('content', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->text('value');
        });

        Schema::create('pages', function($table)
        {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->text('value');
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
            'vendor'        => 'platform',
            'extension'     => 'pages',
            'slug'          => 'admin-pages',
            'uri'           => 'pages',
            'user_editable' => 0,
            'status'        => 1,
            'class'         => 'icon-file'
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
            'vendor'        => 'platform',
            'extension'     => 'pages',
            'slug'          => 'admin-pages-pages',
            'uri'           => 'pages',
            'user_editable' => 0,
            'status'        => 1,
            'class'         => 'icon-file'
        ));
        $pages_pages->last_child_of($pages);

        // Admin > Pages > Content list
        //
        $pages_content = new Menu(array(
            'name'          => 'Content',
            'vendor'        => 'platform',
            'extension'     => 'pages',
            'slug'          => 'admin-pages-content',
            'uri'           => 'pages/content',
            'user_editable' => 0,
            'status'        => 1,
            'class'         => 'icon-briefcase'
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
                'vendor'    => 'platform',
                'extension' => 'pages',
                'type'      => 'status',
                'name'      => 'disabled',
                'value'     => '0'
            ),

            // Status Enabled
            //
            array(
                'vendor'    => 'platform',
                'extension' => 'pages',
                'type'      => 'status',
                'name'      => 'enabled',
                'value'     => '1'
            ),

            // default page (/index)
            //
            array(
                'vendor'    => 'platform',
                'extension' => 'pages',
                'type'      => 'default',
                'name'      => 'page',
                'value'     => 1,
            ),

            // default template (default)
            //
            array(
                'vendor'    => 'platform',
                'extension' => 'pages',
                'type'      => 'default',
                'name'      => 'template',
                'value'     => 'default'
            )
        );

        // Insert the settings into the database.
        //
        DB::table('settings')->insert($settings);


        /*
         * --------------------------------------------------------------------------
         * # 4) Initial Welcome Page & Content.
         * --------------------------------------------------------------------------
         */
        // Default Welcome Page
        //
        $page = array(
            'name'      => 'Welcome',
            'slug'      => 'welcome',
            'value'     => '<div class="introduction hero-unit">@content(\'welcome-page-introduction\')</div><div class="features row"><div class="span4">@content(\'feature-block-develop\')</div><div class="span4">@content(\'feature-block-design\')</div><div class="span4">@content(\'feature-block-extend\')</div></div>',
            'template'  => 'default',
            'status'    => '1',
        );

        $welcome_page_id = DB::table('pages')->insert($page);

        // Create the main link.
        //
        $main = Menu::main_menu();

        // Create the home link.
        //
        $home = new Menu(array(
            'name'          => 'Home',
            'extension'     => 'menus',
            'slug'          => 'main-home',
            'visibility'    => 0,
            'user_editable' => 1,
            'status'        => 1,
            'class'         => 'icon-home',
            'type'          => Menu::TYPE_PAGE,
            'page_id'       => $welcome_page_id,
            'vendor'        => 'platform'

        ));
        $home->first_child_of($main);

        $content = array(
            // Company Name
            //
            array(
                'name'      => 'Company',
                'slug'      => 'company',
                'value'     => 'Platform',
            ),

            // Copyright
            //
            array(
                'name'      => 'Copyright',
                'slug'      => 'copyright',
                'value'     => 'The BSD 3-Clause License - Copyright &copy; 2011-2012, Cartalyst LLC',
            ),


            // Feature Block Develop
            //
            array(
                'name'      => 'Feature Block Develop',
                'slug'      => 'feature-block-develop',
                'value'     => '<h2>Develop</h2><p>Platform is Core light and built upon a strong PHP framework with great documentation and a fantastic community, Laravel.</p>',
            ),

            // Feature Block Design
            //
            array(
                'name'      => 'Feature Block Design',
                'slug'      => 'feature-block-design',
                'value'     => '<h2>Design</h2><p>Powerful theme system that utilizes the blade template engine giving front end developers a solid separation between logic and markup.</p>',
            ),

            // Feature Block Extend
            //
            array(
                'name'      => 'Feature Block Extend',
                'slug'      => 'feature-block-extend',
                'value'     => '<h2>Extend</h2><p>You won’t find complex and tangled control structures; everything in Platform is an extension and completely modular.</p>',
            ),

            // Welcome Page Introduction
            //
            array(
                'name'      => 'Welcome Page Introduction',
                'slug'      => 'welcome-page-introduction',
                'value'     => '<h1>@content(\'company\')</h1><p>An application bootstrap for Laravel. The fundamentals + a few essentials included. It\'s well documented, feature awesome, open source, and always free.</p><p><a href="http://www.getplatform.com" class="btn btn-primary btn-large" target="_blank">Learn more &raquo</a></p>',
            ),

        );

        DB::table('content')->insert($content);
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
