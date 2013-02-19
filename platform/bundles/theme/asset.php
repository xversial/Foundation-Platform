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
use File;
use HTML;
use Laravel\Asset as LaravelAsset;
use Laravel\Asset_container as LaravelAsset_Container;
use Request;
use Str;
use URL;

class Asset
{

	/**
	 * The asset container name
	 *
	 * @var string
	 */
	public static $container_name;

	/**
	 * Sets / gets the asset container name.
	 *
	 * @param   string  $container_name
	 * @return  mixed
	 */
	public static function container_name($container_name = null)
	{
		if ($container_name === null)
		{
			if (static::$container_name === null)
			{
				static::$container_name = Config::get('theme::theme.container_name');
			}

			return static::$container_name;
		}

		static::$container_name = $container_name;
	}

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
	public static function output()
	{
		// Check we have assets
		// actually passed through
		if (count($assets = func_get_args()) === 0)
		{
			return null;
		}

		// Asset groups
		$groups = array(
			'css'   => array(),
			'less'  => array(),
			'js'    => array(),
			'other' => array(),
		);

		foreach ($assets as $asset)
		{
			// If the file exists
			if ($file = static::file($asset))
			{
				$type = Str::lower(pathinfo($file, PATHINFO_EXTENSION));

				// If we compile LESS into CSS...
				if ($type === 'less' and Config::get('theme::theme.less.compile'))
				{
					// Gotta use _ to avoid name collision
					list($bundle, $_asset) = Bundle::parse($asset);

					// If the file failed to compile for whatever reason
					if ( ! $compiled = LESS::compile($file, $bundle, $_asset))
					{
						continue;
					}

					$asset = $compiled;
					$type  = 'css';
				}
			}

			// Try get a URL
			elseif ($url = static::url($asset))
			{
				$url_path = parse_url($url, PHP_URL_PATH);
				$type     = pathinfo($url_path, PATHINFO_EXTENSION);
			}

			// Otherwise, just give up
			else
			{
				continue;
			}

			// Categorize the asset according
			// to type
			if (array_key_exists($type, $groups))
			{
				$url = static::url($asset);

				switch ($type)
				{
					case 'css':
						$html = HTML::style($url);
						break;
					case 'less':
						$html = HTML::style($url, array('rel' => 'stylesheet/less'));
						break;
					case 'js':
						$html = HTML::script($url);
						break;
					default:
						$html = $url;
						break;
				}

				$groups[$type][] = $html;
			}
			else
			{
				$groups['other'][] = static::url($asset);
			}
		}

		// A compiled string
		$html = '';

		// Loop through groups and add to
		// compiled
		foreach ($groups as $type)
		{
			$html .= implode(PHP_EOL, $type);
		}

		// Secure requests, we replace
		// all http://{base_url} calls with
		// their https:// counterparts
		if (Request::secure())
		{
			$html = preg_replace('~http://'.URL::base().'~', 'https:\/\/'.URL::base(), $html);
		}

		return $html;
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
	public static function queue($name, $asset, $dependencies = array(), $attributes = array(), $container = null)
	{
		// Container fallback
		if ($container === null)
		{
			$container = static::container_name();
		}

		// If we have a valid URL, don't do any processing
		// on the asset, just give it straight to the Asset
		// class.
		if ( ! URL::valid($asset))
		{
			// We have to have a URL for
			// our asset.
			if ( ! $file = static::file($asset))
			{
				return false;
			}

			// If we've got a valid URL for
			// our asset, don't touch it
			if ( ! URL::valid($asset))
			{
				$type = Str::lower(pathinfo($file, PATHINFO_EXTENSION));

				// If we compile LESS into CSS...
				if ($type === 'less' and Config::get('theme::theme.less.compile'))
				{
					// Gotta use _ to avoid name collision
					list($bundle, $_asset) = Bundle::parse($asset);

					// If the file failed to compile for whatever reason
					if ($compiled = LESS::compile($file, $bundle, $_asset))
					{
						$asset = $compiled;
						$type  = 'css';
					}
				}
			}
		}

		LaravelAsset::container($container)->add($name, static::url($asset), $dependencies, $attributes);
	}

	/**
	 * Releases queued assets
	 *
	 * @param  string  $type
	 * @param  string  $container
	 * @return string
	 */
	public static function release($type, $container = null)
	{
		// Container fallback
		if ($container === null)
		{
			$container = static::container_name();
		}

		// Convert to Laravel methods
		switch ($type)
		{
			case 'css':
				$type = 'styles';
				break;
			case 'js':
				$type = 'scripts';
				break;
		}

		return LaravelAsset::container($container)->$type();
	}

	/**
	 * Returns the URL for an asset. Returns
	 * false if the asset doesn't exist.
	 *
	 * @param   string  $asset
	 * @return  string
	 */
	public static function url($asset)
	{
		// If we've been given a full URL
		if (URL::valid($asset))
		{
			return str_replace('\\', '/', $asset);
		}

		// Else if we have a full path to an existing asset
		elseif ((starts_with($asset, Theme::directory()) and $file = $asset) or $file = static::file($asset))
		{
			$file = str_replace(path('public'), null, $file);
			$file = str_replace('\\', '/', $file);

			return URL::to_asset(str_replace(path('public'), null, $file));
		}

		return false;
	}

	/**
	 * Returns the file for an asset. Returns
	 * false if the asset doesn't exist.
	 *
	 * @param   string  $asset
	 * @return  string
	 */
	public static function file($asset)
	{
		list($bundle, $asset) = Bundle::parse($asset);

		$filesystem = \Filesystem::make('native');

		foreach (static::directories($bundle) as $directory)
		{
			// If we find a file, return it
			if ($filesystem->file()->exists($directory.$asset))
			{
				return $directory.$asset;
			}
		}

		// throw new \Exception("can't find asset [".Bundle::identifier($bundle, $asset)."]");

		return false;
	}

	/**
	 * Returns an array of available asset
	 * directories.
	 *
	 * @param   string  $bundle
	 * @return  string
	 */
	public static function directories($bundle)
	{
		$bundle           = ($bundle == DEFAULT_BUNDLE) ? '' : $bundle.DS;
		$bundle_directory = ($bundle) ? str_finish(Theme::bundle_directory(), DS) : '';

		return array(

			// Active theme directory
			str_finish(Theme::active_path().$bundle_directory.$bundle.Theme::assets_directory(), DS),

			// Fallback theme directory
			str_finish(Theme::fallback_path().$bundle_directory.$bundle.Theme::assets_directory(), DS),
		);
	}

}
