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
 * Auto-Loader Mappings
 * --------------------------------------------------------------------------
 *
 * Registering a mapping couldn't be easier. Just pass an array of class
 * to path maps into the "map" function of Autoloader. Then, when you
 * want to use that class, just use it. It's simple!
 *
 */
Autoloader::map(array(
	'Installer_Base_Controller' => __DIR__ . DS . 'controllers' . DS . 'base' . EXT
));


/*
 * --------------------------------------------------------------------------
 * Register some namespaces.
 * --------------------------------------------------------------------------
 */
Autoloader::namespaces(array(
    'Installer' => __DIR__ . DS . 'models'
));
