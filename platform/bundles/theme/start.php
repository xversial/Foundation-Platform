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


/*
 * --------------------------------------------------------------------------
 * Register some namespaces.
 * --------------------------------------------------------------------------
 */
Autoloader::namespaces(array(
    'Theme' =>  __DIR__ . DS
));


/*
 * --------------------------------------------------------------------------
 * Autoload classes directory
 * --------------------------------------------------------------------------
 */
AutoLoader::map(array(
    'Theme\\Compilers\\lessc'        => __DIR__ . DS . 'compilers' . DS . 'lessc.php',
    'Theme\\Compilers\\PlatformLess' => __DIR__ . DS . 'compilers' . DS . 'platformless.php',
    'Theme\\LESS'                    => __DIR__ . DS . 'less.php',
    'Theme\\Markup'                  => __DIR__ . DS . 'markup.php'
));


/*
 * --------------------------------------------------------------------------
 * Set the global alias
 * --------------------------------------------------------------------------
 */
Autoloader::alias('Theme\\Theme', 'Theme');
