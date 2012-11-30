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
use Closure;
use Composer\Autoload\ClassLoader;
use Illuminate\Validation\Factory as ValidationFactory;
use Symfony\Component\Console\Output\NullOutput;

class Extension implements ArrayAccess {

	/**
	 * The Extension's attributes.
	 *
	 * @var array
	 */
	protected $attributes = array();

	/**
	 * The extension's validation factory object.
	 *
	 * @var Illuminate\Validation\Factory
	 */
	protected $validation;

	/**
	 * The file presence for the extension.
	 *
	 * @var Platform\Extensions\FilePresence
	 */
	protected $filePresence;

	/**
	 * The database presence for the extension.
	 *
	 * @var Platform\Extensions\FilePresence
	 */
	protected $databasePresence;

	/**
	 * Create a new Platform extension instance.
	 *
	 * @param  Illuminate\Validation\Factory  $validation
	 * @return void
	 */
	public function __construct(ValidationFactory $validation)
	{
		$this->validation = $validation;
	}

	/**
	 * Set the database presence for the Extension.
	 *
	 * @param  Platform\Extensions\FilePresence  $filePresence
	 * @return void
	 */
	public function setFilePresence(FilePresence $filePresence)
	{
		$this->filePresence = $filePresence;
	}

	/**
	 * Get the database presence for the Extension.
	 *
	 * @return Platform\Extensions\FilePresence
	 */
	public function getFilePresence(FilePresence $filePresence)
	{
		return $this->filePresence;
	}

	/**
	 * Returns if the given extension is installed.
	 *
	 * @return bool
	 */
	public function isInstalled()
	{
		return (bool) $this->getDatabasePresence();
	}

	/**
	 * Returns if the given extension is uninstalled.
	 *
	 * @return bool
	 */
	public function isUninstalled()
	{
		return ( ! $this->isInstalled());
	}

	/**
	 * Returns if the given extension is installed and enabled.
	 *
	 * @return bool
	 */
	public function isEnabled()
	{
		if ( ! $this->isInstalled())
		{
			return false;
		}

		return (bool) $this->enabled;
	}

	/**
	 * Returns if the given extension is installed but disabled.
	 *
	 * @return bool
	 */
	public function isDisabled()
	{
		return ( ! $this->isEnabled());
	}

	/**
	 * Set the database presence for the Extension.
	 *
	 * @param  Platform\Extensions\DatabasePresence  $databasePresence
	 * @return void
	 */
	public function setDatabasePresence(DatabasePresence $databasePresence)
	{
		$this->databasePresence = $databasePresence;
	}

	/**
	 * Get the database presence for the Extension.
	 *
	 * @return Platform\Extensions\DatabasePresence
	 */
	public function getDatabasePresence()
	{
		return $this->databasePresence;
	}

	/**
	 * Get an attribute from the model.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function getAttribute($key)
	{
		// If the key references an attribute, we can just go ahead and return the
		// plain attribute value from the model. This allows every attribute to
		// be dynamically accessed through the _get method without accessors.
		if (array_key_exists($key, $this->attributes))
		{
			$value = $this->attributes[$key];

			if ($this->hasGetMutator($key))
			{
				return $this->{'get'.camel_case($key)}($value);
			}

			return $value;
		}

		// Check our file presence for the attribute.
		if ($this->filePresence and isset($this->filePresence->$key))
		{
			return $this->filePresence->$key;
		}

		// Now, we'll check our database presence to see if
		// the attribute is present there.
		if ($this->databasePresence and isset($this->databasePresence->$key))
		{
			return $this->databasePresence->$key;
		}
	}

	/**
	 * Set a given attribute on the model.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function setAttribute($key, $value)
	{
		$this->attributes[$key] = $value;
	}

	/**
	 * Determine if a get mutator exists for an attribute.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function hasGetMutator($key)
	{
		return method_exists($this, 'get'.camel_case($key));
	}

	/**
	 * Determine if an extension exists at an offset.
	 *
	 * @param  mixed  $key
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return isset($this->attributes[$key]);
	}

	/**
	 * Get an extension at a given offset.
	 *
	 * @param  mixed  $key
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->getAttribute($key);
	}

	/**
	 * Set the extension at a given offset.
	 *
	 * @param  mixed  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function offsetSet($key, $value)
	{
		$this->setAttribute($key, $value);
	}

	/**
	 * Unset the extension at a given offset.
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
		return $this->getAttribute($key);
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
		$this->setAttribute($key, $value);
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