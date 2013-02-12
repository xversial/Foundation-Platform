<?php
/**
 * Part of the Theme bundle for Laravel.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Theme
 * @version    1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Theme;

use Bundle;
use Config;
use Exception;
use File;

class ThemeException extends Exception {}

class Theme
{

	/**
	 * The base theme directory
	 *
	 * @var string
	 */
	public static $directory;

	/**
	 * The active theme name
	 *
	 * @var string
	 */
	public static $active;

	/**
	 * The fallback theme name
	 *
	 * @var string
	 */
	public static $fallback;

	/**
	 * The compile directory for theme assets
	 *
	 * @var string
	 */
	protected static $compile_directory;

	/**
	 * The bundle directory
	 *
	 * @var string
	 */
	public static $bundle_directory;

	/**
	 * The assets directory
	 *
	 * @var string
	 */
	public static $assets_directory;

	/**
	 * Sets / gets the theme directory.
	 *
	 * @param   string  $directory
	 * @return  mixed
	 */
	public static function directory($directory = null)
	{
		if ($directory === null)
		{
			if (static::$directory === null)
			{
				static::$directory = path('public').Config::get('theme::theme.directory');
			}

			return static::$directory;
		}

		static::$directory = str_finish($directory, DS);
	}

	/**
	 * Sets / gets the active theme name.
	 *
	 * @param   string  $active
	 * @return  mixed
	 */
	public static function active($active = null)
	{
		if ($active === null)
		{
			if (static::$active === null)
			{
				static::$active = Config::get('theme::theme.active');
			}

			return static::$active;
		}

		static::$active = str_finish($active, DS);
	}

	/**
	 * Sets / gets the active path
	 *
	 * @param   string  $active_path
	 * @return  mixed
	 */
	public static function active_path($active_path = null)
	{
		if ( ! $active = static::$active)
		{
			return null;
		}

		return str_finish(static::directory(), DS).static::active();
	}

	/**
	 * Sets / gets the fallback theme name.
	 *
	 * @param   string  $fallback
	 * @return  mixed
	 */
	public static function fallback($fallback = null)
	{
		if ($fallback === null)
		{
			if (static::$fallback === null)
			{
				static::$fallback = Config::get('theme::theme.fallback');
			}

			return static::$fallback;
		}

		static::$fallback = str_finish($fallback, DS);
	}

	/**
	 * Sets / gets the compile directory
	 *
	 * @param   string  $compile_directory
	 * @return  mixed
	 */
	public static function compile_directory($compile_directory = null)
	{
		if ($compile_directory === null)
		{
			if (static::$compile_directory === null)
			{
				static::$compile_directory = str_finish(Theme::directory(), DS).Config::get('theme::theme.less.compile_directory');
			}

			return static::$compile_directory;
		}

		static::$compile_directory = $compile_directory;
	}

	/**
	 * Sets / gets the fallback path
	 *
	 * @param   string  $fallback_path
	 * @return  mixed
	 */
	public static function fallback_path($fallback_path = null)
	{
		if ( ! $fallback = static::$fallback)
		{
			return null;
		}

		return str_finish(static::directory(), DS).static::fallback();
	}

	/**
	 * Sets / gets the bundle directory.
	 *
	 * @param   string  $bundle_directory
	 * @return  mixed
	 */
	public static function bundle_directory($bundle_directory = null)
	{
		if ($bundle_directory === null)
		{
			if (static::$bundle_directory === null)
			{
				static::$bundle_directory = Config::get('theme::theme.bundle_directory');
			}

			return static::$bundle_directory;
		}

		static::$bundle_directory = str_finish($bundle_directory, DS);
	}

	/**
	 * Sets / gets the assets directory.
	 *
	 * @param   string  $assets_directory
	 * @return  mixed
	 */
	public static function assets_directory($assets_directory = null)
	{
		if ($assets_directory === null)
		{
			if (static::$assets_directory === null)
			{
				static::$assets_directory = Config::get('theme::theme.assets_directory');
			}

			return static::$assets_directory;
		}

		static::$assets_directory = str_finish($assets_directory, DS);
	}

	/**
	 * Finds all themes in a path
	 *
	 * @param   string  $directory
	 * @return  array   $themes
	 */
	public static function all($directory = null)
	{
		$directory = str_finish(static::directory(), DS).$directory;

		$themes = glob(str_finish($directory, DS).'*', GLOB_ONLYDIR);

		if ($themes === false)
		{
			return array();
		}

		foreach ($themes as &$theme)
		{
			$theme = basename($theme);
		}

		return $themes;
	}

	/**
	 * Returns theme info from the theme.info file
	 *
	 * @param   string  $theme
	 * @return  array   $theme
	 */
	public static function info($theme)
	{
		// Fallback array.
        //
        $info = array();

        // Prepare the theme.info file path.
        //
        $theme = str_replace('/', DS, $theme);
        $file = str_finish(static::directory(), DS) . str_finish($theme, DS) . 'theme.info';

        // Check if the file exists.
        //
        if ($contents = File::get($file) and $info = json_decode($contents, true))
        {
            // Add some more information.
            //
            $info['thumbnail'] = static::thumbnail($theme);
        }

        // Return the theme info.
        //
        return $info;
	}

	/*
	|--------------------------------------------------------------------------
	| View Proxy
	|--------------------------------------------------------------------------
	|
	| The following methods act as a proxy for the Theme View loading process.
	|
	*/

	/**
	 * Create a new theme view instance.
	 *
	 * <code>
	 *		// Create a new view instance
	 *		$view = Theme::make('home.index');
	 *
	 *		// Create a new view instance of a bundle'sn theme view
	 *		$view = Theme::make('admin::home.index');
	 *
	 *		// Create a new view instance with bound data
	 *		$view = Theme::make('home.index', array('name' => 'Taylor'));
	 * </code>
	 *
	 * @param  string  $view
	 * @param  array   $data
	 * @return View
	 */
	public static function make($view, $data = array())
	{
		return new View($view, $data);
	}

	/**
	 * Find a theme view file within the theme system.
	 *
	 * @param   string  $bundle
	 * @param   string  $view
	 * @return  string  $file
	 */
	public static function file($bundle, $view)
	{
		return View::find_file($bundle, $view);
	}

	/**
	 * Register a view composer with the Event class.
	 *
	 * <code>
	 *		// Register a composer for the "home.index" view
	 *		View::composer('home.index', function($view)
	 *		{
	 *			$view['title'] = 'Home';
	 *		});
	 * </code>
	 *
	 * @param  string|array  $view
	 * @param  Closure       $composer
	 * @return void
	 */
	public static function composer($views, $composer)
	{
		return View::composer($views, $composer);
	}

	/*
	|--------------------------------------------------------------------------
	| Asset Proxy
	|--------------------------------------------------------------------------
	|
	| The following files act as a proxy for the Theme View loading process.
	|
	*/

	/**
	 * Outputs an asset(s) based
	 * on their path.
	 *
	 * Each string param passed to this
	 * method is treated as a new asset.
	 *
	 * @param   mixed
	 * @return  string
	 */
	public static function asset()
	{
		return call_user_func_array('Theme\\Asset::output', func_get_args());
	}

	/**
	 * Add an asset to the queue to be outputted later on.
	 *
	 * @param  string  $name
	 * @param  string  $asset
	 * @param  array   $dependencies
	 * @param  array   $attributes
	 * @param  array   $container
	 * @return void
	 */
	public static function queue_asset($name, $asset, $dependencies = array(), $attributes = array(), $container = null)
	{
		return Asset::queue($name, $asset, $dependencies, $attributes, $container);
	}

	/**
	 * Releases queued assets
	 *
	 * @param  string  $container
	 * @return string
	 */
	public static function release_assets($type, $container = null)
	{
		return Asset::release($type, $container);
	}

	/**
     * --------------------------------------------------------------------------
     * Function: thumbnail()
     * --------------------------------------------------------------------------
     *
     * Returns the theme thumbnail url.
     *
     * @access   public
     * @param    string
     * @return   string
     */
	public static function thumbnail($theme = null)
    {
        // Get the thumbnail.
        //
        $thumbnail = glob(str_finish(static::directory(), DS) . str_finish($theme, DS) . static::assets_directory() . DS . '*' . DS . 'theme-thumbnail.png');

        // Return the thumbnail url.
        //
        return Asset::url(end($thumbnail));
    }

}
