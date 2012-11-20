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
 * Developers > API > Theme Creator
 * --------------------------------------------------------------------------
 *
 * Theme creator API.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.0
 */
class Platform_Developers_API_Theme_Creator_Controller extends API_Controller
{
    /**
     * --------------------------------------------------------------------------
     * Function:  post_index()
     * --------------------------------------------------------------------------
     *
     * Create the theme zip file.
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
        $name        = Input::get('name');
        $slug        = Input::get('slug');
        $author      = Input::get('author');
        $description = Input::get('description', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.');
        $version     = Input::get('version', '1.0');
        $area        = Input::get('area', 'frontend');

        // Create a temporary theme directory.
        //
        $temporary_directory = create_temporary_directory('creator' . DS . 'theme'); 

        // Create the theme directory based on the selected area.
        //
        $theme_directory = create_theme_directory($temporary_directory, $area, $slug);

        // Grab and copy the stubs to the temporary theme directory.
        //
        $theme_stubs = get_stubs_directory('creator') . DS . 'theme' . DS . $area;
        copy_contents($theme_stubs, $theme_directory);

        // Replace the stubs variables recursively.
        //
        stubs_replacer($temporary_directory, array(
            'name'        => $name,
            'author'      => $author,
            'description' => $description,
            'version'     => $version
        ));

        // Generate the zip name.
        //
        $zip_name = $name . '.zip';

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
}
