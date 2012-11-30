<?php namespace Platform\Extensions;
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
 * @version    2.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2013, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use ArrayAccess;

class FilePresence implements ArrayAccess {

	/**
	 * The File Presence's attributes.
	 *
	 * @var array
	 */
	protected $attributes = array();

	/**
	 * The directory for this file presence.
	 *
	 * @var string
	 */
	public $directory;

	/**
	 * The actual file path for this file presence.
	 *
	 * @var string
	 */
	public $file;

	public function __construct($file)
	{
		$this->file      = $file;
		$this->directory = dirname($file);
		$this->updateFromFile();
	}

	/**
	 * Updates the file presence from the file.
	 *
	 * @return void
	 */
	public function updateFromFile()
	{
		if ( ! file_exists($this->file))
		{
			throw new \RuntimeException("File does not exist at path [{$this->file}].");
		}

		if ( ! is_readable($this->file))
		{
			throw new \RuntimeException("File is not readable at path [{$this->file}].");
		}

		foreach (require $this->file as $key => $value)
		{
			$this->$key = $value;
		}
	}

	/**
	 * Determine if an attribute exists at an offset.
	 *
	 * @param  mixed  $key
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return array_key_exists($key, $this->attributes);
	}

	/**
	 * Get an attribute at a given offset.
	 *
	 * @param  mixed  $key
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->attributes[$key];
	}

	/**
	 * Set the attribute at a given offset.
	 *
	 * @param  mixed  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function offsetSet($key, $value)
	{
		$this->attributes[$key] = $value;
	}

	/**
	 * Unset the attribute at a given offset.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function offsetUnset($key)
	{
		unset($this->attributes[$key]);
	}

	/**
	 * Dynamically retrieve attributes on the model.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function __get($key)
	{
		return $this->attributes[$key];
	}

	/**
	 * Dynamically set attributes on the model.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function __set($key, $value)
	{
		$this->attributes[$key] = $value;
	}

	/**
	 * Determine if an attribute exists on the model.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function __isset($key)
	{
		return isset($this->attributes[$key]);
	}

	/**
	 * Unset an attribute on the model.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function __unset($key)
	{
		unset($this->attributes[$key]);
	}
}