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
 * @version    1.1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */


/*
 * --------------------------------------------------------------------------
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use Laravel\CLI\Command;


/**
 * --------------------------------------------------------------------------
 * Extensions Manager Class
 * --------------------------------------------------------------------------
 *
 * A class to manage our extensions.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.2
 */
class ExtensionsManager
{
    /**
     * Default vendor name.
     *
     * @constant
     */
    const DEFAULT_VENDOR = 'default';

    /**
     * Default core vendor name.
     *
     * @constant
     */
    const CORE_VENDOR = 'platform';

    /**
     * Vendor separator
     *
     * @constant
     */
    const VENDOR_SEPARATOR = '/';

    /**
     * Array of vendors extensions directories.
     *
     * @access   protected
     * @var      array
     */
    protected $vendors_directories = array();

    /**
     * Array of default extensions directories.
     *
     * @access   protected
     * @var      array
     */
    protected $default_directories = array();

    /**
     * Stores all the extensions.
     *
     * @access   protected
     * @var      array
     */
    protected $extensions = array();

    /**
     * Stores all the installed extensions.
     *
     * @access   protected
     * @var      object
     */
    protected $installed = array();

    /**
     * Stores all the uninstalled extensions.
     *
     * @access   protected
     * @var      array
     */
    protected $uninstalled = array();

    /**
     * Stores all the enabled extensions.
     *
     * @access   protected
     * @var      array
     */
    protected $enabled = array();

    /**
     * Stores all the disabled extensions.
     *
     * @access   protected
     * @var      array
     */
    protected $disabled = array();

    /**
     * Stores each extension dependencies.
     *
     * @access   protected
     * @var      array
     */
    protected $dependencies = array();

    /**
     * Stores each extension dependents.
     *
     * @access   protected
     * @var      array
     */
    protected $dependents = array();

    /**
     * Flag for whether we're running installer mode or not.
     *
     * Installer mode gives more privileges. 
     *
     * @access   protected
     * @var      boolean
     */
    protected $installer_mode = false;


    /**
     * --------------------------------------------------------------------------
     * Function: start_extensions()
     * --------------------------------------------------------------------------
     *
     * Initiate all the installed and enabled extensions.
     *
     * @access   public
     * @return   void
     */
    public function start_extensions()
    {
        // Get all the extensions.
        //
        $this->extensions();

        // Flattened extensions
        $extensions_flat = array();

        // Now get the enabled extensions, and start them !
        //
        foreach ($this->enabled() as $extensions)
        {
            foreach ($extensions as $extension)
            {
                // Core platform extensions
                if (array_get($extension, 'info.vendor') === self::CORE_VENDOR)
                {
                    $extensions_flat[array_get($extension, 'info.slug')] = $extension;
                    continue;
                }

                // Loop through this vendor extensions.
                //
                $extensions_flat[array_get($extension, 'info.slug')] = $extension;
            }
        }

        // Dependency sort based on the 'extends' key
        // of an extension
        //
        $sorted_slugs = Dependencies::sort($extensions_flat, 'extends');

        // The slugs are currently in order from most
        // extended to least extended. Let's reverse that.
        //
        $sorted_slugs = array_reverse($sorted_slugs);

        // Start extensions by their sorted dependencies
        foreach ($sorted_slugs as $slug)
        {
            // Check if the extension was started with success.
            //
            if ( ! $this->start(array_get(($extension = $extensions_flat[$slug]), 'info.slug')))
            {
                // Set the warning message.
                //
                Platform::messages()->warning(Lang::line('extensions.missing_files', array('extension' => array_get($extension, 'info.slug'))));
            }
        }
    }


    /**
     * --------------------------------------------------------------------------
     * Function: start()
     * --------------------------------------------------------------------------
     *
     * Start's an extension by the given slug.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function start($slug)
    {
        // Get this extension information.
        //
        $extension = $this->get($slug);
 
        // Start the bundle.
        //
        $this->start_bundle($extension);

        // Register this extension routes.
        //
        if ($routes = array_get($extension, 'routes'))
        {
            // Check if we've been given a closure.
            //
            if ( ! $routes instanceof Closure)
            {
                throw new Exception(Lang::line('extensions.invalid_routes', array('extension' => $slug)));
            }

            // Register the routes.
            //
            $routes();
        }

        // Register this extension listeners.
        //
        if ($listeners = array_get($extension, 'listeners'))
        {
            // Check if we've been given a closure.
            //
            if ( ! $listeners instanceof Closure)
            {
                throw new Exception(Lang::line('extensions.invalid_listeners', array('extension' => $slug)));
            }

            // Register the listeners.
            //
            $listeners();
        }

        // The extension has been started.
        //
        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: extensions()
     * --------------------------------------------------------------------------
     *
     * Returns all the extensions, both installed and uninstalled.
     *
     * @access   public
     * @return   array
     */
    public function extensions()
    {
        // Get the installed extensions.
        //
        $this->installed();

        // Do we have the extensions loaded already ?
        //
        if (empty($this->extensions))
        {
            // Loop through the extensions directories.
            //
            foreach ($this->directories() as $extension)
            {
                // Store the extension.
                //
                array_set($this->extensions, $extension, $this->get($this->reverse_slug($extension)));
            }

            // Sort the extensions.
            //
            ksort($this->extensions);

            // Sort the vendors.
            //
            array_walk($this->extensions, function(&$vendor)
            {
                ksort($vendor);
            });
        }

        // Return the extensions.
        //
        return $this->extensions;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: installed()
     * --------------------------------------------------------------------------
     *
     * Returns all the installed extensions, both enabled and disabled.
     *
     * @access   public
     * @return   array
     */
    public function installed()
    {
        // Do we have the extensions loaded already ?
        //
        if (empty($this->installed))
        {
            // Loop through the installed extensions.
            //
            foreach (Extension::all() as $extension)
            {
                // Store the extension.
                //
                array_set($this->installed, $this->reverse_slug($extension->slug), 
                    array(
                        'info' => array(
                            'slug'       => $extension->slug,
                            'vendor'     => $extension->vendor ?: static::DEFAULT_VENDOR,
                            'extension'  => $extension->extension,
                            'is_enabled' => (bool) $extension->enabled,
                            'version'    => $extension->version
                        )
                    )
                );
            }

            // Sort the extensions.
            //
            ksort($this->installed);

            // Sort the vendors.
            //
            array_walk($this->installed, function(&$vendor)
            {
                ksort($vendor);
            });
        }

        // Return the extensions.
        //
        return $this->installed;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: uninstalled()
     * --------------------------------------------------------------------------
     *
     * Returns all the uninstalled extensions
     *
     * @access   public
     * @return   array
     */
    public function uninstalled()
    {
        // Do we have the extensions loaded already ?
        //
        if (empty($this->uninstalled))
        {
            // Get all the extensions.
            //
            foreach ($this->extensions() as $extensions)
            {
                // Loop through this vendor extensions.
                //
                foreach ($extensions as $extension)
                {
                    // Extension slug.
                    //
                    $slug = array_get($extension, 'info.slug');

                    // Is this extension uninstalled ?
                    //
                    if ($this->is_uninstalled($slug))
                    {
                        // Store the extension.
                        //
                        array_set($this->uninstalled, $slug, $this->get($slug));
                    }
                }
            }

            // Sort the extensions.
            //
            array_walk($this->uninstalled, function(&$extension)
            {
                ksort($extension);
            });
        }

        // Return the extensions.
        //
        return $this->uninstalled;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: enabled()
     * --------------------------------------------------------------------------
     *
     * Returns all the enabled extensions
     *
     * @access   public
     * @return   array
     */
    public function enabled()
    {
        // Do we have the extensions loaded already ?
        //
        if (empty($this->enabled))
        {
            // Get all the installed extensions.
            //
            foreach ($this->installed() as $vendor => $extensions)
            {
                // Loop through this vendor extensions.
                //
                foreach ($extensions as $extension)
                {
                    // Extension slug.
                    //
                    $slug = array_get($extension, 'info.slug');

                    // Is this extension enabled ?
                    //
                    if ($this->is_enabled($slug))
                    {
                        array_set($this->enabled, $this->reverse_slug($slug), $this->get($slug));
                    }
                }
            }

            // Sort the extensions.
            //
            array_walk($this->enabled, function(&$extension)
            {
                ksort($extension);
            });
        }

        // Return the extensions.
        //
        return $this->enabled;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: disabled()
     * --------------------------------------------------------------------------
     *
     * Returns all the disabled extensions
     *
     * @access   public
     * @return   array
     */
    public function disabled()
    {
        // Do we have the extensions loaded already ?
        //
        if (empty($this->disabled))
        {
            // Get all the installed extensions.
            //
            foreach ($this->installed() as $extensions)
            {
                // Loop through this vendor extensions.
                //
                foreach ($extensions as $extension)
                {
                    // Extension slug.
                    //
                    $slug = array_get($extension, 'info.slug');

                    // Is this extension disabled ?
                    //
                    if ($this->is_disabled($slug))
                    {
                        array_set($this->disabled, $this->reverse_slug($slug), $extension);
                    }
                }
            }

            // Sort the extensions.
            //
            array_walk($this->disabled, function(&$extension){
                ksort($extension);
            });
        }

        // Return the extensions.
        //
        return $this->disabled;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: is_installed()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension is installed.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function is_installed($slug)
    {
        return (bool) array_get($this->installed, $this->reverse_slug($slug));
    }


    /**
     * --------------------------------------------------------------------------
     * Function: is_uninstalled()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension is uninstalled.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function is_uninstalled($slug)
    {
        return ( ! $this->is_installed($slug));
    }


    /**
     * --------------------------------------------------------------------------
     * Function: is_enabled()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension is enabled.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function is_enabled($slug)
    {
        return (bool) array_get($this->installed, $this->reverse_slug($slug) . '.info.is_enabled');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: is_disabled()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension is disabled.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function is_disabled($slug)
    {
        return ( ! $this->is_enabled($slug));
    }


    /**
     * --------------------------------------------------------------------------
     * Function: is_core()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension is a core extension.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function is_core($slug)
    {
        return (bool) array_get($this->extensions, $this->reverse_slug($slug) . '.info.is_core');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: is_core_vendor()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension is a core vendor extension.
     *
     * A core vendor is basically an extension that belongs to Platform vendor,
     * and is a core extension.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function is_core_vendor($slug)
    {
        return (bool) array_get($this->extensions, $this->reverse_slug($slug) . '.info.is_core') and ( array_get($this->extensions, $this->reverse_slug($slug) . '.info.vendor') == static::CORE_VENDOR);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: exists()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension exists.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function exists($slug)
    {
        return (bool) array_get($this->extensions, $this->reverse_slug($slug));
    }


    /**
     * --------------------------------------------------------------------------
     * Function: can_install()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension can be installed.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function can_install($slug)
    {
        // Is the installer mode on ?
        //
        if ($this->installer_mode())
        {
            // Extension can be installed.
            //
            return true;
        }

        // Check if this extension exists.
        //
        if ( ! $this->exists($slug))
        {
            return false;
        }

        // If the extension is already installed, we can't install it again, obviously !
        //
        if ($this->is_installed($slug))
        {
            // Extension can't be installed.
            //
            return false;
        }

        // Loop through this extension dependencies.
        //
        foreach ($this->dependencies($slug) as $dependent)
        {
            // If this dependent is uninstalled and/or disabled we can't install the extension.
            //
            if ($this->is_uninstalled($dependent) or $this->is_disabled($dependent))
            {
                // Extension can't be installed.
                //
                return false;
            }
        }

        // Extension can be installed.
        //
        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: can_uninstall()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension can be uninstalled.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function can_uninstall($slug)
    {
        // Is this a core extension ?
        //
        if ($this->is_core($slug))
        {
            // Extension can't be uninstalled.
            //
            return false;
        }

        // If the extension is not installed, we can't uninstall, obviously !
        //
        if ( ! $this->is_installed($slug))
        {
            // Extension can't be uninstalled.
            //
            return false;
        }

        // Loop through this extension dependents.
        //
        foreach ($this->dependents($slug) as $dependent)
        {
            // If this dependent is installed we can't uninstall the extension.
            //
            if ($this->is_installed($dependent))
            {
                // Extension can't be uninstalled.
                //
                return false;
            }
        }

        // Extension can be uninstalled.
        //
        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: can_enable()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension can be enabled.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function can_enable($slug)
    {
        // Is the installer mode on ?
        //
        if ($this->installer_mode())
        {
            // Extension can be installed.
            //
            return true;
        }

        // If the extension is not installed, we can't enable it, obviously !
        //
        if ( ! $this->is_installed($slug))
        {
            // Extension can't be uninstalled.
            //
            return false;
        }

        // If the extension is already enabled, we can't enable it again, obviously !
        //
        if ($this->is_enabled($slug))
        {
            // Extension can't be enabled.
            //
            return false;
        }

        // Loop through this extension dependencies.
        //
        foreach ($this->dependencies($slug) as $dependent)
        {
            // If this dependent is uninstalled and/or disable we can't enable the extension.
            //
            if ($this->is_uninstalled($dependent) or $this->is_disabled($dependent))
            {
                // Extension can't be enabled.
                //
                return false;
            }
        }

        // Extension can be enabled.
        //
        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: can_disable()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension can be disabled.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function can_disable($slug)
    {
        // Is this a core extension ?
        //
        if ($this->is_core($slug))
        {
            // Core extensions can't be disabled !
            //
            return false;
        }

        // If the extension is not enabled, we can't disable it, obviously !
        //
        if ( ! $this->is_enabled($slug))
        {
            // Extension can't be disabled.
            //
            return false;
        }

        // Loop through this extension dependents.
        //
        foreach ($this->dependents($slug) as $dependent)
        {
            // If this dependent is installed we can't disable the extension.
            //
            if ($this->is_installed($dependent))
            {
                // Extension can't be disabled.
                //
                return false;
            }
        }

        // Extension can be disabled.
        //
        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: has_update()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension has an update available.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function has_update($slug)
    {
        // Check if this extension is installed.
        //
        if ($this->is_installed($slug))
        {
            // Get the info from the extension.php file.
            //
            $extension = $this->get($slug);

            // Compare both versions, and return the result.
            //
            return ( version_compare(array_get($extension, 'info.version'), $this->current_version($slug)) > 0 );
        }

        // The extension is not installed.
        //
        return false;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: vendors()
     * --------------------------------------------------------------------------
     *
     * Returns the total of vendors an extension has.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function vendors($slug)
    {
        // Separate the vendor and the extension slug.
        //
        if (strpos($slug, '.'))
        {
            list($vendor, $slug) = explode('.', $slug);
        }

        // List of vendors.
        //
        return array_get($this->extensions, $slug, array());

        // Return the vendors if we did found any.
        //
        return ( count($vendors) > 1 ? $vendors : false );
    }


    /**
     * --------------------------------------------------------------------------
     * Function: dependencies()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension has dependencies.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function dependencies($slug)
    {
        return array_get($this->dependencies, $this->reverse_slug($slug), array());
    }


    /**
     * --------------------------------------------------------------------------
     * Function: dependents()
     * --------------------------------------------------------------------------
     *
     * Checks if an extension has dependents.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function dependents($slug)
    {
        return array_get($this->dependents, $this->reverse_slug($slug), array());
    }


    /**
     * --------------------------------------------------------------------------
     * Function: required_extensions()
     * --------------------------------------------------------------------------
     *
     * This returns all the required extensions that an extension needs to be installed.
     *
     * It checks if the dependent extensions are: ' Uninstalled or Disabled '
     *
     * If one of the checks returns TRUE, it means that the extension can't be installed.
     *
     * @access   public
     * @param    string
     * @return   array
     */
    public function required_extensions($slug)
    {
        // Get this extension dependencies.
        //
        if ( ! $dependencies = array_get($this->dependencies, $this->reverse_slug($slug)))
        {
            return array();
        }

        // Initiate an empty array.
        //
        $required = array();

        // Spin through this extension dependencies.
        //
        foreach ($dependencies as $dependent)
        {
            // Check if this dependent extensions is not installed or is disabled.
            //
            if ($this->is_uninstalled($dependent) or $this->is_disabled($dependent))
            {
                $required[ $dependent ] = $dependent;
            }
        }

        // Return the required extensions.
        //
        return $required;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: installer_mode()
     * --------------------------------------------------------------------------
     *
     * Sets the installer_mode property.
     *
     * @access   public
     * @return   void
     */
    public function installer_mode($installer_mode = null)
    {
        // If we don't want to touch the installer mode state.
        //
        if (is_null($installer_mode))
        {
            return $this->installer_mode;
        }

        // Set and return the installer mode state.
        //
        return $this->installer_mode = $installer_mode;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: current_version()
     * --------------------------------------------------------------------------
     *
     * Returns the current version of an extension.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function current_version($extension)
    {
        return array_get($this->installed, $this->reverse_slug($extension) . '.info.version');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: new_version()
     * --------------------------------------------------------------------------
     *
     * Returns the new version of an extension, if an update is available, otherwise,
     * returns the current version of the extension.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function new_version($extension)
    {
        // Check if this extension has an update available.
        //
        if ($this->has_update($extension))
        {
            return array_get($this->extensions, $this->reverse_slug($extension) . '.info.version');
        }

        // No update available, return the current version.
        //
        return $this->current_version($extension);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: install()
     * --------------------------------------------------------------------------
     *
     * Installs an extension by the given slug.
     *
     * As an optional parameter, you can also enable the extension automatically.
     *
     * @access   public
     * @param    string
     * @param    boolean
     * @return   boolean
     */
    public function install($slug, $enable = false)
    {
        // Check if this extension is already installed.
        //
        if (Extension::find($slug))
        {
            throw new Exception(Lang::line('extensions.install.installed', array('extension' => $slug))->get());
        }

        // Check if this extension can be installed.
        //
        if ( ! $this->can_install($slug))
        {
            throw new Exception(Lang::line('extensions.install.fail', array('extension' => $slug))->get());
        }

        // Get this extension information.
        //
        $extension = $this->get($slug);

        // If this extension has vendors. 
        //
        if ($vendors = $this->vendors($slug))
        {
            // Disable all other installed vendors of this extension.
            //
            DB::table('extensions')->where('extension', '=', array_get($extension, 'info.extension'))->update(array('enabled' => 0));

            // Make sure the extension get's enabled !
            //
            $enable = 1;
        }

        // Create the new vendor extension instance.
        //
        $model = new Extension(array(
            'slug'      => array_get($extension, 'info.slug'),
            'vendor'    => array_get($extension, 'info.vendor'),
            'extension' => array_get($extension, 'info.extension'),
            'version'   => array_get($extension, 'info.version'),
            'enabled'   => (int) ( $is_core = array_get($extension, 'info.is_core') ? 1 : $enable)
        ));
        $model->save();

        // Start the extension.
        //
        $this->start($slug);

        // Run this extension migrations.
        //
        Command::run(array('migrate', $this->bundleize($slug)));

        // Disable menus related to this extension, if the extension is disabled by default.
        //
        if ( ! $is_core and ! $enable)
        {
            try
            {
                $menus = API::get('menus/flat', array('extension' => $slug));
                foreach ($menus as $menu)
                {
                    API::put('menus/' . $menu['slug'], array('status' => 0));
                }
            }
            catch (APIClientException $e)
            {

            }
        }

        // Extension installed.
        //
        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: uninstall()
     * --------------------------------------------------------------------------
     *
     * Uninstalls an extension by the given slug.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function uninstall($slug)
    {
        // Check if this extension is installed.
        //
        if (is_null($model = Extension::find($slug)))
        {
            throw new Exception(Lang::line('extensions.not_found', array('extension' => $slug))->get());
        }

        // Check if this extension can be uninstalled.
        //
        if ( ! $this->can_uninstall($slug))
        {
            throw new Exception(Lang::line('extensions.uninstall.fail', array('extension' => $slug))->get());
        }

        // Get this extension information.
        //
        $extension = $this->get($slug);

        // If this extension has vendors. 
        //
        if ($vendors = $this->vendors($slug))
        {
            // Get this extension migration files.
            //
            $migrations = glob(path('extensions') . array_get($extension, 'info.vendor') . DS . array_get($extension, 'info.extension') . DS . 'migrations' . DS . '*');
            $migrations = array_reverse($migrations, true);

            // Loop through the migration files.
            //
            foreach($migrations as $migration)
            {
                // Include the migration file.
                //
                require_once $migration;

                // 
                //
                $migration = basename(str_replace(EXT, '', $migration));

                // 
                //
                DB::table('laravel_migrations')->where('name', '=', $migration)->delete();

                // Prepare the class name.
                //
                $class = Bundle::class_prefix(array_get($extension, 'info.slug')) . \Laravel\Str::classify(substr($migration, 18));

                // Change the vendor separator to a class separator
                $class = str_replace(self::VENDOR_SEPARATOR, '_', $class);

                // Initiate the migration class.
                //
                $migration = new $class;

                // Run down the migration.
                //
                $migration->down();
            }

            // Check if we have a core vendor.
            //
            if (array_key_exists(static::CORE_VENDOR, $vendors))
            {
                // Enable the core vendor extension.
                //
                DB::table('extensions')->where('vendor', '=', static::CORE_VENDOR)->update(array('enabled' => 1));
            }

            // No core vendor.
            //
            else
            {
                // Remove the current vendor from the list.
                //
                unset($vendors[$extension->vendor]);

                // Loop through the vendors till we find a valid one !
                //
                foreach ($vendors as $vendor => $info)
                {
                    // Check if this vendor is installed !
                    //
                    if ($this->is_installed(array_get($info, 'info.slug')))
                    {
                        // Enable this vendor.
                        //
                        DB::table('extensions')->where('vendor', '=', $vendor)->update(array('enabled' => 1));

                        // Break the loop !
                        //
                        break;
                    }
                }
            }
        }

        // No vendors.
        //
        else
        {
            // Start the extension so we can find it's bundle path.
            //
            $this->start($slug);

            // Get the migrations of this extension that were executed.
            //
            $migrations = DB::table('laravel_migrations')->where('bundle', '=', array_get($extension, 'info.extension'))->order_by('name', 'DESC')->get();

            // Loop through the installed migrations.
            //
            foreach ($migrations as $migration)
            {
                // Include the migration file.
                //
                require_once Bundle::path($slug) . 'migrations' . DS . $migration->name . EXT;

                // Prepare the class name.
                //
                $class = Bundle::class_prefix($slug) . \Laravel\Str::classify( substr( $migration->name, 18 ) );

                // Initiate the migration class.
                //
                $migration = new $class;

                // Run down the migration.
                //
                $migration->down();
            }

            // Remove the entry from the migrations table.
            //
            DB::table('laravel_migrations')->where('bundle', '=', $slug)->delete();
        }

        // Delete the extension reference from the database.
        //
        $model->delete();

        // Extension uninstalled.
        //
        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: enable()
     * --------------------------------------------------------------------------
     *
     * Enables an extension by the given slug.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function enable($slug)
    {
        // Check if the extension is installed !
        //
        if (is_null($extension = Extension::find($slug)))
        {
            throw new Exception(Lang::line('extensions.not_found', array('extension' => $slug))->get());
        }

        // Check if this extension can be enabled.
        //
        if ( ! $this->can_enable($slug))
        {
            throw new Exception(Lang::line('extensions.enable.fail', array('extension' => $slug))->get());
        }

        // If this extension has vendors. 
        //
        if ($this->vendors($slug))
        {
            // We need to make sure all other vendors are disabled.
            //
            DB::table('extensions')->where('extension', '=', $extension->extension)->update(array('enabled' => 0));
        }

        // Enable all menus related to this extension.
        //
        try
        {
            $menus = API::get('menus/flat', array('extension' => $slug));
            foreach ($menus as $menu)
            {
                API::put('menus/' . $menu['slug'], array('status' => 1));
            }
        }
        catch (APIClientException $e)
        {

        }

        // Enable the extension.
        //
        $extension->enabled = 1;
        $extension->save();

        // Extension enabled.
        //
        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: disable()
     * --------------------------------------------------------------------------
     *
     * Disables an extension by the given slug.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function disable($slug)
    {
        // Check if the extension is installed !
        //
        if (is_null($extension = Extension::find($slug)))
        {
            throw new Exception(Lang::line('extensions.not_found', array('extension' => $slug))->get());
        }

        // Check if this extension can be disabled.
        //
        if ( ! $this->can_disable($slug))
        {
            throw new Exception(Lang::line('extensions.disable.fail', array('extension' => $slug))->get());
        }

        // If this extension has vendors. 
        //
        if ($vendors = $this->vendors($slug))
        {
            // Check if we have a core vendor.
            //
            if (array_key_exists(static::CORE_VENDOR, $vendors))
            {
                // Enable the core vendor extension.
                //
                DB::table('extensions')->where('vendor', '=', static::CORE_VENDOR)->update(array('enabled' => 1));
            }

            // No core vendor.
            //
            else
            {
                // Remove the current vendor from the list.
                //
                unset($vendors[$extension->vendor]);

                // Loop through the vendors till we find a valid one !
                //
                foreach ($vendors as $vendor => $info)
                {
                    // Check if this vendor is installed !
                    //
                    if ($this->is_installed(array_get($info, 'info.slug')))
                    {
                        // Enable this vendor.
                        //
                        DB::table('extensions')->where('vendor', '=', $vendor)->update(array('enabled' => 1));

                        // Break the loop !
                        //
                        break;
                    }
                }
            }
        }

        // Disable all menus related to this extension.
        //
        try
        {
            $menus = API::get('menus/flat', array('extension' => $slug));
            foreach ($menus as $menu)
            {
                API::put('menus/' . $menu['slug'], array('status' => 0));
            }
        }
        catch (APIClientException $e)
        {

        }

        // Disable the extension.
        //
        $extension->enabled = 0;
        $extension->save();

        // Extension disabled.
        //
        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: update()
     * --------------------------------------------------------------------------
     *
     * Updates an extension by the given slug.
     *
     * @access   public
     * @param    string
     * @return   boolean
     */
    public function update($extension)
    {
        
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get()
     * --------------------------------------------------------------------------
     *
     * Retrieve all the needed information about an extension.
     *
     * @access   public
     * @param    mixed
     * @return   array
     */
    public function get($slug)
    {
        // Separate the vendor and extension from the slug.
        //
        list($vendor, $ext) = explode('.', $slug);

        // Check if the extension is already in the array.
        //
        if ( ! $extension = array_get($this->extensions, $this->reverse_slug($slug)))
        {
            // Check if the extension.php file of this extension exists.
            //
            if ( ! $file = $this->find_extension($slug))
            {
                return false;
            }

            // Read the extension.php file.
            //
            $extension = require $file;

            // Some requirements for the extension.php file.
            //
            if ( ! is_array($extension) or ! array_get($extension, 'info.name') or ! array_get($extension, 'info.version'))
            {
                throw new Exception(Lang::line('extensions.invalid_file', array('extension' => $extension_slug))->get());
            }
        
            // Combine the data.
            //
            $extension['info']['slug']         = $slug;
            $extension['info']['vendor']       = $vendor;
            $extension['info']['extension']    = $ext;
            $extension['info']['is_core']      = (bool) ( array_get($extension, 'info.is_core') ?: false );
            $extension['info']['is_enabled']   = $this->is_enabled($slug);
            $extension['info']['is_installed'] = $this->is_installed($slug);

            // Bundles array, so we can register the extension as a bundle in Laravel.
            //
            $extension['bundles'] = array(
                'handles'  => $ext,
                'location' => 'path: ' . dirname($file)
            );

            // Sort this extension info array.
            //
            ksort($extension);
            ksort($extension['info']);

            // Check if this extension has dependencies.
            //
            if ($dependencies = array_get($extension, 'dependencies'))
            {
                foreach ($dependencies as $dependent)
                {
                    // Get this dependent vendor and slug.
                    //
                    list($dep_vendor, $dep_slug) = explode('.', $dependent);

                    // Store both dependencies and dependents.
                    //
                    $this->dependencies[ $ext ][ $vendor ][] = $dependent;
                    $this->dependents[ $dep_slug ][ $dep_vendor ][] = $slug;
                }
            }
        }

        // Return the extension information.
        //
        return $extension;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: find_extension()
     * --------------------------------------------------------------------------
     *
     * Finds the extension.php file of an extension with the given slug.
     *
     * @access   protected
     * @param    string
     * @return   string
     */
    protected function find_extension($extension = null)
    {
        // Check if we have a slug.
        //
        if (is_null($extension))
        {
            return false;
        }

        // Get this extension slug and vendor.
        //
        list($vendor, $slug) = explode('.', $extension);

        // Make sure we have the right slug name.
        //
        $extension = ($vendor === self::DEFAULT_VENDOR ? $slug : $vendor . DS . $slug);

        // We'll search for the extension in the root dir first.
        //
        $file = glob(str_replace('/', DS, path('extensions') . $extension . DS . 'extension' . EXT));

        // Return the file path.
        //
        return ( ! empty($file) ? $file[0] : false );
    }


    /**
     * --------------------------------------------------------------------------
     * Function: extensions_directories()
     * --------------------------------------------------------------------------
     *
     * This returns all the extensions within the extensions directory.
     *
     * @access   protected
     * @return   array
     */
    protected function directories()
    {
        $self = $this;

        // Get the extensions separated by vendor.
        //
        if (empty($this->vendors_directories))
        {
            $this->vendors_directories = array_map(function($file) use ($self)
            {
                return $self->parse($file);
            }, (array) glob(path('extensions') . '*' . DS . '*' . DS . 'extension' . EXT, GLOB_NOSORT));
        }

        // Get the extensions that doesn't have a vendor.
        //
        if (empty($this->default_directories))
        {
            $this->default_directories = array_map(function($file) use ($self)
            {
                return $self->parse($file);
            }, (array) glob(path('extensions') . '*' . DS . 'extension' . EXT, GLOB_NOSORT));
        }

        // Merge the directories, and return them.
        //
        return array_merge($this->vendors_directories, $this->default_directories);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: parse()
     * --------------------------------------------------------------------------
     *
     * Converts a mixed extension variable into a formatted array.
     *
     * @access   protected
     * @param    mixed
     * @return   array
     */
    public function parse($extension)
    {
        // Lets separate the vendor and slug from the extension slug.
        //
        $extension = explode(DS, ltrim(str_replace(path('extensions'), null, dirname($extension)), DS));

        // Fallback array.
        //
        $output = array();

        // Do we have both vendor and slug ?
        //
        if (count($extension) === 2)
        {
            $output = array('slug' => $extension[1], 'vendor' => $extension[0]);
        }

        // Or do we have an extension without a vendor ?
        //
        elseif (count($extension) === 1)
        {
            $output = array('slug' => $extension[0], 'vendor' => static::DEFAULT_VENDOR);
        }

        // Make sure we have an array with data.
        //
        if (count($output) === 2)
        {
            // Return the extension slug, in reverse.
            //
            return implode('.', array($output['slug'], $output['vendor']));
        }

        // Looks like this is an invalid extension.
        //
        throw new Exception(Lang::line('extensions.invalid_extension'));
    }


    /**
     * --------------------------------------------------------------------------
     * Function: reverse_slug()
     * --------------------------------------------------------------------------
     *
     * Reverses the order of an extension slug.
     *
     * For example, we convert:   platform.dashboard   to   dashboard.platform
     *
     * @access   protected
     * @param    string
     * @return   string
     */
    protected function reverse_slug($slug)
    {
        // Make sure we have a vendor.
        //
        if (strpos($slug, '.'))
        {
            list($extension, $vendor) = explode('.', $slug);

            return $vendor . '.' . $extension;
        }

        // This extension doesn't have a vendor.
        //
        else
        {
            return self::DEFAULT_VENDOR . '.' . $slug;
        }
    }

    /**
     * --------------------------------------------------------------------------
     * Function: bundleize()
     * --------------------------------------------------------------------------
     *
     * Turns an extnesion slug into something that can be used by Laravel's
     * bundle system.
     *
     * @access   protected
     * @param    string
     * @return   string
     */
    protected function bundleize($slug)
    {
        return str_replace('.', self::VENDOR_SEPARATOR, $slug);
    }

    protected $started_handles = array();

    protected function allowed_handles($extension)
    {
        if ( ! in_array(($handle = array_get($extension, 'bundles.handles')), $this->started_handles))
        {
            return $this->started_handles[] = $handle;
        }

        return array_get($extension, 'info.slug');
    }

    /**
     * --------------------------------------------------------------------------
     * Function: start_bundle()
     * --------------------------------------------------------------------------
     *
     * Starts an extension on the Laravel Bundle level without starting it on the
     * platform level.
     *
     * @access   protected
     * @param    array
     * @return   boolean
     */
    protected function start_bundle($extension)
    {
        // Check if this extension is already started.
        //
        if (Bundle::started($slug = $this->bundleize(array_get($extension, 'info.slug'))))
        {
            return true;
        }

        $bundle_config = array_get($extension, 'bundles');
        $bundle_config['handles'] = $this->allowed_handles($extension);

        // Register this extension with Laravel.
        //
        Bundle::register($slug, $bundle_config);

        // Start the extension.
        //
        Bundle::start($slug);

        // Extension started with success.
        //
        return true;
    }
}
