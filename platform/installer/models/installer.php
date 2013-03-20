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
 * @version    1.1.4
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Installer;


/*
 * --------------------------------------------------------------------------
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use Bundle,
    Config,
    DB,
    Dependencies,
    File,
    Exception,
    ExtensionsManager,
    Laravel\CLI\Command,
    Platform,
    Session,
    Theme\Theme,
    Str;


/**
 * --------------------------------------------------------------------------
 * Installer Model
 * --------------------------------------------------------------------------
 *
 * Handles operations of the install process.
 *
 * @package    Platform
 * @author     Ben Corlett
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.1
 */
class Installer
{
    /**
     * --------------------------------------------------------------------------
     * Function: prepare()
     * --------------------------------------------------------------------------
     *
     * Prepares the system for an install.
     *
     * @access   public
     * @return   void
     */
    public static function prepare()
    {
        // Always flush session, as new users are created.
        //
        Session::flush();
    }


    /**
     * --------------------------------------------------------------------------
     * Function: permissions()
     * --------------------------------------------------------------------------
     *
     * Checks file & folder permissions.
     *
     * @access   public
     * @return   array
     */
    public static function permissions()
    {
        // Prepare the permissions array.
        //
        $permissions = array(
            'pass' => array(),
            'fail' => array()
        );

        // Define all the directories we need to check.
        //
        $directories = array(
            // Config directory MUST be writable.
            //
            path('app') . 'config',

            // Stub (template file) directories
            //
            Bundle::path('installer') . 'stubs',
            path('extensions') . 'platform' . DS . 'developers' . DS . 'stubs',

            // Themes.
            //
            Theme::compile_directory()
        );

        // Define all the files we need to check.
        //
        $files = array(
            path('app') . 'config' . DS . 'application' . EXT,
            path('app') . 'config' . DS . 'database' . EXT,
            path('app') . 'config' . DS . 'platform' . EXT,
            path('bundle') . 'filesystem' . DS . 'config' . DS . 'filesystem' . EXT
        );

        // Loop through the directories.
        //
        foreach ($directories as $directory)
        {
            if ( ! is_dir($directory))
            {
                continue;
            }

            // Check this directory permissions.
            //
            $permissions[ ( is_dir($directory) and is_writable($directory) ) ? 'pass' : 'fail' ][] = $directory;
        }

        // Loop through the files.
        //
        foreach ($files as $file)
        {
            // Make sure this is a file.
            //
            if ( ! is_file($file))
            {
                continue;
            }

            // Check this file permissions.
            //
            $permissions[ ( is_writable($file) ) ? 'pass' : 'fail' ][] = $file;
        }

        // Sort the permissions.
        //
        sort($permissions['pass']);
        sort($permissions['fail']);

        // Return the permissions.
        //
        return $permissions;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: database_drivers()
     * --------------------------------------------------------------------------
     *
     * Returns an array of all the available database drivers.
     *
     * @access   public
     * @return   array
     */
    public static function database_drivers()
    {
        return array(
            'sqlite' => 'SQLite',
            'mysql'  => 'MySQL',
            'pgsql'  => 'PostgreSQL',
            'sqlsrv' => 'SQL Server'
        );
    }


    /**
     * --------------------------------------------------------------------------
     * Function: create_filesystem_config()
     * --------------------------------------------------------------------------
     *
     * Creates the filesystem config file.
     *
     * @access   public
     * @param    array
     * @return   void
     */
    public static function create_filesystem_config($config = array())
    {
        $config['ftp_timeout'] = 90;

        // get config stub
        $string = file_get_contents(path('base') . 'installer' . DS . 'stubs' . DS . 'filesystem' . EXT);

        if (array_key_exists('ftp_enable', $config) and $config['ftp_enable'] == 1)
        {
            unset($config['ftp_enable']);
            $string = str_replace('{{driver}}', 'ftp', $string);

            $filesystem = \Filesystem::make('ftp', array(
                'server'   => $config['ftp_server'],
                'user'     => $config['ftp_user'],
                'password' => $config['ftp_password'],
                'port'     => $config['ftp_port'],
                'timeout'  => $config['ftp_timeout'],
            ));
        }
        else
        {
            $string = str_replace('{{driver}}', 'native', $string);

            $filesystem = \Filesystem::make('native');
        }

        $replacements = array();
        foreach ($config as $key => $value)
        {
            $replacements['{{' . $key . '}}'] = $value;
        }

        $string = str_replace(array_keys($replacements), array_values($replacements), $string);

        $filesystem->file()->write(\Bundle::path('filesystem') . DS . 'config' . DS . 'filesystem.php', $string);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: create_database_config()
     * --------------------------------------------------------------------------
     *
     * Creates the database config file.
     *
     * @access   public
     * @param    array
     * @return   void
     */
    public static function create_database_config($config = array())
    {
        // Load config file stub.
        //
        $filesystem = \Filesystem::make();
        $string = $filesystem->file()->contents(path('base') . 'installer' . DS . 'stubs' . DS . 'database' . DS . $config['driver'] . EXT);

        if ( ! $string)
        {
            $string = $filesystem->file()->contents(path('base') . 'installer' . DS . 'stubs' . DS . 'database' . EXT);
        }

        // Determine replacements.
        //
        $replacements = array();
        foreach ($config as $key => $value)
        {
            $replacements[ '{{' . $key . '}}' ] = $value;
        }

        // Make the replacements.
        //
        $string = str_replace(array_keys($replacements), array_values($replacements), $string);

        // Write the new file.
        //
        $filesystem->file()->write('platform' . DS . 'application' . DS . 'config' . DS . 'database' . EXT, $string);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: check_database_connection()
     * --------------------------------------------------------------------------
     *
     * Checks the connection to the database.
     *
     * @access   public
     * @param    array
     * @return   boolean
     */
    public static function check_database_connection($config = array())
    {
        // Check what database driver we want to use.
        //
        switch ($config['driver'])
        {
            case 'sqlite':
                $driver = new \Laravel\Database\Connectors\SQLite;
                break;

            case 'mysql':
                $driver = new \Laravel\Database\Connectors\MySQL;
                break;

            case 'pgsql':
                $driver = new \Laravel\Database\Connectors\Postgres;
                break;

            case 'sqlsrv':
                $driver = new \Laravel\Database\Connectors\SQLServer;
                break;

            default:
                throw new Exception('Database driver [' . $config['driver'] . '] is not supported.', 1000);
        }

        // Create a database connection.
        //
        $connection = new \Laravel\Database\Connection($driver->connect($config), $config);

        // If we got this far without an exception been thrown, we've connected.
        //
        return true;
    }


    /**
     * --------------------------------------------------------------------------
     * Function: install_extensions()
     * --------------------------------------------------------------------------
     *
     * Installs the extensions into the database.
     *
     * @access   public
     * @return   void
     */
    public static function install_extensions()
    {
        // Prepare the database to install the extensions.
        //
        Platform::install_update();

        // Flattened extensions.
        //
        $extensions_flat = array();

        // Now get the enabled extensions, and start them !
        //
        foreach (Platform::extensions_manager()->uninstalled() as $extensions)
        {
            // Loop through the extensions.
            foreach ($extensions as $extension)
            {
                // Extension slug.
                //
                $slug = array_get($extension, 'info.slug');

                // Check if this is a a core extension.
                //
                if (Platform::extensions_manager()->is_core($slug))
                {
                    $extensions_flat[ $slug ] = $extension;
                    continue;
                }

                // Loop through this vendor extensions.
                //
                $extensions_flat[ $slug ] = $extension;
            }
        }

        // Dependency sort based on the 'overrides' key of an extension.
        //
        $sorted_slugs = Dependencies::sort($extensions_flat);

        // Install extensions.
        //
        foreach ($sorted_slugs as $slug)
        {
            // Check if this is a core extension.
            //
            if (Platform::extensions_manager()->is_core($slug))
            {
                // Install the extension and enable it aswell.
                //
                Platform::extensions_manager()->install($slug, true);
            }
        }
    }


    /**
     * --------------------------------------------------------------------------
     * Function: generate_key()
     * --------------------------------------------------------------------------
     *
     * This generates the application key.
     *
     * @access   public
     * @return   void
     */
    public static function generate_key()
    {
        // Generate the application key.
        //
        Command::run(array('key:generate'));
    }


    /**
     * --------------------------------------------------------------------------
     * Function: order_menu()
     * --------------------------------------------------------------------------
     *
     * Orders a menu based on the array passed. The API
     * isnt' working so this is a workaround.
     *
     * @todo     Work out why we can't use API::put('menus/admin')
     * @access   public
     * @param    array
     * @return   boolean
     */
    public static function order_menu(array $children)
    {
        if (class_exists('Platform\\Menus\\Menu'))
        {
            return Platform\Menus\Menu::reorder($children);
        }
    }


    /**
     * --------------------------------------------------------------------------
     * Function: remember_step()
     * --------------------------------------------------------------------------
     *
     * Saves the data from a step into the session.
     *
     * @access   public
     * @param    string
     * @param    mixed
     * @return   void
     */
    public static function remember_step_data($step, $data)
    {
        // Check if this is a valid step.
        //
        if ( ! is_int($step))
        {
            throw new Exception('Invalid step provided.');
        }

        // Store this step data in the session.
        //
        Session::put(Config::get('installer::installer.session_key', 'installer') . '.steps.' . $step, $data);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: get_step()
     * --------------------------------------------------------------------------
     *
     * Returns the data from a step.
     *
     * @access   public
     * @param    string
     * @param    string
     * @return   array
     */
    public static function get_step_data($step, $default = null)
    {
        return Session::get(Config::get('installer::installer.session_key', 'installer') . '.steps' . ( $step ? '.' . $step : null ), $default);
    }


    /**
     * --------------------------------------------------------------------------
     * Function: is_prepared()
     * --------------------------------------------------------------------------
     *
     * Returns if the installer is prepared (which just checks the filesystem).
     *
     * @access   public
     * @return   boolean
     */
    public static function is_prepared()
    {
        $permissions = static::permissions();
        return (bool) ( count( $permissions['fail'] ) === 0 );
    }


    /**
     * --------------------------------------------------------------------------
     * Function: update()
     * --------------------------------------------------------------------------
     *
     * Updates the core of Platform.
     *
     * @access   public
     * @return   boolean
     */
    public static function update()
    {
        $result = Platform::install_update();

        $path     = path('app') . 'config' . DS . 'platform' . EXT;
        $contents = File::get($path);

        // Look for the version declaration and update it.
        $contents = preg_replace('/\'installed_version\'(?:\s+|t+|)\=>(?:\s+|t+|)\'(.*)(?=,)/', '\'installed_version\' => \''.Platform::version().'\'', $contents);

        File::put($path, $contents);

        return $result;
    }
}
