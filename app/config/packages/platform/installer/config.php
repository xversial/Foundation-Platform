<?php
/**
 * Part of the Platform Installer extension.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Platform Installer extension
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return [

	/*
	|--------------------------------------------------------------------------
	| Trusted IPs
	|--------------------------------------------------------------------------
	|
	| Here you may define all the IP addresses that are eligible to undertake
	| operations (such as installing and updating) through the web interface.
	|
	| We accept hard-coded IP addresses, partial or full wildcard "*" entries.
	|
	*/

	'trusted_ips' => [

		'127.0.0.1',

		// // Allow all IP addresses
		// '*',

		// // Allow ranges of IP addresses
		// '127.0.0.*'
		// '127.0.*'
		// '127.*'

	],

];
