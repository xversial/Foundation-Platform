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
 * Languages Install Class v1.0.0
 * --------------------------------------------------------------------------
 * 
 * Languages installation.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.0
 */
class Platform_Localisation_Languages_v1_0_0
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
         * # 1) Create the necessary tables.
         * --------------------------------------------------------------------------
         */
        Schema::create('languages', function($table){
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('abbreviation', 5);
            $table->string('locale');
            $table->integer('status')->default(1);
            $table->timestamps();
        });


        /*
         * --------------------------------------------------------------------------
         * # 2) Insert the languages.
         * --------------------------------------------------------------------------
         */
        // Define a default language and locale, just in case.
        //
        $default = 'en';
        $locale  = 'English_United Kingdom';

        // Read the json file.
        //
        $file = json_decode(Filesystem::make('native')->file()->contents(__DIR__ . DS . 'data' . DS . 'languages.json'), true);

        // Loop through the languages.
        //
        $languages = array();
        foreach ($file as $language)
        {
            $languages[] = array(
                'name'         => $language['name'],
                'slug'         => \Str::slug($language['name']),
                'abbreviation' => $language['abbreviation'],
                'locale'       => $language['locale'],
                'status'       => ( isset($language['status']) ? $language['status'] : 1 ),
                'created_at'   => new \DateTime,
                'updated_at'   => new \DateTime
            );

            // Is this a default language ?
            //
            if (isset($language['default']))
            {
                // Mark it as the default then.
                //
                $default = $language['abbreviation'];
                $locale  = $language['locale'];
            }
        }

        // Insert the languages into the database.
        //
        DB::table('languages')->insert($languages);


        /*
         * --------------------------------------------------------------------------
         * # 3) Configuration settings.
         * --------------------------------------------------------------------------
         */
        $settings = array(
            // Default language.
            //
            array(
                'extension' => 'localisation',
                'type'      => 'site',
                'name'      => 'language',
                'value'     => $default
            ),

            // Default language locale.
            //
            array(
                'extension' => 'localisation',
                'type'      => 'site',
                'name'      => 'language_locale',
                'value'     => $locale
            )
        );
        DB::table('settings')->insert($settings);


        /*
         * --------------------------------------------------------------------------
         * # 4) Create the menus.
         * --------------------------------------------------------------------------
         */
        // Admin > System > Localisation > Languages
        //
        $localisation_menu = Menu::find('admin-localisation');
        $languages_menu = new Menu(array(
            'name'          => 'Languages',
            'extension'     => 'languages',
            'slug'          => 'admin-languages',
            'uri'           => 'localisation/languages',
            'user_editable' => 0,
            'status'        => 1
        ));
        $languages_menu->last_child_of($localisation_menu);
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
        Schema::drop('languages');


        /*
         * --------------------------------------------------------------------------
         * # 2) Delete configuration settings.
         * --------------------------------------------------------------------------
         */
        DB::table('settings')->where('extension', '=', 'localisation')->where('name', 'LIKE', 'language%')->delete();


        /*
         * --------------------------------------------------------------------------
         * # 3) Delete the menus.
         * --------------------------------------------------------------------------
         */
        if ($menu = Menu::find('admin-languages'))
        {
            $menu->delete();
        }
    }
}
