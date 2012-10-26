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
 * @version    1.1
 */
class ExtensionsManager
{
    /**
     * Stores all the extensions.
     *
     * @constant
     */
    const DEFAULT_VENDOR = 'default';

    /**
     * Array of cached extensions directories
     *
     * @access   protected
     * @var      array
     */
    protected $vendor_directories  = array();
    protected $default_directories = array();

    /**
     * Stores all the extensions.
     *
     *  <code>
     *      array(
     *          'vendorname' => array(
     *              ...
     *          ),
     *
     *          // Where 'default' matches
     *          // ExtensionsManager::
     *          'default'  => array(
     *              ...
     *          ),
     *      );
     *  </code>
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
     * Flag for whether we're running installer
     * mode or not. Installer mode gives more
     * privelages 
     *
     * @access   protected
     * @var      boolean
     */
    protected $installer_mode = false;

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
        // Check if we have the extensions loaded.
        //
        if (empty($this->extensions))
        {
            foreach ($this->directories() as $directory)
            {
                $extension = $this->resolve_extension_directory($directory);
                $info      = $this->get($extension);

                print_R($info);
            }
        }

        return $this->extensions;
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
        // Parse the extension
        $extension = $this->parse($extension);
        $unparsed  = $this->unparse($extension);

        // Haven't already loaded it?
        if ( ! array_get($this->extensions, $unparsed))
        {
            // Grab and merge in our extension info
            $_extension = $this->resolve_extension_info($extension);

            // Check the dependencies
            foreach (array_get($_extension, 'dependencies', array()) as $dependent)
            {
                // Parse the dependent
                $dependent_parsed = $this->parse($dependent);

                // Add to dependencies
                $this->dependencies[$extension['vendor']][$extension['slug']][] = $dependent;
                $this->dependents[$dependent_parsed['vendor']][$dependent_parsed['slug']][]   = $unparsed;
            }

            // Get basic extension information to set in the object
            $installed          = $this->is_installed($extension);
            $_extension['info'] = array_merge($_extension['info'], $extension, array(
                'installed'     => $installed,
            ));

            // Now we have the base information, let's set the property
            // in the extensions array. This is because the methods below
            // rely on this.
            array_set($this->extensions, $unparsed, $_extension);

            // Now we've built the default array, we'll do specific
            // checks based on whether the extension is installed
            // or not.
            if ($installed)
            {
                $_extension['info']['can_uninstall'] = $this->can_uninstall($extension);

                // Add the enabled flag
                if ($_extension['info']['enabled'] = $this->is_enabled($extension))
                {
                    $_extension['info']['can_disable'] = $this->can_disable($extension);
                }
                else
                {
                    $_extension['info']['can_enable'] = $this->can_enable($extension);
                }
                
            }

            // Uninstalled
            else
            {
                $_extension['info']['can_install'] = $this->can_install($extension);
            }

            // Set the array one more time now 
            array_set($this->extensions, $unparsed, $_extension);
        }

        return array_get($this->extensions, $unparsed);
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
    public function is_installed($extension)
    {
        return (bool) array_get($this->installed(), $this->unparse($extension));
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
    public function is_enabled($extension)
    {
        return (bool) array_get($this->installed(), $this->unparse($extension).'.info.enabled');
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
    public function is_disabled($extension)
    {
        return ( ! $this->is_enabled($extension));
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
    public function can_install($extension)
    {
        if ($this->installer_mode())
        {
            return true;
        }

        // Loop through dependencies
        foreach ($this->dependencies($extension) as $dependent)
        {
            if ($this->is_uninstalled($dependent) or $this->is_disabled($dependent))
            {
                return false;
            }
        }

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
    public function can_uninstall($extension)
    {
        $unparsed = $this->unparse($extension);

        if (array_get($this->extensions, $unparsed.'.info.is_core'))
        {
            return false;
        }

        if ( ! $this->is_installed($extension))
        {
            return false;
        }

        // Loop through dependents
        foreach ($this->dependents($extension) as $dependent)
        {
            if ($this->is_installed($dependent))
            {
                return false;
            }
        }

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
    public function can_enable($extension)
    {
        if ($this->installer_mode())
        {
            return true;
        }

        if ($this->is_enabled($extension))
        {
            return false;
        }

        // Loop through dependencies
        foreach ($this->dependencies($extension) as $dependent)
        {
            if ($this->is_uninstalled($dependent) or $this->is_disabled($dependent))
            {
                return false;
            }
        }

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
    public function can_disable($extension)
    {
        $unparsed = $this->unparse($extension);

        if (array_get($this->extensions, $unparsed.'.info.is_core'))
        {
            return false;
        }

        if ($this->is_disabled($extension))
        {
            return false;
        }

         // Loop through dependents
        foreach ($this->dependents($extension) as $dependent)
        {
            if ($this->is_installed($dependent))
            {
                return false;
            }
        }

        return true;
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
    public function installed($condition = null)
    {
        if (empty($this->installed))
        {
            foreach (Extension::all($condition) as $extension)
            {
                $vendor = $extension->vendor ?: self::DEFAULT_VENDOR;
                array_set($this->installed, $vendor.'.'.$extension->slug.'.info', array(
                    'enabled' => (bool) $extension->enabled,
                    'vendor'  => $vendor,
                    'slug'    => $extension->slug,
                    'version' => $extension->version,
                ));
            }

            // Pretty up
            array_walk($this->installed, function(&$vendor)
            {
                ksort($vendor);
            });
        }

        return $this->installed;
    }

    /**
     * --------------------------------------------------------------------------
     * Function: installer_mode()
     * --------------------------------------------------------------------------
     *
     * Sets the installer_mode property
     *
     * @access   public
     * @return   void
     */
    public function installer_mode($installer_mode = null)
    {
        if ($installer_mode === null)
        {
            return $this->installer_mode;
        }

        return $this->installer_mode = $installer_mode;
    }

    /**
     * --------------------------------------------------------------------------
     * Function: has_dependencies()
     * --------------------------------------------------------------------------
     *
     * Checks if a extension has dependencies, and return them if found any.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function has_dependencies($extension)
    {
        return (bool) $this->dependencies($extension);
    }

    /**
     * --------------------------------------------------------------------------
     * Function: dependencies()
     * --------------------------------------------------------------------------
     *
     * Checks if a extension has dependencies.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function dependencies($extension)
    {
        return array_get($this->dependencies, $this->unparse($extension), array());
    }

    /**
     * --------------------------------------------------------------------------
     * Function: has_dependendents()
     * --------------------------------------------------------------------------
     *
     * Checks if a extension has dependendents, and return them if found any.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function has_dependendents($extension)
    {
        return (bool) $this->dependendents($extension);
    }

    /**
     * --------------------------------------------------------------------------
     * Function: dependendents()
     * --------------------------------------------------------------------------
     *
     * Checks if a extension has dependendents.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public function dependendents($extension)
    {
        return array_get($this->dependendents, $this->unparse($extension), array());
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
        return array_merge($this->vendor_directories(), $this->default_directories());
    }

    protected function vendor_directories()
    {
        if (empty($this->vendor_directories))
        {
            $this->vendor_directories = array_map(function($info_file)
            {
                return dirname($info_file);
            }, (array) glob(path('extensions').'*'.DS.'*'.DS.'extension'.EXT, GLOB_NOSORT));
        }

        return $this->vendor_directories;
    }

    protected function default_directories()
    {
        if (empty($this->default_directories))
        {
            $this->default_directories = array_map(function($info_file)
            {
                return dirname($info_file);
            }, (array) glob(path('extensions').'*'.DS.'extension'.EXT, GLOB_NOSORT));
        }

        return $this->default_directories;
    }

    /**
     * --------------------------------------------------------------------------
     * Function: resolve_extension_directory()
     * --------------------------------------------------------------------------
     *
     * Resolves extension vendor & slug based off it's directory.
     *
     * @access   protected
     * @param    string   $directory
     * @return   array
     */
    protected function resolve_extension_directory($directory)
    {
        $directory = ltrim(str_replace(path('extensions'), null, $directory), DS);

        if (strpos($directory, '.') !== false)
        {
            throw new Exception(Lang::line('extensions.invalid_directory', array('directory' => $directory)));
        }

        return $this->parse(explode(DS, $directory));
    }

    /**
     * --------------------------------------------------------------------------
     * Function: resolve_extension_info()
     * --------------------------------------------------------------------------
     *
     * Resolves extension vendor & slug based off it's directory.
     *
     * @access   protected
     * @param    array   $extension
     * @return   array
     */
    protected function resolve_extension_info(array $extension)
    {
        if ($extension['vendor'] === self::DEFAULT_VENDOR)
        {
            foreach ($this->default_directories() as $directory)
            {
                if (File::exists($file = str_finish($directory, DS).'extension'.EXT))
                {
                    return require $file;
                }
            }
        }
        else
        {
            foreach ($this->vendor_directories() as $directory)
            {
                if (File::exists($file = str_finish($directory, DS).'extension'.EXT))
                {
                    return require $file;
                }
            }
        }

        throw new Exception(Lang::line('extensions.missing_files', array('extension' => $this->unparse($extension))));
    }

    /**
     * --------------------------------------------------------------------------
     * Function: parse()
     * --------------------------------------------------------------------------
     *
     * Resolves extension vendor & slug based off it's directory.
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
                    'slug'   => $extension[1],
                );
            }

            // Numeric key
            if (count($extension) === 1 and array_key_exists(0, $extension))
            {
                return array(
                    'vendor' => self::DEFAULT_VENDOR,
                    'slug'   => $extension[0],
                );
            }
        }

        // Given a string identifier
        elseif (($parts = explode('.', $extension)) and (count($parts) === 2))
        {
            return array(
                'vendor' => $parts[0],
                'slug'   => $parts[1],
            );
        }

        throw new Exception(Lang::line('extensions.invalid_extension'));
    }

    protected function unparse($extension)
    {
        if (is_array($extension))
        {
            return implode('.', $extension);
        }

        return $extension;
    }
    

}