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
	 * Flag for whether the extension has been started.
	 *
	 * @var bool
	 */
	protected $started = false;

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
	 * The autoloader associated with the extension.
	 *
	 * @var Composer\Autoload\ClassLoader
	 */
	protected $autoloader;

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
	 * Starts the extension.
	 *
	 * @return void
	 */
	public function start()
	{
		if ( ! $this->isEnabled())
		{
			throw new \RuntimeException("Cannot start Extension [{$this->slug}] because it is not enabled.");
		}

		// Check we haven't already tried to start
		// the extension
		if ($this->started)
		{
			return;
		}

		// Prepare the extension for autoloading
		$this->prepareAutoloading();

		// Very simple to start an extension now. Extension
		// files are always autoloaded (because of Composer)
		// so we don't need to register anything. We simply need
		// to call the start method.
		if (isset($this->start) and $this->start instanceof Closure)
		{
			call_user_func_array($this->start, array($this));
		}

		// @todo, allow a hook system so people can register
		// handlers for extension attributes. Example, the settings
		// extension will want to handle the 'settings' key for
		// every extension.php file.

		// We've started the extension
		$this->started = true;
	}

	/**
	 * Prepares the extension for autoloading, by either 
	 */
	public function prepareAutoloading()
	{
		// Either no autoloading (maybe not an extension that
		// has a file precense?) or autoloading is taken care
		// of by Composer, we won't touch it.
		if ( ! isset($this->autoload) or $this->autoload === 'composer')
		{
			return;
		}

		// Create an autoloader object
		$autoloader = new ClassLoader;

		// Platform default autoloading
		if ($this->autoload === 'platform')
		{
			$this->registerPlatformAutoloading($autoloader);
		}

		// Custom autoloading logic
		elseif ($this->autoload instanceof closure)
		{
			call_user_func_array($this->autoload, array($autoloader, $this));
		}

		// Activate the autoloader
		$autoloader->register();

		// To enable searching the include path (eg. for PEAR packages)
		$autoloader->setUseIncludePath(true);

		// Set the autoloader for the Extension
		$this->setAutoloader($autoloader);
	}

	/**
	 * Register the default autoloading logic for this
	 * Extension as determined by Platform convention.
	 *
	 * @param  Composer\Autoload\ClassLoader  $autoloader
	 * @return void
	 */
	public function registerPlatformAutoloading(ClassLoader $loader)
	{
		// Check we actually have a file presence
		if ( ! $this->filePresence)
		{
			throw new \RuntimeException("Default Platform autoloading for an extension requires that extension has a File Presence, none found for [{$this->slug}].");
		}

		// Let's create the default namespace, which is just
		// an inversion of the slug
		$namespace = str_replace(' ', '\\', ucwords(str_replace('/', ' ', $this->slug)));

		// First thing, let's add the 'models' directory
		$loader->add($namespace, $this->filePresence->directory.'/models');

		// We can't really do a simple classmap easily. That involves
		// a lot of code, which is SLOW! If you aren't using composer,
		// you can use PSR-0 to load classes. See
		// https://github.com/composer/composer/blob/master/src/Composer/Autoload/ClassMapGenerator.php
		// Alternatively, if the person wants to include PSR fallbacks
		// with actual manual classmaps, they can do it in their callback
		// as this model instance is provided to that closure:
		//
		// 'autoload' => function($loader, $extension)
		// {
		//  	$extension->registerPlatformAutoloading($loader);
		//  
		//  	$loader->map(array(
		//  		'FooBarRoofl' => __DIR__.'/some/weird/classmap.php',
		//  	));
		// },
		$loader->add($namespace, $this->directory.'/controllers');

		dd($loader);
	}

	/**
	 * Prepares an extension for migrations. Basically, just registers
	 * the "package" that matches this' slug with Laravel. Is done typically
	 * when installing Laravel and when running on CLI. This means migrations
	 * can be made for a particular extension.
	 *
	 * @return  void
	 */
	public function prepareForMigrations()
	{
		// If there is no migrations path for the extension, we may as well
		// save on overhead.
		if ( ! file_exists($migrationsPath = $this->getMigrationsPath()))
		{
			return;
		}

		// Grab config instance
		$config = $this->app['config'];

		// Grab the original config paths
		$paths = $config->get('database.migration.paths');

		// When we merge, we merge our paths in first. This allows
		// the user to overide our migration paths easily for whatever
		// reason.
		$paths = array_merge(array(
			$this->slug => $migrationsPath
		), $paths);

		$config->set('database.migration.paths', $paths);
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
	 * Sets the autoloader associated with this extension.
	 *
	 * @param  Composer\Autoload\ClassLoader  $autoloader
	 * @return void
	 */
	public function setAutoloader(ClassLoader $autoloader)
	{
		$this->autoloader = $autoloader;
	}

	/**
	 * Gets the autoloader associated with this extension.
	 *
	 * @return Composer\Autoload\ClassLoader
	 */
	public function getAutoloader()
	{
		return $this->autoloader;
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
	 * Returns if an attribute is set or not.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function attributeIsset($key)
	{
		if (isset($this->attribute))
		{
			return true;
		}

		// Check our file presence for the attribute.
		if ($this->filePresence and isset($this->filePresence->$key))
		{
			return true;
		}

		// Now, we'll check our database presence to see if
		// the attribute is present there.
		if ($this->databasePresence and isset($this->databasePresence->$key))
		{
			return true;
		}

		return true;
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
		return $this->attributeIsset($key);
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
		return $this->attributeIsset($key);
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