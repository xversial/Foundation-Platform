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
 * Platform Class
 * --------------------------------------------------------------------------
 *
 * This is the main class, it does most of the heavy work !
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.1
 */
class Platform
{
    /**
     * The current Platform version.
     *
     * @constant
     */
    const VERSION = '1.1';

    /**
     * Flag for whether Platform is initalized.
     *
     * @access    protected
     * @var       boolean
     */
    protected static $initialized = false;

    /**
     * Extensions Manager.
     *
     * @access    protected
     * @var       object
     */
    protected static $extensions_manager = null;

    /**
     * Handles system messages for Platform.
     *
     * @access    protected
     * @var       object
     */
    protected static $messages = null;

    /**
     * Holds an array of Platform Widgets.
     *
     * @access    protected
     * @var       array
     */
    protected static $widgets = array();

    /**
     * Holds an array of Platform Plugins.
     *
     * @access    protected
     * @var       array
     */
    protected static $plugins = array();

    /**
     * Holds extension settings.
     *
     * @access    protected
     * @var       array
     */
    protected static $settings = array();


    /**
     * --------------------------------------------------------------------------
     * Function: start()
     * --------------------------------------------------------------------------
     *
     * Starts up Platform.
     *
     * @access   public
     * @return   void
     */
    public static function start()
    {
        // If we have already initialized Platform.
        //
        if (static::$initialized === true)
        {
            return true;
        }

        // Register IoC
        //
        static::register_ioc();

        // Check if Platform is installed.
        //
        if ( ! static::is_installed() or static::has_update())
        {
            // If Platform appears to not be installed (because it
            // can't find any core files / database info) but the
            // configuration exists, the DB server has probably done
            // a runner. Let's show a 503
            if (static::has_config_files())
            {
                throw new Exception(Lang::line('platform.failed_configuration')->get(), 503);
            }

            // Start the installer.
            //
            static::start_installer();
        }

        // Platform is installed.
        //
        else
        {
            // Platform is initialized.
            //
            static::$initialized = true;

            // Register blade extensions.
            //
            static::register_blade_extensions();

            // Start the extensions.
            //
            static::extensions_manager()->start_extensions();
        }
    }

    public static function has_config_files()
    {
        // Check for the database config file.
        //
        if ( ! File::exists(path('app') . 'config' . DS . 'database' . EXT))
        {
            if (is_dir(path('base') . 'installer') and ! Request::cli())
            {
                return false;
            }
            else
            {
                throw new Exception('No database file exists in application/config');
            }
        }

        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: is_installed()
     * --------------------------------------------------------------------------
     *
     * Determines if Platform has been installed or not.
     *
     * @access   public
     * @return   boolean
     */
    public static function is_installed()
    {
        // Check the platform configuration has the version number.
        //
        if ( ! ($version = Config::get('platform.installed_version')))
        {
            return false;
        }

        // List installed extensions, if the count is 0, it is not installed.
        //
        try
        {
            if (DB::table('extensions')->count() === 0)
            {
                if (is_dir(path('base') . 'installer') and ! Request::cli())
                {
                    return false;
                }
                else
                {
                    throw new Exception('No Platform tables exist');
                }
            }
        }
        catch (Exception $e)
        {
            if (is_dir(path('base') . 'installer') and ! Request::cli())
            {
                return false;
            }

            throw new Exception('No Platform tables exist');
        }

        // Check for the users table.
        //
        try
        {
            if (DB::table('users')->count() === 0)
            {
                if (is_dir( path('base') . 'installer') and ! Request::cli())
                {
                    return false;
                }
                else
                {
                    throw new Exception('No Platform users exist');
                }
            }
        }
        catch (Exception $e)
        {
            if (is_dir(path('base') . 'installer') and ! Request::cli())
            {
                return false;
            }
            else
            {
                throw new Exception('No Platform users exist');
            }
        }

        // Check if the install directory still exists.
        //
        if (is_dir(path('base') . 'installer') and ! Request::cli())
        {
            // Initiate the installer.
            //
            Platform::start_installer(false);

            // This is so we can't see other steps rather than step 5 in the installer !!
            //
            Session::put('install_directory', true);
        }

        // Platform is installed.
        //
        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: has_update()
     * --------------------------------------------------------------------------
     *
     * Checks if Platform is updated.
     *
     * @access   public
     * @return   boolean
     */
    public static function has_update()
    {
        return (( ! $version = Config::get('platform.installed_version')) or version_compare($version, static::version(), '<') === true);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: start_installer()
     * --------------------------------------------------------------------------
     *
     * Starts the installer bundle.
     *
     * @access   public
     * @param    boolean
     * @return   void
     */
    public static function start_installer($redirect = true)
    {
        // Register the installer bundle.
        //
        Bundle::register('installer', array(
            'location' => 'path: ' . path('base') . 'installer',
            'handles'  => 'installer'
        ));

        // Start the installer bundle.
        //
        Bundle::start('installer');

        // If we are not in the installer and we want to be redirected.
        //
        if ( ! URI::is('installer|installer/*') and $redirect)
        {
            // Redirect to the installer page.
            //
            Redirect::to('installer')->send();
            exit;
        }
    }


    /**
     * --------------------------------------------------------------------------
     * Function: extensions_manager()
     * --------------------------------------------------------------------------
     *
     * Retrieves the extensions manager instance.
     *
     * @access   public
     * @return   object
     */
    public static function extensions_manager()
    {
        // Check if we have already initialized our extensions manager.
        //
        if (is_null(static::$extensions_manager))
        {
            static::$extensions_manager = new ExtensionsManager();
        }

        // Return the extensions manager instance.
        //
        return static::$extensions_manager;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: messages()
     * --------------------------------------------------------------------------
     *
     * Return the Platform Messages object
     *
     * @access   public
     * @param    string
     * @return   object
     */
    public static function messages()
    {
        // Check if we have already initialized our messages class.
        //
        if (is_null(static::$messages))
        {
            // Start the messages class.
            //
            static::$messages = Messages::instance();
        }

        // Return the messages instance.
        //
        return static::$messages;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: user()
     * --------------------------------------------------------------------------
     *
     * Gets the Platform User.
     *
     * @access   public
     * @param    string
     * @return   object
     */
    public static function user()
    {
        return Sentry::user();
    }


    /**
     * --------------------------------------------------------------------------
     * Function: register_blade_extensions()
     * --------------------------------------------------------------------------
     *
     * Register Platform extensions for Laravel Blade.
     *
     * @access   protected
     * @return   void
     */
    protected static function register_blade_extensions()
    {
        /**
         * Register @widget with blade.
         *
         *  TODO: add error logging when widget/plugin fails
         *
         * @return   string
         */
        Blade::extend(function($view)
        {
            $pattern = Blade::matcher('widget');

            return preg_replace($pattern, '<?php echo Platform::widget$2; ?>', $view);
        });

        /**
         * Register @plugin with blade.
         *
         * @return   string
         */
        Blade::extend(function($view)
        {
            $pattern = "/\s*@plugin\s*\(\s*\'(.*?)\'\s*\,\s*\'(.*?)\'\s*\,(.*?)\)/";

            return preg_replace($pattern, '<?php $$2 = Platform::plugin(\'$1\',$3); ?>', $view);
        });

        /**
         * Register @get with blade.
         *
         * @return   string
         */
        Blade::extend(function($view)
        {
            $pattern = "/@get\('(.*?)'\)/";

            return preg_replace($pattern, '<?php echo Platform::get(\'$1\'); ?>', $view);
        });

        /**
         * Compile HTML comments.
         *
         * @see http://stackoverflow.com/questions/1013499/stripping-html-comments-with-php-but-leaving-conditionals#answer-1013864
         *
         * @return   string
         */
        Blade::extend(function($view)
        {
            $replacements = array(
                '/<!--((?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*)-->(?:\n)?/is' => "<?php /* $1 */ ?>",
                // '/\/\*/' => '', // Not needed as /* can exist in PHP comments
                // '/\*\//' => '', // Is needed because we don't want to close the comments early
            );

            return preg_replace(array_keys($replacements), array_values($replacements), $view);
        });
    }


    /**
     * --------------------------------------------------------------------------
     * Function: register_ioc()
     * --------------------------------------------------------------------------
     *
     * Register Platform's inversion of control overrides with Laravel.
     *
     * @access   protected
     * @return   void
     */
    protected static function register_ioc()
    {
        IoC::register('task: migrate', function()
        {
            $database = new Laravel\CLI\Tasks\Migrate\Database;

            // Register our override of the tasks resolver
            // which allows for Platform extensions
            $resolver = new Tasks\Migrate\Resolver($database);

            return new Laravel\CLI\Tasks\Migrate\Migrator($resolver, $database);
        });

        IoC::singleton('task: key', function()
        {
            return new Laravel\CLI\Tasks\Key;
        });
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get()
     * --------------------------------------------------------------------------
     *
     * Retrieves a setting value by the given setting key.
     *
     * @access   public
     * @param    string
     * @param    string
     * @return   mixed
     */
    public static function get($setting = null, $default = null)
    {
        // Parse the passed setting.
        //
        $setting = static::parse_extension_string($setting);

        // Let's elegently grab the information we need from the info determined.
        //
        try
        {
            $vendor    = array_get($setting, 'vendor', function() { throw new Exception(''); });
            $extension = array_get($setting, 'extension', function() { throw new Exception(''); });
            $type      = array_get($setting, 'path_segments.0', function() { throw new Exception(''); });
            $name      = array_get($setting, 'path_segments.1', function() { throw new Exception(''); });
        }
        catch (Exception $e)
        {
            return false;
        }

        // Do we have settings already stored?
        //
        if(empty(static::$settings))
        {
            // Nope, grab and store all the settings from the database.
            //
            static::$settings = API::get('settings', array('organize' => true));
        }

        // Return the setting.
        //
        return array_get(static::$settings, implode('.', array($extension, $vendor, $type, $name)) . '.value', $default);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: widget()
     * --------------------------------------------------------------------------
     *
     * Loads a widget.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public static function widget($name = null)
    {
        // Get the widget name.
        //
        $name = trim($name);

        // Get all the parameters passed to the widget.
        //
        $parameters = array_slice(func_get_args(), 1);

        // Check if this widget is from an extension.
        //
        if (strpos($name, '::') === false)
        {
            return;
        }

        // Get the extension path and the action of this widget.
        //
        list($bundle_path, $action) = explode('::', strtolower($name));

        // See if there is a namespace present.
        //
        if (strpos($bundle_path, '/') !== false)
        {
            list ($vendor, $extension) = explode('/', $bundle_path);
        }
        else
        {
            $extension = $bundle_path;
            $vendor = '';
        }

        // Some needed variables.
        //
        $path = explode('.', $action);
        $method = array_pop($path);

        // Prepare the widget class.
        //
        $class = ucfirst($vendor) . '\\' . ucfirst($extension) . '\\Widgets\\' . ucfirst(implode('_', $path));

        // Check if this widget is already initialized.
        //
        if (array_key_exists($class, static::$widgets))
        {
            $widget = static::$widgets[ $class ];
        }

        // Widget is not initialized.
        //
        else
        {
            // Check if the extension is initialized, if not, initiate it.
            //
            ! ($extension == 'application') and ! Bundle::started($vendor.'/'.$extension) and Bundle::start($vendor.'/'.$extension);

            // Check if the plugin class exists.
            //
            if ( ! class_exists($class))
            {
                return;
            }

            // Initialize the plugin class.
            //
            $widget = new $class();

            // Store the object in our widgets array.
            //
            static::$widgets[ $class ] = $widget;
        }

        // Check if the method exists.
        //
        if ( ! method_exists($class, $method))
        {
            return;
        }

        // Execute the widget.
        //
        return call_user_func_array(array($widget, $method), $parameters);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: plugin()
     * --------------------------------------------------------------------------
     *
     * Loads a plugin.
     *
     * @access   public
     * @param    string
     * @return   mixed
     */
    public static function plugin($name = null)
    {
        // Get the plugin name.
        //
        $name = trim($name);

        // Get all the parameters passed to the plugin.
        //
        $parameters = array_slice(func_get_args(), 1);

        // Check if this plugin is from an extension.
        //
        if (strpos($name, '::') === false)
        {
            return;
        }

        // Get the extension path and the action of this plugin.
        //
        list($bundle_path, $action) = explode('::', strtolower($name));

        // See if there is a namespace present.
        //
        if (strpos($bundle_path, '/') !== false)
        {
            list($vendor, $extension) = explode('/', $bundle_path);
        }
        else
        {
            $extension = $bundle_path;
            $vendor = '';
        }

        // Some needed variables.
        //
        $path = explode('.', $action);
        $method = array_pop($path);

        // Prepare the plugin class.
        //
        $class = ucfirst($vendor) . '\\' . ucfirst($extension) . '\\Plugins\\' . ucfirst(implode('_', $path));

        // Check if this plugin is already initialized.
        //
        if (array_key_exists($class, static::$plugins))
        {
            $plugin = static::$plugins[ $class ];
        }

        // Plugin is not initialized.
        //
        else
        {
            // Check if the extension is initialized, if not, initiate it.
            //
            ! Bundle::started($extension) and Bundle::start($extension);

            // Check if the plugin class exists.
            //
            if ( ! class_exists($class))
            {
                return;
            }

            // Initialize the plugin class.
            //
            $plugin = new $class();

            // Store the object in our plugins array.
            //
            static::$plugins[ $class ] = $plugin;
        }

        // Check if the method exists.
        //
        if ( ! method_exists($class, $method))
        {
            return;
        }

        // Execute the plugin.
        //
        return call_user_func_array(array($plugin, $method), $parameters);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: license()
     * --------------------------------------------------------------------------
     *
     * Returns the string for a Platform license.
     *
     * If no extension is passed, we assume the default file extension is .txt
     *
     * @access   public
     * @param    string
     * @return   string
     */
    public static function license($file = null)
    {
        // Start the filesystem.
        //
        $filesystem = Filesystem::make('native');

        // If no file is passed, we return the Platform licence.
        //
        if (is_null($file))
        {
            return $filesystem->file()->contents(path('licenses') . 'platform.txt');
        }

        // No file extension found, use the default one.
        //
        if ( ! pathinfo($file, PATHINFO_EXTENSION))
        {
            $file .= '.txt';
        }

        // Return the license file contents, if the file exists.
        //
        return $filesystem->file()->contents(path('licenses') . $file);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: version()
     * --------------------------------------------------------------------------
     *
     * Returns the current Platform version.
     *
     * @access   public
     * @return   string
     */
    public static function version()
    {
        return self::VERSION;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: install_update()
     * --------------------------------------------------------------------------
     *
     * Updates Laravel to the latest version (by running all migrations etc)
     *
     * @access   public
     * @return   string
     */
    public static function install_update()
    {
        // Disable the checking.
        //
        static::extensions_manager()->installer_mode(true);

        // Check for the migrations table.
        //
        try
        {
            DB::table('laravel_migrations')->count();
        }
        catch (Exception $e)
        {
            Command::run(array('migrate:install'));
        }

        // Now, run the core migrations.
        //
        Command::run(array('migrate', DEFAULT_BUNDLE));

        // Start the extensions, just in case the install process got interrupted.
        //
        Platform::extensions_manager()->start_extensions();
    }


    public static function parse_extension_string($string)
    {
        // Array of parts to send through
        $parts = array(
            'vendor'        => null,
            'extension'     => null,
            'path'          => '',
            'path_segments' => array(),
        );

        $string_parts       = explode('::', $string);
        $string_parts_count = count($string_parts);

        // Can only ever be one separator
        if ($string_parts_count > 2)
        {
            return false;
        }

        // We have a vendor/extension component
        elseif ($string_parts_count === 2)
        {
            $extension_parts = explode(ExtensionsManager::VENDOR_SEPARATOR, $string_parts[0]);

            if (count($extension_parts) === 2)
            {
                $parts['vendor']    = $extension_parts[0];
                $parts['extension'] = $extension_parts[1];
            }
            else
            {
                $parts['vendor']    = ExtensionsManager::DEFAULT_VENDOR;
                $parts['extension'] = $extension_parts[0];
            }

            $parts['path']          = $string_parts[1];
            $parts['path_segments'] = explode('.', $string_parts[1]);
        }
        else
        {
            $parts['extension']     = DEFAULT_BUNDLE;
            $parts['path']          = $string_parts[0];
            $parts['path_segments'] = explode('.', $string_parts[0]);
        }

        return $parts;
    }
}
