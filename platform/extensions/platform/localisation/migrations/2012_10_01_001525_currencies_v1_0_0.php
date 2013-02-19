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
 * Currencies Install Class v1.0.0
 * --------------------------------------------------------------------------
 *
 * Currencies installation.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.0
 */
class Platform_Localisation_Currencies_v1_0_0
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
        Schema::create('currencies', function($table){
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug');
            $table->string('code', 5);
            $table->string('sign');
            $table->string('after_price');
            $table->string('ths_sign', 1)->nullable();
            $table->string('decimal_sign', 1)->nullable();
            $table->string('decimals', 1)->nullable();
            $table->decimal('rate', 15, 8)->nullable();
            $table->integer('status')->default(1);
            $table->integer('cdh_id')->nullable();
            $table->timestamps();
        });


        /*
         * --------------------------------------------------------------------------
         * # 2) Insert the currencies.
         * --------------------------------------------------------------------------
         */
        // Define a primary currency, just in case.
        //
        $primary = 'USD';

        // Read the json file.
        //
        $file = json_decode(Filesystem::make('native')->file()->contents(__DIR__ . DS . 'data' . DS . 'currencies.json'), true);

        // Loop through the currencies.
        //
        $currencies = array();
        foreach ( $file as $currency )
        {
            $currencies[] = array(
                'name'          => $currency['name'],
                'slug'          => \Str::slug($currency['name']),
                'code'          => strtoupper($currency['code']),
                'sign'          => $currency['sign'],
                'after_price'   => ( isset($currency['after_price']) ? $currency['after_price'] : '' ),
                'ths_sign'      => ( isset($currency['ths_sign']) ? $currency['ths_sign'] : ',' ),
                'decimal_sign'  => ( isset($currency['decimal_sign']) ? $currency['decimal_sign'] : '.' ),
                'decimals'      => ( isset($currency['decimals']) ? $currency['decimals'] : 2 ),
                'rate'          => ( isset($currency['rate']) ? $currency['rate'] : '' ),
                'status'        => ( isset($currency['status']) ? $currency['status'] : 1 ),
                'created_at'    => new \DateTime,
                'updated_at'    => new \DateTime
            );

            // Is this a primary currency ?
            //
            if (isset($currency['primary']))
            {
                $primary = $currency['code'];
            }
        }

        // Insert the currencies into the database.
        //
        DB::table('currencies')->insert( $currencies );


        /*
         * --------------------------------------------------------------------------
         * # 3) Configuration settings.
         * --------------------------------------------------------------------------
         */
        $settings = array(
            // Primary currency.
            //
            array(
                'vendor'    => 'platform',
                'extension' => 'localisation',
                'type'      => 'site',
                'name'      => 'currency',
                'value'     => strtoupper($primary)
            ),

            // Set the interval time for every rate update.
            //
            array(
                'vendor'    => 'platform',
                'extension' => 'localisation',
                'type'      => 'site',
                'name'      => 'currency_auto_update',
                'value'     => ''
            ),

            // Default API Key for Openexchangerates.org
            //
            array(
                'vendor'    => 'platform',
                'extension' => 'localisation',
                'type'      => 'site',
                'name'      => 'currency_api_key',
                'value'     =>  ''
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
        $currencies_menu = new Menu(array(
            'name'          => 'Currencies',
            'vendor'        => 'platform',
            'extension'     => 'currencies',
            'slug'          => 'admin-currencies',
            'uri'           => 'localisation/currencies',
            'user_editable' => 0,
            'status'        => 1,
            'class'         => 'icon-money'
        ));
        $currencies_menu->last_child_of($localisation_menu);
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
        Schema::drop('currencies');


        /*
         * --------------------------------------------------------------------------
         * # 2) Delete configuration settings.
         * --------------------------------------------------------------------------
         */
        DB::table('settings')->where('extension', '=', 'localisation')->where('name', 'LIKE', 'currency%')->delete();


        /*
         * --------------------------------------------------------------------------
         * # 3) Delete the menus.
         * --------------------------------------------------------------------------
         */
        if ($menu = Menu::find('admin-currencies'))
        {
            $menu->delete();
        }
    }
}
