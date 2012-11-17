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
 * Function: create_root_directory()
 * --------------------------------------------------------------------------
 *
 * Creates a temporary directory.
 * 
 * @param    string
 * @return   string
 */
function create_root_directory($directory)
{
    // Prepare the directory.
    //
    $root_directory = path('storage') . 'work' . DS . 'developers' . DS . $directory . DS . 'cache' . DS . time();

    // Create the directory.
    //
    Filesystem::make('native')->directory()->make($root_directory);

    // Return the directory path.
    //
    return $root_directory;
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
function create_extension_directory($root_directory, $vendor, $extension)
{
    // Prepare the directory.
    //
    $extension_directory = $root_directory . DS . 'platform' . DS . 'extensions' . DS . $vendor . DS . $extension;

    // Create the directory.
    //
    Filesystem::make('native')->directory()->make($extension_directory);

    // Return the directory path.
    //
    return $extension_directory;
}


/**
 * --------------------------------------------------------------------------
 * Function: create_theme_directory()
 * --------------------------------------------------------------------------
 *
 * Creates the default vendor/extension theme view files.
 *
 * @param    string
 * @param    string
 * @param    string
 * @param    string
 * @return   string
 */
function create_theme_directory($root_directory, $type, $vendor, $extension)
{
    // Prepare the directory.
    //
    $theme_directory = $root_directory . DS . 'public' . DS . 'platform' . DS . 'themes' . DS . $type . DS . 'default' . DS . 'extensions' . DS . $vendor . DS . $extension;

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
 * 
 *
 * @param    string
 * @param    string
 * @return   void
 */
function copy_contents($source, $destination)
{
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(
            $source,
            RecursiveDirectoryIterator::SKIP_DOTS
        ),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item)
    {
        if ($item->isDir())
        {
            mkdir($destination.DS.$iterator->getSubPathName());
        }
        else
        {
            copy($item, $destination.DS.$iterator->getSubPathName());
        }
    }
}


/**
 * --------------------------------------------------------------------------
 * Function: create_zip()
 * --------------------------------------------------------------------------
 *
 * 
 *
 * @param    string
 * @param    string
 * @return   string
 */
function create_zip($root_directory, $zip_name)
{
    $zip_name = dirname($root_directory).DS.$zip_name;
    $zip = new ZipArchive();
    $zip->open($zip_name, ZipArchive::CREATE);

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(
            $root_directory,
            RecursiveDirectoryIterator::SKIP_DOTS
        ),
        RecursiveIteratorIterator::SELF_FIRST
    );

    $replacements = array(
        $root_directory.DS => '',
        DS                 => '/', // Zips don't like \ on Windows.
    );

    foreach ($iterator as $item)
    {
        $path = $item->getRealPath();

        if ($item->isDir())
        {
            $zip->addEmptyDir(str_replace(array_keys($replacements), array_values($replacements), $path));
        }
        else
        {
            $zip->addFile($path, str_replace(array_keys($replacements), array_values($replacements), $path));
        }
    }

    $zip->close();

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
function stubs_replacer($root_directory, array $variables)
{
    # 
    $variable_start = '[[';
    $variable_end   = ']]';

    // Prepare data
    $items              = new FilesystemIterator($root_directory, FilesystemIterator::SKIP_DOTS);
    $file               = Filesystem::make('native')->file();
    $prepared_variables = array();
    $variable_start     = $variable_start;
    $variable_end       = $variable_end;

    foreach ($variables as $name => $value)
    {
        $prepared_variables[$variable_start . $name . $variable_end] = $value;
    }

    foreach ($items as $item)
    {
        $real_path = $item->getRealPath();

        if ($item->isDir())
        {
            stubs_replacer($real_path, $variables);
        }
        else
        {
            // // Load the view
            // $view     = View::make('path: '.$real_path, $variables);
            // $compiled = Blade::compile($view);

            // Filesystem::make('native')->file()->write($real_path, $compiled);

            // Do our replacements
            $result = str_replace(array_keys($prepared_variables), array_values($prepared_variables), $file->contents($real_path));
            $file->write($real_path, $result);
        }
    }
}
