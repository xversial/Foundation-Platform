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
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Events\Dispatcher as EventsDispatcher;

class ExtensionBag implements ArrayAccess {

	/**
	 * The extensions contained in the collection.
	 *
	 * @var array
	 */
	protected $extensions;

	/**
	 * The default extensions path.
	 *
	 * @var string
	 */
	protected $defaultPath;

	/**
	 * Array of additional extension paths to search
	 * for extensions in.
	 *
	 * @var array
	 */
	protected $additionalPaths = array();

	/**
	 * The extension's validation factory object.
	 *
	 * @var Illuminate\Validation\Factory
	 */
	protected $validation;

	/**
	 * Create a new ExtensionBag.
	 *
	 * @param  array   $extensions
	 * @param  string  $defaultPath
	 * @return void
	 */
	public function __construct(array $extensions = array(), $defaultPath, ValidationFactory $validation, EventsDispatcher $eventsDispatcher)
	{
		$this->extensions       = $extensions;
		$this->defaultPath      = $defaultPath;
		$this->validation       = $validation;
		$this->eventsDispatcher = $eventsDispatcher;
	}

	/**
	 * Adds all extensions automatically, thus saving
	 * you registering them manually. You can even add
	 * extensions at any given path, or just use the
	 * default path provided.
	 *
	 * @param  string|array  $paths
	 * @return void
	 */
	public function addAllExtensions($paths = null)
	{
		// Find all extension database presence's
		$databasePrecenses = DatabasePresence::all();

		// Loop through all files found and create extension
		// instances from each one
		foreach ($this->findExtensionsFiles($paths) as $file)
		{
			// Create an extension with a file presence
			$extension = new Extension($this->validation);
			$extension->setFilePresence(new FilePresence($file));

			// Now, loop through database presences
			foreach ($databasePrecenses as $presence)
			{
				// If we have a match, break our loop
				if ($presence->slug === $extension->slug)
				{
					$extension->setDatabasePresence($presence);
					break;
				}
			}

			// Lastly, add the extension to this bag
			$this->add($extension);
		}
	}

	/**
	 * Starts all of the extensions registered with the
	 * ExtensionBag.
	 *
	 * @return void
	 */
	public function startExtensions()
	{
		foreach ($this->allEnabled() as $extension)
		{
			$extension->start();
		}
	}

	/**
	 * Returns all core extensions that have been added
	 * to the Extensions Bag.
	 *
	 * @return  array
	 */
	public function allCore()
	{
		return array_filter($this->all(), function(Extension $extension)
		{
			return (bool) $extension->is_core;
		});
	}

	/**
	 * Returns all installed extensions that have been added
	 * to the Extensions Bag.
	 *
	 * @return  array
	 */
	public function allInstalled()
	{
		return array_filter($this->all(), function(Extension $extension)
		{
			return $extension->isInstalled();
		});
	}

	/**
	 * Returns all enabled extensions that have been added
	 * to the Extensions Bag.
	 *
	 * @return  array
	 */
	public function allEnabled()
	{
		return array_filter($this->allInstalled(), function(Extension $extension)
		{
			return $extension->isEnabled();
		});
	}

	/**
	 * Returns all enabled extensions that have been added
	 * to the Extensions Bag.
	 *
	 * @return  array
	 */
	public function allDisabled()
	{
		return array_filter($this->allInstalled(), function(Extension $extension)
		{
			return $extension->isDisabled();
		});
	}

	/**
	 * Returns all installed extensions that have been added
	 * to the Extensions Bag.
	 *
	 * @return  array
	 */
	public function findAllDisabledExtensions()
	{
		return array_filter($this->addAllExtensions(), function(Extension $extension)
		{
			if ( ! $extension->getDatabaseStore())
			{
				return false;
			}

			return ( ! (bool) $extension->getDatabaseStore()->enabled);
		});
	}

	/**
	 * Searches for all extension files within the provided extensions paths.
	 *
	 * @param   array|string  $paths
	 * @return  array
	 */
	public function findExtensionsFiles($paths = null)
	{
		// Fallback files array
		$files = array();

		// Loop through paths and try find files
		foreach ($this->preparePaths($paths) as $path)
		{
			$files = array_merge($files, $this->globPathForFiles($path));
		}

		return $files;
	}

	/**
	 * Adds an additional extensions path to the extensions bag.
	 * This will be searched when adding all extensions and can
	 * be used to find an extension file
	 *
	 * @param   array|string  $paths
	 * @return  array
	 */
	public function addPath($path)
	{
		if ($path === $this->defaultPath)
		{
			throw new \UnexpectedValueException('Cannot overwrite default extension path.');
		}

		$this->additionalPaths[] = $path;
	}

	/**
	 * Returns all additional extensions paths
	 *
	 * @param   array|string  $paths
	 * @return  array
	 */
	public function getAdditionalPaths()
	{
		return $this->additionalPaths;
	}

	/**
	 * Returns a combination of the default extensions path
	 * with all additional extensions paths
	 *
	 * @param   array|string  $paths
	 * @return  array
	 */
	public function getAllPaths()
	{
		return array_merge(array($this->defaultPath), $this->additionalPaths);
	}

	/**
	 * Returns a string / array representation of extensions paths
	 * into an array.
	 *
	 * @param   array|string  $paths
	 * @return  array
	 */
	protected function preparePaths($paths = null)
	{
		// If we have a custom extension paths array passed
		if ($paths !== null)
		{
			// We'll take a string, but make it an array
			if (is_string($paths))
			{
				$paths = array($paths);
			}

			// If it's not an array, no good.
			elseif ( ! is_array($paths))
			{
				throw new \UnexpectedValueException('Extension paths provided must be an array or string.');
			}
		}

		// Using default?
		else
		{
			$paths = $this->getAllPaths();
		}

		return $paths;
	}

	/**
	 * Looks for extension.php file(s) within the given extensions
	 * path. If an extension is provided, only the corresponding
	 * extension.php file is returned.
	 *
	 * @param   array|string  $path
	 * @param   string  $extension
	 * @return  array
	 */
	protected function globPathForFiles($path, $extension = null)
	{
		// Now, let's look within two folders relative to
		// the extensions path. This will account for the
		// :vendor/:extension/ folder setup.
		$extensionPattern = ($extension !== null) ? $extension : '*/*';
		$pattern          = "$path/$extensionPattern/extension.php";
		return (array) glob($pattern);
	}

	/**
	 * Add an extension to the collection.
	 *
	 * @param  mixed  $extension
	 * @return void
	 */
	public function add(Extension $extension)
	{
		$this->extensions[$extension->slug] = $extension;
	}

	/**
	 * Get the first extension from the collection.
	 *
	 * @return mixed|null
	 */
	public function first()
	{
		return count($this->extensions) > 0 ? reset($this->extensions) : null;
	}

	/**
	 * Get all of the extensions in the collection.
	 *
	 * @return array
	 */
	public function all()
	{
		return $this->extensions;
	}

	/**
	 * Determine if the collection is empty or not.
	 *
	 * @return bool
	 */
	public function isEmpty()
	{
		return empty($this->extensions);
	}


	/**
	 * Get an iterator for the extensions.
	 *
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->extensions);
	}

	/**
	 * Count the number of extensions in the collection.
	 *
	 * @return int
	 */
	public function count()
	{
		return count($this->extensions);
	}

	/**
	 * Determine if an extension exists at an offset.
	 *
	 * @param  mixed  $slug
	 * @return bool
	 */
	public function offsetExists($slug)
	{
		return array_key_exists($slug, $this->extensions);
	}

	/**
	 * Get an extension at a given offset.
	 *
	 * @param  mixed  $slug
	 * @return mixed
	 */
	public function offsetGet($slug)
	{
		return $this->extensions[$slug];
	}

	/**
	 * Set the extension at a given offset.
	 *
	 * @param  mixed  $slug
	 * @param  mixed  $value
	 * @return void
	 */
	public function offsetSet($slug, $value)
	{
		$this->extensions[$slug] = $value;
	}

	/**
	 * Unset the extension at a given offset.
	 *
	 * @param  string  $slug
	 * @return void
	 */
	public function offsetUnset($slug)
	{
		unset($this->extensions[$slug]);
	}
}