<?php
/**
 * Part of the Themes package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Themes
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return array(

	/*
	|--------------------------------------------------------------------------
	| Asset Default Filters
	|--------------------------------------------------------------------------
	|
	| List the filters used by each extension when compiling
	|
	*/

	'filters' => array(

		'css' => array(

			'Assetic\Filter\CssImportFilter',
			'Cartalyst\AsseticFilters\UriRewriteFilter',

		),

		'less' => array(

			'Cartalyst\AsseticFilters\LessphpFilter',
			'Cartalyst\AsseticFilters\UriRewriteFilter',

		),

		'sass' => array(

			'Assetic\Filter\SassFilter',
			'Cartalyst\AsseticFilters\UriRewriteFilter',

		),

		'scss' => array(

			'Assetic\Filter\ScssphpFilter',
			'Cartalyst\AsseticFilters\UriRewriteFilter',

		),

		'js' => array(

		),

		'coffee' => array(

			'Assetic\Filter\CoffeeScriptFilter',

		),

	),

);
