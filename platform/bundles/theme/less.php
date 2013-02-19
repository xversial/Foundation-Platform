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

use Config;
use Exception;
use File;
use Log;
use Theme\Compilers\PlatformLess;

class LESS
{

	/**
	 * Compiles a LESS file into CSS. $bundle and $asset
	 * are used to determine where on disk the new file
	 * will be put.
	 *
	 * @param   string  $less_file
	 * @param   string  $bundle
	 * @param   string  $asset
	 * @return  string  $css_file
	 */
	public static function compile($less_file, $bundle, $asset)
	{
		$filesystem = \Filesystem::make('native');

		if ( ! $filesystem->file()->exists($less_file))
		{
			return false;
		}

		$asset_info = pathinfo($asset);

		// Intelligently work out the CSS path
		$css_directory = Theme::compile_directory().DS.Theme::active().Theme::assets_directory().DS.(($bundle === DEFAULT_BUNDLE) ? '' : $bundle.DS).$asset_info['dirname'];
		$css_file      = $css_directory.DS.$asset_info['filename'].'.css';

		// Make sure the path exists
		$filesystem->directory()->make($css_directory, 0777, true);

		try
		{
			// Remove all old less imports
			static::remove_old_less_imports($less_file, $css_file);

		    PlatformLess::compile($less_file, $css_file);
		}

		catch (Exception $e)
		{
			Log::theme($e->getMessage());
			return false;
		}

		return $css_file;
	}

	/**
	 * Removes all copmiled files that are included
	 * via the CSS @import() method.
	 *
	 * @param   string  $less_file
	 * @param   string  $css_file
	 * @return  void
	 */
	protected static function remove_old_less_imports($less_file, $css_file)
	{
		$filesystem = \Filesystem::make('native');

		if ( ! $filesystem->file()->exists($less_file))
		{
			return;
		}

		// $contents = file_get_contents($less_file);
		$contents = $filesystem->file()->contents($less_file);
		preg_match_all('/@import\s+"(?<imports>.*?)"/i', $contents, $matches);

		$base_dir = str_replace(basename($less_file), '', $less_file);

		foreach ($matches['imports'] as $import)
		{
			// if an import is modified after the last compile, we'll just delete
			// the css_file file so the compiler will recompile everything
			if ($filesystem->file()->exists($base_dir.$import)
					and $filesystem->file()->exists($css_file)
					and $filesystem->file()->modified($base_dir.$import) > $filesystem->file()->modified($css_file))
			{
				$filesystem->file()->delete($css_file);
				break;
			}
		}
	}

}
