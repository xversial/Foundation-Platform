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
 * Register some namespaces.
 * --------------------------------------------------------------------------
 */
Autoloader::namespaces(array(
	'Platform\\Pages\\Widgets' => __DIR__ . DS . 'widgets',
	'Platform\\Pages\\Model'   => __DIR__ . DS . 'models',
	'Platform\\Pages'          => __DIR__ . DS . 'libraries',
));

/**
 * Register @content with blade.
 *
 *  TODO: add error logging when widget/plugin fails
 *
 * @return   string
 */
Blade::extend(function($view)
{
	$pattern = Blade::matcher('content');

	return preg_replace($pattern, '<?php echo Platform\Pages\Helper::content$2; ?>', $view);
});