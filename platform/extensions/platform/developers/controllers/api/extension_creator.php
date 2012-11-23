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
 * @version    1.1.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */


/**
 * --------------------------------------------------------------------------
 * Developers > API > Extension Creator
 * --------------------------------------------------------------------------
 *
 * Extension creator API.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.1
 */
class Platform_Developers_API_Extension_Creator_Controller extends API_Controller
{
    /**
     * --------------------------------------------------------------------------
     * Function:  post_index()
     * --------------------------------------------------------------------------
     *
     * Create the extension zip file.
     *
     * @access   public
     * @return   Response
     */
    public function post_index()
    {
        // Filesystem.
        //
        $filesystem = Filesystem::make('native');
        $file       = $filesystem->file();
        $directory  = $filesystem->directory();

        // Properties.
        //
        $name         = Input::get('name');
        $author       = Input::get('author');
        $description  = Input::get('description', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $version      = Input::get('version', '1.0');
        $vendor       = Input::get('vendor');
        $extension    = Input::get('extension');
        $handles      = Input::get('handles', $extension);
        $dependencies = Input::get('dependencies', array());
        $overrides    = Input::get('overrides', array());

        // Prepare the dependencies
        //
        $dependencies = $this->prepare_array($dependencies);

        // Prepare the overrides.
        //
        $overrides = $this->prepare_array($overrides);

        // Create a temporary extension directory.
        //
        $temporary_directory = create_temporary_directory('creator' . DS . 'extension');

        // Create the extension directory based on the vendor and extension name.
        //
        $extension_directory = create_extension_directory($temporary_directory, $vendor, $extension);

        // Create the default themes directories based on the vendor and extension name.
        //
        $theme_backend_directory  = create_extension_theme_directory($temporary_directory, 'backend', $vendor, $extension);
        $theme_frontend_directory = create_extension_theme_directory($temporary_directory, 'frontend', $vendor, $extension);

        // Grab and copy the stubs to the temporary directory.
        //
        # Extension stubs.
        #
        $extension_stubs = get_stubs_directory('creator' . DS . 'extension' . DS . 'extension');
        copy_contents($extension_stubs, $extension_directory);

        # Theme stubs.
        #
        $theme_backend_stubs = get_stubs_directory('creator' . DS . 'extension' . DS . 'theme' . DS . 'backend');
        copy_contents($theme_backend_stubs, $theme_backend_directory);

        $theme_frontend_stubs = get_stubs_directory('creator' . DS . 'extension' . DS . 'theme' . DS . 'frontend');
        copy_contents($theme_frontend_stubs, $theme_frontend_directory);

        // Update the admin controller file name.
        //
        if ($file->exists($admin_controller = $extension_directory . DS . 'controllers' . DS . 'admin' . DS . 'admin.php'))
        {
            $file->move($admin_controller, dirname($admin_controller) . DS . $extension . '.php');
        }

        // Update the public controller file name.
        //
        if ($file->exists($public_controller = $extension_directory . DS . 'controllers' . DS . 'public.php'))
        {
            $file->move($public_controller, dirname($public_controller) . DS . $extension . '.php');
        }

        // Replace the stubs variables recursively.
        //
        stubs_replacer($temporary_directory, array(
            'name'                 => $name,
            'author'               => $author,
            'description'          => $description,
            'version'              => $version,
            'vendor'               => $vendor,
            'extension'            => $extension,
            'extension_classified' => Str::classify($extension),
            'namespace'            => str_replace('_', '\\', Str::classify($vendor . '_' . $extension)),
            'namespace_underscore' => Str::classify($vendor . '_' . $extension),
            'slug_code'            => $vendor . '.' . $extension,
            'slug_designer'        => $vendor . ExtensionsManager::VENDOR_SEPARATOR . $extension,
            'handles'              => $handles,
            'dependencies'         => $dependencies,
            'overrides'            => $overrides
        ));

        // Generate the zip name.
        //
        $zip_name = sprintf('%s-%s.zip', $vendor, $extension);

        // Create the temporary zip file.
        //
        $zip_location = create_zip($temporary_directory, time() . '-' . $zip_name);

        //
        //
        switch (Input::get('encoding', 'base64'))
        {
            case 'utf-8':
                $encoded = utf8_encode($file->contents($zip_location));
                break;

            default:
                $encoded = base64_encode($file->contents($zip_location));
                break;
        }

        // Temporary fix for PHP on windows messing up the contents of the
        // ZIP when JSON encoded / decoded.
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: public');
        header('Content-Description: File Transfer');
        header('Content-type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $zip_name . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($zip_location));
        ob_end_flush();
        @readfile($zip_location);

        // Remove both temporary directory and the zip file.
        //
        $directory->delete($temporary_directory);
        $file->delete($zip_location);

        //
        //
        return new Response($encoded);
    }



    protected function prepare_array($data)
    {
        $data = array_map(function($override)
        {
            return trim($override);
        }, explode(PHP_EOL, $data));


        return 'array(' . ($data[0] != '' ? implode(', ', array_map(function($override){ return '\'' . trim($override) . '\''; }, $data)) : '' ) . ')';
    }
}
