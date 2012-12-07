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


/**
 * --------------------------------------------------------------------------
 * Function: get_stubs_directory()
 * --------------------------------------------------------------------------
 *
 * Returns the full path to the developers stubs directory.
 * 
 * @param    string
 * @return   string
 */
function get_stubs_directory($directory = 'creator')
{
    return Bundle::path('platform/developers') . 'stubs' . DS . $directory;
}


/**
 * --------------------------------------------------------------------------
 * Function: create_temporary_directory()
 * --------------------------------------------------------------------------
 *
 * Creates a temporary directory.
 * 
 * @param    string
 * @return   string
 */
function create_temporary_directory($directory)
{
    // Prepare the directory.
    //
    $temporary_directory = path('storage') . 'work' . DS . 'developers' . DS . $directory . DS . 'cache' . DS . time();

    // Create the directory.
    //
    Filesystem::make('native')->directory()->make($temporary_directory);

    // Return the directory path.
    //
    return $temporary_directory;
}


/**
 * --------------------------------------------------------------------------
 * Function: create_extension_directory()
 * --------------------------------------------------------------------------
 *
 * Creates the vendor/extension directory inside the temporary directory.
 *
 * @param    string
 * @param    string
 * @param    string
 * @return   string
 */
function create_extension_directory($temporary_directory, $vendor, $extension)
{
    // Prepare the directory.
    //
    $extension_directory = $temporary_directory . DS . 'platform' . DS . 'extensions' . DS . $vendor . DS . $extension;

    // Create the directory.
    //
    Filesystem::make('native')->directory()->make($extension_directory);

    // Return the directory path.
    //
    return $extension_directory;
}


/**
 * --------------------------------------------------------------------------
 * Function: create_extension_theme_directory()
 * --------------------------------------------------------------------------
 *
 * Creates the vendor/extension theme directory.
 *
 * @param    string
 * @param    string
 * @param    string
 * @param    string
 * @return   string
 */
function create_extension_theme_directory($temporary_directory, $type, $vendor, $extension)
{
    // Prepare the directory.
    //
    $theme_directory = $temporary_directory . DS . 'public' . DS . 'platform' . DS . 'themes' . DS . $type . DS . 'default' . DS . 'extensions' . DS . $vendor . DS . $extension;

    // Create the directory.
    //
    Filesystem::make('native')->directory()->make($theme_directory);

    // Return the directory path.
    //
    return $theme_directory;
}


/**
 * --------------------------------------------------------------------------
 * Function: create_theme_directory()
 * --------------------------------------------------------------------------
 *
 * Creates the theme directory.
 *
 * @param    string
 * @param    string
 * @param    string
 * @return   string
 */
function create_theme_directory($temporary_directory, $type, $slug)
{
    // Prepare the directory.
    //
    $theme_directory = $temporary_directory . DS . 'public' . DS . 'platform' . DS . 'themes' . DS . $type . DS . $slug;

    // Create the directory.
    //
    Filesystem::make('native')->directory()->make($theme_directory);

    // Return the directory path.
    //
    return $theme_directory;
}


/**
 * --------------------------------------------------------------------------
 * Function: copy_contents()
 * --------------------------------------------------------------------------
 *
 * Copies the contents from a directory to another.
 *
 * @param    string
 * @param    string
 * @return   void
 */
function copy_contents($source, $destination)
{
    // Recursive get a list of files/directories.
    //
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(
            $source,
            RecursiveDirectoryIterator::SKIP_DOTS
        ),
        RecursiveIteratorIterator::SELF_FIRST
    );

    // Loop through the files/directories.
    //
    foreach ($iterator as $item)
    {
        // Is this a directory?
        //
        if ($item->isDir())
        {
            // Create the directory.
            //
            mkdir($destination.DS.$iterator->getSubPathName());
        }

        // We must be a file.
        //
        else
        {
            // Copy the file.
            //
            copy($item, $destination . DS . $iterator->getSubPathName());
        }
    }
}


/**
 * --------------------------------------------------------------------------
 * Function: create_zip()
 * --------------------------------------------------------------------------
 *
 * Creates the zip file.
 *
 * @param    string
 * @param    string
 * @return   string
 */
function create_zip($temporary_directory, $zip_name)
{
    // Work the zip name.
    //
    $zip_name = dirname($temporary_directory) . DS . $zip_name;

    // Open a new zip archive.
    //
    $zip = new ZipArchive();
    $zip->open($zip_name, ZipArchive::CREATE);

    // Prepare the replacements array.
    //
    $replacements = array(
        $temporary_directory . DS => '',
        DS                        => '/' // Zips don't like \ on Windows.
    );

    // Recursive get a list of files/directories.
    //
    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(
            $temporary_directory,
            RecursiveDirectoryIterator::SKIP_DOTS
        ),
        RecursiveIteratorIterator::SELF_FIRST
    );

    // Loop through the files/directories.
    //
    foreach ($items as $item)
    {
        // Get the complete path of this item.
        //
        $path = $item->getRealPath();

        // Is this a directory?
        //
        if ($item->isDir())
        {
            // Create the directory.
            //
            $zip->addEmptyDir(str_replace(array_keys($replacements), array_values($replacements), $path));
        }

        // We must be a file.
        //
        else
        {
            // Add the file.
            //
            $zip->addFile($path, str_replace(array_keys($replacements), array_values($replacements), $path));
        }
    }

    // Close the zip archive.
    //
    $zip->close();

    // Return the zip name.
    //
    return $zip_name;
}


/**
 * --------------------------------------------------------------------------
 * Function: stubs_replacer()
 * --------------------------------------------------------------------------
 *
 * Recursively replace the variables in the stubs files.
 *
 * @param    string
 * @param    string
 * @return   void
 */
function stubs_replacer($temporary_directory, array $variables)
{
    // Stubs replacer variables.
    //
    $variable_start = '[[';
    $variable_end   = ']]';

    // Prepare data.
    //
    $items              = new FilesystemIterator($temporary_directory, FilesystemIterator::SKIP_DOTS);
    $file               = Filesystem::make('native')->file();
    $prepared_variables = array();
    $variable_start     = $variable_start;
    $variable_end       = $variable_end;

    // Loop through the variables.
    //
    foreach ($variables as $name => $value)
    {
        // Store the variables.
        //
        $prepared_variables[ $variable_start . $name . $variable_end ] = $value;
    }

    // Loop through the files/directories.
    //
    foreach ($items as $item)
    {
        // Get the complete path of this item.
        // 
        $real_path = $item->getRealPath();

        // Is this a directory?
        //
        if ($item->isDir())
        {
            stubs_replacer($real_path, $variables);
        }

        // We must be a file.
        //
        else
        {
            // Do the replacements.
            //
            $result = str_replace(array_keys($prepared_variables), array_values($prepared_variables), $file->contents($real_path));
            $file->write($real_path, $result);
        }
    }
}
