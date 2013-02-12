<?php
/**
 * Part of the Theme bundle for Laravel.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Theme
 * @version    1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Theme;


/*
 * --------------------------------------------------------------------------
 * What we can use in this class.
 * --------------------------------------------------------------------------
 */
use Bundle;


/**
 * --------------------------------------------------------------------------
 * Theme > View Class
 * --------------------------------------------------------------------------
 *
 * I handle the views for you .
 *
 */
class View extends \Laravel\View
{
    /**
     * --------------------------------------------------------------------------
     * Function: find_file()
     * --------------------------------------------------------------------------
     *
     * Find a theme view file within the theme system.
     *
     * @access   public
     * @param    string
     * @param    string
     * @return   string
     */
    public static function find_file($bundle, $view)
    {
        // Prepare the view name.
        //
        $view = str_replace('.', DS, $view);

        // Loop through directories, till we find the view.
        //
        foreach (static::directories($bundle) as $directory)
        {
            // Check if this is a normal view file.
            //
            if (file_exists($file = $directory . $view . EXT))
            {
                return $file;
            }

            // Check if this is a blade view.
            //
            elseif (file_exists($file = $directory . $view . BLADE_EXT))
            {
                return $file;
            }
        }

        // View does not exist.
        //
        throw new ThemeException('View [' . $view . '] doesn\'t exist.');
    }


    /**
     * --------------------------------------------------------------------------
     * Function: directories()
     * --------------------------------------------------------------------------
     *
     * Returns an array of directories to check for view files.
     *
     * @access   public
     * @param    string
     * @return   array
     */
    public static function directories($bundle)
    {
        // Directories preparation.
        //
        $bundle           = ($bundle == DEFAULT_BUNDLE) ? '' : str_replace('.', DS, $bundle);
        $bundle_directory = ($bundle) ? str_finish(Theme::bundle_directory(), DS) : '';

        // Return the directories.
        //
        return array(
            // Active theme directory.
            //
            str_finish(Theme::active_path() . $bundle_directory . $bundle, DS),

            // Fallback theme directory.
            //
            str_finish(Theme::fallback_path() . $bundle_directory . $bundle, DS),

            // Bundle path.
            //
            str_finish(Bundle::path($bundle) . 'views', DS),

            // Application path.
            //
            str_finish(path('app') . 'views', DS)
        );
    }
}
