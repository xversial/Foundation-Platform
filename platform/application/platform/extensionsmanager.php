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
    # DONE !
    public function start_extensions()
    {
        // Get all the extensions.
        //
        $this->all();

        // Initiate the enabled extensions only !
        //
        foreach ($this->enabled() as $extension)
        {
            // Check if the extension was started with success.
            //
            if( ! $this->start(array_get($extension, 'info.slug')))
            {
                // Set the warning message.
                //
                Platform::messages()->warning(Lang::line('extensions.missing_files', array('extension' => array_get($extension, 'info.slug'))));
            }
        }

        ################################################################
        #echo '<pre>'; var_dump( $this->all() ); echo '</pre>'; die;
        ################################################################
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
    # DONE !
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
     * Function: all()
     * --------------------------------------------------------------------------
     *
     * Returns all the extensions, both installed and uninstalled.
     *
     * @access   public
     * @return   array
     */
    # FIXED !
    public function all()
    {
        // Get the installed extensions.
        //
        $this->installed = $this->installed();

        // Do we have the extensions loaded already ?
        //
        if (empty($this->extensions))
        {
            // Loop through the extensions directories.
            //
            foreach ($this->extensions_directories() as $directory)
            {
                // Resolve this extension directory.
                //
                $extension = $this->resolve_extension_directory($directory);

                // Get the extension slug and vendor.
                //
                $slug   = $extension['slug'];
                $vendor = $extension['vendor'];

                // Store the extension.
                //
                array_set($this->extensions, $slug . '.' . $vendor, $this->get($extension));
            }

            // Sort the extensions.
            //
            array_walk($this->extensions, function(&$extension)
            {
                ksort($extension);
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
    # FIXED !
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
                // Determine this extension vendor name.
                //
                $vendor = $extension->vendor ?: self::DEFAULT_VENDOR;

                // Store the extension.
                //
                array_set($this->installed, $vendor . '.' . $extension->slug, 
                    array(
                        'info' => array(
                            'slug'       => $vendor . '.' . $extension->slug,
                            'vendor'     => $vendor,
                            'extension'  => $extension->slug,
                            'is_enabled' => (bool) $extension->enabled,
                            'version'    => $extension->version
                        )
                    )
                );
            }

            // Sort the extensions.
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
    # DONE !
    public function uninstalled()
    {
        // Do we have the extensions loaded already ?
        //
        if (empty($this->uninstalled))
        {
            // Initiate an empty array.
            //
            $extensions = array();

            // Get all the extensions.
            //
            foreach ($this->extensions as $slug => $vendors)
            {
                // Loop through this vendor extensions.
                //
                foreach ($vendors as $vendor => $extension)
                {
                    // Is this extension uninstalled ?
                    //
                    if ($this->is_uninstalled(array_get($extension, 'info.slug')))
                    {
                        array_set($this->uninstalled, $this->convert_slug(array_get($extension, 'info.slug')), $extension);
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

        // Store and return the extensions.
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
    # FIXED !
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
                foreach ($extensions as $slug => $extension)
                {
                    // Is this extension enabled ?
                    //
                    if ($this->is_enabled(array_get($extension, 'info.slug')))
                    {
                        array_set($this->enabled, array_get($extension, 'info.extension'), $this->get(array_get($extension, 'info.slug')));
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
    # DONE !
    public function disabled()
    {
        // Do we have the extensions loaded already ?
        //
        if (empty($this->disabled))
        {
            // Get all the installed extensions.
            //
            foreach ($this->installed() as $vendor => $extensions)
            {
                // Loop through this vendor extensions.
                //
                foreach ($extensions as $slug => $extension)
                {
                    // Is this extension disabled ?
                    //
                    if ($this->is_disabled(array_get($extension, 'info.slug')))
                    {
                        array_set($this->disabled, array_get($extension, 'info.extension'), $extension);
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
    # DONE !
    public function is_installed($extension)
    {
        return (bool) array_get($this->installed, $extension);
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
    # DONE !
    public function is_uninstalled($extension)
    {
        return ( ! $this->is_installed($extension));
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
    # DONE !
    public function is_enabled($extension)
    {
        return (bool) array_get($this->installed, $extension . '.info.is_enabled');
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
    # DONE !
    public function is_disabled($extension)
    {
        return ( ! $this->is_enabled($extension));
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
    # DONE !
    public function is_core($extension)
    {
        return (bool) array_get($this->extensions, $this->convert_slug($extension) . '.info.is_core');
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
    # DONE !
    public function is_core_vendor($extension)
    {
        return (bool) array_get($this->extensions, $this->convert_slug($extension) . '.info.is_core') and ( array_get($this->extensions, $this->convert_slug($extension) . '.info.vendor') == static::CORE_VENDOR);
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
    # DONE !
    public function exists($extension)
    {
        return (bool) array_get($this->extensions, $this->convert_slug($extension));
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
    # DONE !
    public function can_install($extension)
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
        if ( ! $this->exists($extension))
        {
            return false;
        }

        // If the extension is already installed, we can't install it again, obviously !
        //
        if ($this->is_installed($extension))
        {
            // Extension can't be installed.
            //
            return false;
        }

        // Loop through this extension dependencies.
        //
        foreach ($this->dependencies($extension) as $dependent)
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
    # DONE !
    public function can_uninstall($extension)
    {
        // Is this a core extension ?
        //
        if ($this->is_core($extension))
        {
            // Extension can't be uninstalled.
            //
            return false;
        }

        // If the extension is not installed, we can't uninstall, obviously !
        //
        if ( ! $this->is_installed($extension))
        {
            // Extension can't be uninstalled.
            //
            return false;
        }

        // Loop through this extension dependents.
        //
        foreach ($this->dependents($extension) as $dependent)
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
    # DONE !
    public function can_enable($extension)
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
        if ( ! $this->is_installed($extension))
        {
            // Extension can't be uninstalled.
            //
            return false;
        }

        // If the extension is already enabled, we can't enable it again, obviously !
        //
        if ($this->is_enabled($extension))
        {
            // Extension can't be enabled.
            //
            return false;
        }

        // Loop through this extension dependencies.
        //
        foreach ($this->dependencies($extension) as $dependent)
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
    # DONE !
    public function can_disable($extension)
    {
        // Is this a core extension ?
        //
        if ($this->is_core($extension))
        {
            // Core extensions can't be disabled !
            //
            return false;
        }

        // If the extension is not enabled, we can't disable it, obviously !
        //
        if ( ! $this->is_enabled($extension))
        {
            // Extension can't be disabled.
            //
            return false;
        }

        // Loop through this extension dependents.
        //
        foreach ($this->dependents($extension) as $dependent)
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
    # DONE !
    public function has_update($slug = null)
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
     * Function: has_vendors()
     * --------------------------------------------------------------------------
     *
     * Returns the total of vendors an extension has.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    # DONE !
    public function has_vendors($extension)
    {
        // Count how many vendors an extension has.
        //
        $vendors = count(array_get($this->extensions, $extension));

        // Return the total of vendors.
        //
        return ( $vendors > 1 ? $vendors : false );
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
    # DONE !
    public function dependencies($extension)
    {
        return array_get($this->dependencies, $extension, array());
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
    # DONE !
    public function dependents($extension)
    {
        return array_get($this->dependents, $extension, array());
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
    # DONE !
    public function required_extensions($slug = null)
    {
        // Get this extension dependencies.
        //
        if ( ! $dependencies = array_get($this->dependencies, $slug))
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
    # DONE !
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
    # DONE !
    public function current_version($extension)
    {
        return array_get($this->installed, $extension . '.info.version');
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
    # DONE !
    public function new_version($extension)
    {
        // Check if this extension has an update available.
        //
        if ($this->has_update($extension))
        {
            return array_get($this->extensions, $this->convert_slug($extension) . '.info.version');
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
        if ($this->has_vendors(array_get($extension, 'info.extension')))
        {
            /*
             *
             * Actually we need to disable all the vendor extensions available !
             *
             * Change the code above later !!!
             *
             */


            // Make sure we disable the core extension, if we have a core extension !
            //
            if($model = Extension::find('platform.' . array_get($extension, 'info.extension')))
            {
                $model->enabled = 0;
                $model->save();
            }

            // Make sure the extension get's enabled !
            //
            $enable = 1;
        }

        // Create the new vendor extension instance.
        //
        $model = new Extension(array(
            'vendor'  => array_get($extension, 'info.vendor'),
            'slug'    => array_get($extension, 'info.extension'),
            'version' => array_get($extension, 'info.version'),
            'enabled' => (int) ( $is_core = array_get($extension, 'info.is_core') ? 1 : $enable)
        ));
        $model->save();

        // Start the extension.
        //
        $this->start($slug);

        // Resolves core tasks.
        //
        require_once path('sys') . 'cli/dependencies' . EXT;

        // Run this extension migrations.
        //
        Command::run(array('migrate', array_get($extension, 'bundles.handles', $slug)));

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
    public function uninstall($slug = null)
    {
        // Get this extension information from the database.
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

        // Resolves core tasks.
        //
        require_once path('sys') . 'cli/dependencies' . EXT;

        // Start the extension so we can find it's bundle path.
        //
        $this->start($slug);

        // If this extension has vendors. 
        //
        if ($this->has_vendors(array_get($extension, 'info.extension')))
        {
            // Get this extension migration files.
            //
            $migrations = glob(path('extensions') . array_get($extension, 'info.vendor') . DS . array_get($extension, 'info.extension') . DS . 'migrations' . DS . '*');
            $migrations = array_reverse($migrations, true); # not sure about this yet !!

            // Loop through the migration files.
            //
            foreach($migrations as $migration)
            {
                // Include the migration file.
                //
                require_once $migration;

                // 
                //
                DB::table('laravel_migrations')
                    ->where('name', '=', basename(str_replace(EXT, '', $migration)))
                    ->delete();

                // Prepare the class name.
                //
                $class = Bundle::class_prefix(array_get($extension, 'info.extension')) . \Laravel\Str::classify(substr(str_replace(EXT, '', basename($migration)), 18));

                // Initiate the migration class.
                //
                $migration = new $class;

                // Run down the migration.
                //
                $migration->down();
            }

            // Make sure we enable the core extension, if we have a core extension !
            //
            if($modell = Extension::find('platform.' . array_get($extension, 'info.extension')))
            {
                $modell->enabled = 1;
                $modell->save();
            }
        }
        else
        {
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

        // extension uninstalled.
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
    public function enable($slug = null)
    {
        // Get this extension information.
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

        // extension enabled.
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
    public function disable($slug = null)
    {
        // Get this extension information.
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
        {}

        // Disable the extension.
        //
        $extension->enabled = 0;
        $extension->save();

        // extension disabled.
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
    public function update($slug)
    {
        // Get this extension information.
        //
        if (is_null($extension = Extension::find($slug)))
        {
            throw new Exception(Lang::line('extensions.not_found', array('extension' => $slug))->get());
        }

        // Get this extension information.
        //
        $info = $this->get($slug);

        // Update extension.
        //
        $extension->version = $info['info']['version'];
        $extension->save();

        // Start the extension.
        //
        $this->start($slug);

        // Resolves core tasks.
        //
        require_once path('sys') . 'cli/dependencies' . EXT;

        // Run this extension migrations.
        //
        Command::run(array('migrate', $slug));

        // extension was updated.
        //
        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get()
     * --------------------------------------------------------------------------
     *
     * Retrieve all the needed information about a extension.
     *
     * @access   public
     * @param    mixed   $extension
     * @return   array
     */
    public function get($extension)
    {
        //
        //
        if (is_array($extension) and count($extension) === 2)
        {
            // Get the extension vendor and slug.
            //
            $vendor = $extension['vendor'];
            $slug   = $extension['slug'];
        }

        // Or do we have the string ?
        //
        else
        {
            // Get the extension vendor and slug.
            //
            list($vendor, $slug) = explode('.', $extension);
        }

        // Extension slug, in reverse.
        //
        $extension_slug = $slug . '.' . $vendor;

        // Check if the extension is already in the array.
        //
        if ( ! $extension = array_get($this->extensions, $extension_slug))
        {
            // Check if the extension.php file of this extension exists.
            //
            if ( ! $file = $this->find_extension($extension_slug))
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

            // Add/change some extension information..
            //
            $extension['info']['slug']         = $vendor . '.' . $slug;
            $extension['info']['vendor']       = $vendor;
            $extension['info']['extension']    = $slug;
            $extension['info']['is_core']      = (bool) ( array_get($extension, 'info.is_core') ?: false );
            $extension['info']['is_enabled']   = (bool) ( array_get($extension, 'info.is_enabled') ?: false );

            // Bundles array, so we can register the extension as a bundle in Laravel.
            //
            $extension['bundles'] = array(
                'handles'  => $slug,
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
                    $this->dependencies[ $vendor ][ $slug ][] = $dependent;
                    $this->dependents[ $dep_vendor ][ $dep_slug ][] = $vendor . '.' . $slug;
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
     * @access   public
     * @param    string
     * @return   string
     */
    # FIXED !
    public function find_extension($extension = null)
    {
        // Check if we have a slug.
        //
        if (is_null($extension))
        {
            return false;
        }

        // Get this extension slug and vendor.
        //
        list($slug, $vendor) = explode('.', $extension);

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
    # FIXED !
    protected function extensions_directories()
    {
        // Get the extensions seperated by vendor.
        //
        if (empty($this->vendors_directories))
        {
            $this->vendors_directories = array_map(function($file)
            {
                return dirname($file);
            }, (array) glob(path('extensions') . '*' . DS . '*' . DS . 'extension' . EXT, GLOB_NOSORT));
        }

        // Get the extensions that doesn't have a vendor.
        //
        if (empty($this->default_directories))
        {
            $this->default_directories = array_map(function($file)
            {
                return dirname($file);
            }, (array) glob(path('extensions') . '*' . DS . 'extension' . EXT, GLOB_NOSORT));
        }

        // Merge the directories, and return them.
        //
        return array_merge($this->vendors_directories, $this->default_directories);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: resolve_extension_directory()
     * --------------------------------------------------------------------------
     *
     * Resolves extension vendor & slug based off it's directory.
     *
     * @access   protected
     * @param    string
     * @return   array
     */
    protected function resolve_extension_directory($directory)
    {
        $directory = ltrim(str_replace(path('extensions'), null, $directory), DS);

        // Is this a valid directory ?
        //
        if (strpos($directory, '.') !== false)
        {
            throw new Exception(Lang::line('extensions.invalid_directory', array('directory' => $directory)));
        }

        return $this->parse(explode(DS, $directory));
    }


    /**
     * --------------------------------------------------------------------------
     * Function: parse()
     * --------------------------------------------------------------------------
     *
     * Converts a mixed extension variable into a formatted array.
     *
     * @access   protected
     * @param    mixed    $extension
     * @return   array
     */
    protected function parse($extension)
    {
        // If we've got an array
        if (is_array($extension))
        {
            // Already prepared
            if (array_key_exists('vendor', $extension) and array_key_exists('slug', $extension))
            {
                return $extension;
            }

            // Numeric keys
            if (count($extension) === 2 and array_key_exists(0, $extension) and array_key_exists(1, $extension))
            {
                return array(
                    'vendor' => $extension[0],
                    'slug'   => $extension[1]
                );
            }

            // Numeric key
            if (count($extension) === 1 and array_key_exists(0, $extension))
            {
                return array(
                    'vendor' => static::DEFAULT_VENDOR,
                    'slug'   => $extension[0]
                );
            }
        }

        // Given a string identifier
        elseif (($parts = explode('.', $extension)) and (count($parts) === 2))
        {
            return array(
                'vendor' => $parts[0],
                'slug'   => $parts[1]
            );
        }

        // Looks like this is an invalid extension.
        //
        throw new Exception(Lang::line('extensions.invalid_extension'));
    }


    /**
     * --------------------------------------------------------------------------
     * Function: convert_slug()
     * --------------------------------------------------------------------------
     *
     * 
     *
     * @access   protected
     * @param    mixed
     * @return   array
     */
    protected function convert_slug($slug)
    {
        // Do we have an array ?
        //
        if (is_array($slug))
        {
            // Return the slug in reverse, just now !
            //
            return $slug['vendor'] . '.' . $slug['extension'];
        }

        // Do we have a vendor.extension slug ?
        //
        if (strpos($slug, '.'))
        {
            list($vendor, $extension) = explode('.', $slug);
        }

        // We must have an extension without a vendor.
        //
        else
        {
            $vendor    = static::DEFAULT_VENDOR;
            $extension = $slug;
        }

        // Return the extension slug.
        //
        return $extension . '.' . $vendor;
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
        // Extension slug.
        //
        $slug = array_get($extension, 'info.extension');

        // Check if this extension is already started.
        //
        if (Bundle::started($slug))
        {
            return true;
        }

        // Register this extension with Laravel.
        //
        Bundle::register($slug, array_get($extension, 'bundles'));

        // Start the extension.
        //
        Bundle::start($slug);

        // Extension started with success.
        //
        return true;
    }
}
