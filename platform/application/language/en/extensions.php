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


/*
 * --------------------------------------------------------------------------
 * Return the language lines.
 * --------------------------------------------------------------------------
 */
return array(
    /*
     * -----------------------------------------
     * Per action messages.
     * -----------------------------------------
     */
    'install' => array(
        'success'   => 'Extension <strong>:extension</strong> was successfully installed.',
        'fail'      => 'Extension <strong>:extension</strong> can\'t be installed.',
        'installed' => 'Extension <strong>:extension</strong> is already installed!'
    ),
    'uninstall' => array(
        'success' => 'Extension <strong>:extension</strong> was successfully uninstalled.',
        'fail'    => 'Extension <strong>:extension</strong> can\'t be uninstalled.'
    ),
    'enable' => array(
        'success' => 'Extension <strong>:extension</strong> was successfully enabled.',
        'fail'    => 'Extension <strong>:extension</strong> can\'t be enabled.',
        'enabled' => 'Extension <strong>:extension</strong> is already enabled!'
    ),
    'disable' => array(
        'success'  => 'Extension <strong>:extension</strong> was successfully disabled.',
        'fail'     => 'Extension <strong>:extension</strong> can\'t be disabled.',
        'disabled' => 'Extension <strong>:extension</strong> is not enabled!'
    ),
    'update' => array(
        'success' => 'Extension <strong>:extension</strong> was successfully updated.'
    ),


    /*
     * -----------------------------------------
     * Other messages.
     * -----------------------------------------
     */
    'not_found'         => 'Extension <strong>:extension</strong> was not found!',
    'invalid_slug'      => 'Invalid slug passed.',
    'invalid_extension' => 'Invalid extension properties passed.',
    'missing_files'     => 'Extension <strong>:extension</strong> required files are missing',
    'invalid_file'      => 'Extension <strong>:extension</strong> doesn\'t have a valid extension.php file',
    'invalid_routes'    => 'Extension <strong>:extension</strong> "routes" must be a function / closure',
    'invalid_listeners' => 'Extension <strong>:extension</strong> "listeners" must be a function / closure',
    'invalid_filter'    => 'Invalid extension filter provided.',
    'dependencies'      => 'There is an error with this extension dependencies!',
    'is_core'           => 'This is a core extension, therefore you can\'t do any changes to it',
    'required'          => 'This extension is required, therefore you can\'t do any changes to it.',
    'requires'          => 'Please make sure all the extensions listed above are installed and enabled.'
);
