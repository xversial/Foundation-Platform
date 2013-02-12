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

return array(

	// Active theme name that matches a folder
	// structure. It's relative to the `directory`
	// defined below
	'active'   => null,
	'fallback' => null,

	// Relative to the `public` directory
	'directory' => 'platform'.DS.'themes',

	// The bundle directory within each theme's
	// path (defined above in `active` and `fallback`)
	'bundle_directory' => 'extensions',

	// Directory of assets within each theme,
	// also matches the assets directory within
	// each bundle directory in each theme.
	'assets_directory' => 'assets',

	// The default asset container used for
	// queueing assets
	'container_name' => 'theme',

	// LESScss options
	'less' => array(

		// Set to `false` if you do not want
		// to compile LESS files on the server,
		// but would rather send the files to the
		// client to be compiled locally.
		'compile' => true,

		// Directory to compile theme styles into,
		// relative to the `directory` defined above.
		'compile_directory' => 'compiled',
	),

);
