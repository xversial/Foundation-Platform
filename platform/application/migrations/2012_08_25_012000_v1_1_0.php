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

/**
 * --------------------------------------------------------------------------
 * Install Class v1.1.0
 * --------------------------------------------------------------------------
 * 
 * Installs the base tables for Platform
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 */
class v1_0_0
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
    	// Now, some people may be upgrading to 1.1 from 1.0. If this is
    	// the case, the `extensions` table exists. If so, we skip the
    	// create statement
    	try
    	{
    		// Grab all extensions registered
    		$extensions = DB::table('extensions')->get();

    		// And drop the table
    		Schema::drop_table('extensions');
    	}
    	catch (Laravel\Database\Exception $e)
    	{
    		$extension = array();
    	}

    	Schema::create('extensions', function($table){
            $table->increments('id');
            $table->string('vendor', 150);
            $table->string('slug', 150);
            $table->string('version', 10);
            $table->boolean('enabled')->default(0);
        });
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
