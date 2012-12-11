<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst Software Licence.
 *
 * @package    Cartalyst Social
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst Software Licence - http://cartalyst.com/licence
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Laravel\CLI\Command;
use Platform\Menus\Menu;

class Platform_Social_v1_0_0
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Command::run(array('migrate', 'sentrysocial'));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		// find sentrysocial migrations
		$migrations = DB::table('laravel_migrations')->where('bundle', '=', 'sentrysocial')->get();
		$path = Bundle::path('sentrysocial') . 'migrations' . DS;

        // Loop through the migration files.
        //
        foreach($migrations as $migration)
        {
            // Include the migration file.
            //
            require_once $path.$migration->name.EXT;

            $_migration = basename(str_replace(EXT, '', $migration->name));
            $_migration = 'SentrySocial_'.substr($_migration, 18);

            $class = new $_migration();

            $class->down();

            DB::table('laravel_migrations')->where('name', '=', $migration->name)->delete();
        }
	}

}
