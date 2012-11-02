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
 * Installs the base tables for Platform.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 */
class v1_1_0
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
        // Fallback array.
        //
        $extensions = array();

        // Now, some people may be upgrading to 1.1 from 1.0,
        // if this is the case, the `extensions` table exists.
        //
        try
        {
            // Grab all the registered extensions.
            //
            foreach (DB::table('extensions')->get() as $extension)
            {
                $extensions[] = (array) $extension;
            }

            // Drop the extensions table.
            //
            Schema::drop('extensions');
        }
        catch (Laravel\Database\Exception $e)
        {
        }

        // Create the extensions table.
        //
        Schema::create('extensions', function($table){
            $table->increments('id');
            $table->string('vendor', 150);
            $table->string('extension', 150);
            $table->string('version', 10);
            $table->boolean('enabled')->default(0);
        });

        // If we grabbed extensions from the database.
        //
        if (count($extensions) > 0)
        {
            // Insert the extensions on the database again.
            //
            DB::table('extensions')->insert($extensions);
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

    }
}
