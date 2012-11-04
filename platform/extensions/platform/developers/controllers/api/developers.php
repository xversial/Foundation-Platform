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

class Platform_Developers_API_Developers_Controller extends API_Controller
{

	protected $variable_start = "[[";
	protected $variable_end   = "]]";

	public function post_create()
	{
		// Filesystem
		$filesystem = Filesystem::make('native');
		$file       = $filesystem->file();
		$directory  = $filesystem->directory();

		// Properties
		$vendor    = Input::get('vendor');
		$extension = Input::get('extension');

		// Get root directory for created extension cache
		$root_directory = $this->create_root_directory();

		// Create the extension directory based on the vendor and extension name
		$extension_directory = $this->create_extension_directory($root_directory, $vendor, $extension);

		// Grab the stub directory for an extension.
		$extension_stub_directory = Bundle::path('platform/developers').'stubs'.DS.'creator'.DS.'extension';

		// We'll copy it over to the real directory
		$this->copy_contents($extension_stub_directory, $extension_directory);

		// Now, the theme working directory
		$theme_backend_directory  = $this->create_theme_backend_directory($root_directory, $vendor, $extension);
		$theme_frontend_directory = $this->create_theme_frontend_directory($root_directory, $vendor, $extension);

		// Get theme stub directories
		$theme_backend_stub_directory  = Bundle::path('platform/developers').'stubs'.DS.'creator'.DS.'theme'.DS.'backend';
		$theme_frontend_stub_directory = Bundle::path('platform/developers').'stubs'.DS.'creator'.DS.'theme'.DS.'frontend';

		// We'll copy it over to the real directory
		$this->copy_contents($theme_backend_stub_directory, $theme_backend_directory);
		$this->copy_contents($theme_frontend_stub_directory, $theme_frontend_directory);

		// Right, now we have the root directory, we need to recursively write out the variables
		$this->write_variables_recursively($root_directory, array(
			'vendor'    => $vendor,
			'extension' => $extension,
		));

		// Create the zip
		$zip_location = $this->create_zip($root_directory, time().'-'.$vendor.'-'.$extension.'.zip');

		switch (Input::get('encoding', 'base64'))
		{
			case 'utf-8':
				$encoded = utf8_encode($file->contents($zip_location));
				break;
			
			default:
				$encoded = base64_encode($file->contents($zip_location));
				break;
		}

		// Now, remove the directory
		$directory->delete($root_directory);
		$file->delete($zip_location);

		return new Response($encoded);
	}

	public function create_zip($root_directory, $zip_name)
	{
		$zip_name = dirname($root_directory).DS.$zip_name;
		$zip = new ZipArchive();
		$zip->open($zip_name, ZipArchive::CREATE);

		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator(
				$root_directory,
				RecursiveDirectoryIterator::SKIP_DOTS
			),
			RecursiveIteratorIterator::SELF_FIRST
		);

		foreach ($iterator as $item)
		{
			$path = $item->getRealPath();

			if ($item->isDir())
			{
				$zip->addEmptyDir(str_replace($root_directory.DS, '', $path));
			}
			else
			{
				$zip->addFile($path, str_replace($root_directory.DS, '', $path));
			}
		}

		$zip->close();

		return $zip_name;
	}

	public function list_all_file_paths($root_directory)
	{
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator(
				$root_directory,
				RecursiveDirectoryIterator::SKIP_DOTS
			),
			RecursiveIteratorIterator::SELF_FIRST
		);

		foreach ($iterator as $item)
		{
			if ($item->isDir())
			{
				// mkdir($destination.DS.$iterator->getSubPathName());
			}
			else
			{
				echo $item->getRealPath() . '<br>';
				// copy($item, $destination.DS.$iterator->getSubPathName());
			}
		}
	}

	public function write_variables_recursively($root_directory, array $variables)
	{
		$items = new FilesystemIterator($root_directory, FilesystemIterator::SKIP_DOTS);

		foreach ($items as $item)
		{
			if ($item->isDir())
			{
				$this->write_variables_recursively($item->getRealPath(), $variables);
			}
			else
			{
				$tmp_variables = array_flip($variables);

				$variable_start = $this->variable_start;
				$variable_end   = $this->variable_end;

				$tmp_variables = array_map(function($value) use ($variable_start, $variable_end)
				{
					return $variable_start.$value.$variable_end;
				}, $tmp_variables);

				// Save the array_flip, we reverse our replacements
				$result = str_replace(array_values($tmp_variables), array_keys($tmp_variables), File::get($item->getRealPath()));

				if ($result)
				{
					File::put($item->getRealPath(), $result);
				}
			}
		}
	}

	public function create_root_directory()
	{
		// Prepare directories
		$work_directory  = path('storage').'work';
		$cache_directory = $work_directory.DS.'developers'.DS.'create'.DS.'cache';
		$root_directory  = $cache_directory.DS.time();

		Filesystem::make('native')->directory()->make($root_directory);

		return $root_directory;
	}

	public function create_extension_directory($root_directory, $vendor, $extension)
	{
		$extension_directory = $root_directory.DS.'platform'.DS.'extensions'.DS.$vendor.DS.$extension;

		Filesystem::make('native')->directory()->make($extension_directory);

		return $extension_directory;
	}

	public function create_theme_backend_directory($root_directory, $vendor, $extension)
	{
		$theme_directory = $root_directory.DS.'public'.DS.'platform'.DS.'themes'.DS.'backend'.DS.'default'.DS.'extensions'.DS.$vendor.DS.$extension;

		Filesystem::make('native')->directory()->make($theme_directory);

		return $theme_directory;
	}

	public function create_theme_frontend_directory($root_directory, $vendor, $extension)
	{
		$theme_directory = $root_directory.DS.'public'.DS.'platform'.DS.'themes'.DS.'frontend'.DS.'default'.DS.'extensions'.DS.$vendor.DS.$extension;

		Filesystem::make('native')->directory()->make($theme_directory);

		return $theme_directory;
	}

	public function copy_contents($source, $destination)
	{
		$iterator = new RecursiveIteratorIterator(
			new RecursiveDirectoryIterator(
				$source,
				RecursiveDirectoryIterator::SKIP_DOTS
			),
			RecursiveIteratorIterator::SELF_FIRST
		);

		foreach ($iterator as $item)
		{
			if ($item->isDir())
			{
				mkdir($destination.DS.$iterator->getSubPathName());
			}
			else
			{
				copy($item, $destination.DS.$iterator->getSubPathName());
			}
		}
	}

}