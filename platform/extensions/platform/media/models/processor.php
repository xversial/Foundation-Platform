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

namespace Platform\Media;

use Config;
use Exception;
use File;
use Filesystem;
use Lang;
use Input;
use Str;
use Symfony\Component\HttpFoundation\File\File as HttpFoundationFile;
use Validator;

class ProcessorException extends Exception {}

class ProcessorValidationException extends ProcessorException
{
	/**
     * An array of errors for the Exception.
     *
     * @access    protected
     * @var       array
     */
    protected $errors = array();


    /**
     * --------------------------------------------------------------------------
     * Function: errors()
     * --------------------------------------------------------------------------
     *
     *  Sets / gets errors for an API Exception.
     *
     * @access   public
     * @param    array
     * @return   array
     */
    public function errors(array $errors = array())
    {
        // If we have errors to be added.
        //
        if ( ! empty($errors))
        {
            $this->errors = $errors;
        }

        // Return the errors.
        //
        return $this->errors;
    }
}

class Processor
{
	/**
	 * The key used for when simulating an
	 * upload file in the $_FILES array, used for
	 * Laravel Validation.
	 *
	 * @var string
	 */
	protected static $files_key = 'media_upload';

	/**
	 * Returns the temporary media directory.
	 *
	 * @return  string
	 */
	public static function temporary_directory()
	{
		return str_finish(Media::directory(), DS).Config::get('platform/media::media.temporary_directory', 'tmp');
	}

	/**
	 * Validates a file at the given path. Does some
	 * trickery and magic with the $_FILES array.
	 *
	 * @param  string        $full_path
	 * @param  string|array  $rules
	 * @throws ProcessorValidationException
	 * @return bool
	 */
	public static function validate($full_path, $rules)
	{
		// Default rules to configuration
		$rules or $rules = static::generate_validation_string();

		// Laravel's file validation class, appropriately,
		// relies heavily on $_FILES. We'll cache the original
		// $_FILES array, modify it, run the validation and
		// then put everything back below.
		$original_files = $_FILES;

		// Get pathinfo of the full path. We use this for
		// mocking a new $_FILES file
		$pathinfo = pathinfo($full_path);

		$_FILES[static::$files_key] = array(
			'name'     => $pathinfo['basename'],
			'type'     => File::mime($pathinfo['extension']),
			'tmp_name' => $full_path,
			'error'    => 0,
			'size'     => File::size($full_path),
		);

		$validation = Validator::make(Input::file(), array(
			static::$files_key => $rules,
		));

		// Run validation and store result
		$fails = $validation->fails();

		// Reset files
		$_FILES = $original_files;

		// If validation failed, let's throw an
		// exception to bubble up the stack
		if ($fails)
		{
			$exception = new ProcessorValidationException('Media validation failed');
			$exception->errors($validation->errors->all());

			throw $exception;
		}

		// Made it this far? Validation passed.
		return true;
	}

	/**
	 * Places an old file in the media system based
	 * on the configuration passed through.
	 *
	 * Returns an array that contains information
	 * about the newly placed file.
	 *
	 * @param  string  $old_file
	 * @param  array   $config
	 * @return array   $info
	 */
	public static function place($old_file, array $config)
	{
		if ( ! File::exists($old_file) or ! is_writable($old_file))
		{
			throw new ProcessorException("Insufficient media permissions to remove old file [$old_file]");
		}

		// Get info from the old filename
		$old_pathinfo = pathinfo($old_file);

		// Parse some configuration values
		$dispersion         = date(array_get($config, 'dispersion', Config::get('platform/media::media.placement.dispersion', 'Y'.DS.'m')));
		$randomize_filename = (bool) array_get($config, 'randomize_filename', Config::get('platform/media::media.placement.randomize_filename', false));
		$filename           = array_get($config, 'filename', pathinfo($old_file, PATHINFO_BASENAME));
		$extension          = array_get($config, 'extension', DEFAULT_BUNDLE);

		// Grab the filesystem
		$filesystem = Filesystem::make('native');

		// New directory to house the file
		$file_path     = $extension.DS.$dispersion;
		$new_directory = Media::directory().DS.$file_path;

		// Lazily create the needed directory and determine the
		// new filename
		if ( ! $filesystem->directory()->exists($new_directory))
		{
			// Create the directory
			$filesystem->directory()->make($new_directory);

			// We don't need to parse the filename for duplicates
			// because we just created the directory
			$new_basename = ($randomize_filename === true) ? uniqid('', true).'.'.$old_pathinfo['extension'] : $filename;
		}
		else
		{
			// If we randomize file names, no need
			// for checks as the chance of duplicate
			// names is nearly impossible
			if ($randomize_filename === true)
			{
				$new_basename = uniqid('', true).'.'.$old_pathinfo['extension'];
			}

			// Preserve the file name
			else
			{
				// If we're overwriting existing files
				if (array_get($config, 'override_existing', Config::get('platform/media::media.placement.override_existing', false)) === true)
				{
					$new_basename = $filename;
				}

				// If we're preserving existing files
				else
				{
					$x = 0;

					do
					{
						$separator = '';

						// Build a nice separator
						if ($x++ > 0)
						{
							$separator = array_get($config, 'override_separator', Config::get('platform/media::media.placement.override_separator')).$x;
						}

						$new_basename = pathinfo($filename, PATHINFO_FILENAME).$separator.'.'.pathinfo($filename, PATHINFO_EXTENSION);
					}
					while ($filesystem->file()->exists($new_directory.DS.$new_basename));
				}
			}
		}

		// Move the file
		if ( ! $filesystem->file()->rename($old_file, ($new_path = $new_directory.DS.$new_basename)))
		{
			throw new ProcessorException("Filesystem failed to move file from [$old_file] to [$new_path]");
		}

		// Grab info based on the new file
		$new_pathinfo = pathinfo($new_basename);

		// Return some interesting information
		$info = array(
			// 'full_path'      => $new_path,
			// 'dispersion'     => $dispersion,
			// 'extension'      => $extension,
			// 'name'           => $filename,
			'file_path'      => $file_path,
			'file_name'      => $new_pathinfo['filename'],
			'file_extension' => $new_pathinfo['extension'],
			'mime'           => File::mime($new_pathinfo['extension']),
			'size'           => $filesystem->file()->size($new_path),
		);

		// Validate image
		if (File::is(array('jpg', 'png', 'gif', 'bmp'), $new_path) and $size = getimagesize($new_path))
		{
			$info['width']  = $size[0];
			$info['height'] = $size[1];
		}

		return $info;
	}

	/**
	 * Generates an array of uploaded file
	 * validation requirements based on configuration
	 * items. The reason we don't just put that validation
	 * information in the configuration file is simply because
	 * we need to extract values out of it to use on the
	 * frontend.
	 *
	 * @return  array
	 */
	public static function generate_validation_array()
	{
		// Validation rules
		$rules = Config::get('platform/media::media.validation', array());

		array_walk($rules, function(&$values, $rule)
		{
			$values = $rule.':'.implode(',', (array) $values);
		});

		return array_values($rules);
	}

	/**
	 * Generates a string of uploaded file
	 * validation requirements based on configuration
	 * items. The reason we don't just put that validation
	 * information in the configuration file is simply because
	 * we need to extract values out of it to use on the
	 * frontend.
	 *
	 * @return  string
	 */
	public static function generate_validation_string()
	{
		return (($string_parts = static::generate_validation_array()) and ! empty($string_parts)) ? implode('|', $string_parts) : false;
	}

}
