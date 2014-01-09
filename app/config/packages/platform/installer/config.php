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
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

return array(

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

	'trusted_ips' => array(

		'127.0.0.1',

		// // Allow all IP addresses
		// '*',

		// // Allow ranges of IP addresses
		// '127.0.0.*'
		// '127.0.*'
		// '127.*'

	),

);
