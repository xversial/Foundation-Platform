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

namespace Theme\Compilers;

use Config;
use Exception;
use File;
use URL;
use stdclass;

class PlatformLess extends lessc
{

	/**
	 * Compiles a file.
	 *
	 * @param   string  $less_file
	 * @param   string  $css_file
	 * @param   string  $bundle_path
	 */
	public function compile($less_file, $css_file = null)
	{
		$filesystem = \Filesystem::make('native');

		// Check that the file either doesn't
		// exist, or the modified time of the
		// LESS file is newer than that of the
		// CSS file
		if ( ! is_file($css_file)
				or $filesystem->file()->modified($less_file) > $filesystem->file()->modified($css_file))
		{
			// The directory that holds the LESS file
			$less_directory = dirname($less_file);

			// Get the parsed CSS
			$css = with(new lessc($less_file))->parse();

			// Check image paths and replace relative paths with paths relative
			// to the theme.
			$css = preg_replace_callback('/url\([\'"]?(.*?)[\'"]?\)/', function($matches) use ($less_directory)
			{
				$url = $matches[1];

				// If the URL is a valid
				// URL, we just return it
				if (URL::valid($url))
				{
					return ' url(\''.$url.'\')';
				}

				// Get path and segments
				$replacements = array(
					path('public') => \URL::to(),
					'\\' => '/'
				);

				$file     = str_replace(array_keys($replacements), array_values($replacements), $less_directory.DS.$url);
				$segments = explode('/', $file);

				// Remove relative URLs
				foreach ($segments as $segment)
				{
					// Double dots just go 1 level
					// up in the file system. Remove
					// the double dot and the entry
					// before it.
					if ($segment == '..' and isset($segments[key($segments) - 2]))
					{
						unset($segments[key($segments) - 2]);
						unset($segments[key($segments) - 1]);
					}
				}

				// Implode the segments and return the URL
				return ' url(\''.implode('/', $segments).'\')';

			}, $css);

			$filesystem->file()->write($css_file, $css);

			return true;
		}

		return false;
	}

}
