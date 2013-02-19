<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst Software Licence.
 *
 * @package    Cartalyst Media
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst Software Licence - http://www.getplatform.com/licence
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Platform\Menus\Menu;

class Platform_Media_Install
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		/* # Create Menu Table
		================================================== */

		Schema::create('media', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('vendor')->nullable();
			$table->string('extension');
			$table->string('name');
			$table->string('file_path');
			$table->string('file_name');
			$table->string('file_extension');
			$table->string('mime');
			$table->integer('size')->unsigned();
			$table->integer('width')->nullable();
			$table->integer('height')->nullable();
			$table->timestamps();
		});

		/* # Create Menu Items
		================================================== */

		// Create a menu item
		$media = new Menu(array(
			'name'          => 'Media',
			'extension'     => 'media',
			'slug'          => 'admin-media',
			'uri'           => 'media',
			'user_editable' => 0,
			'status'        => 1,
			'class'         => 'icon-picture',
		));

		// Find dashboard menu item
		$system = Menu::find(function($query)
		{
			return $query->where('slug', '=', 'admin-system');
		});

		// Fallback
		if ($system === null)
		{
			$admin = Menu::admin_menu();
			$media->last_child_of($admin);
		}
		else
		{
			$media->previous_sibling_of($system);
		}
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('media');

		// Find menu item
		$media = Menu::find(function($query)
		{
			return $query->where('slug', '=', 'admin-media');
		});

		if ($media !== null)
		{
			$media->delete();
		}
	}

}
