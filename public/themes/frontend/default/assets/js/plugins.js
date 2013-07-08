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
 * @version    2.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://getplatform.com
 */

// Avoid `console` errors in browsers that lack a console.
if ( ! (window.console && console.log))
{
	(function() {

		var noop = function() {};
		var methods = [
			'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
			'exception', 'group', 'groupCollapsed', 'groupEnd', 'info',
			'log', 'markTimeline', 'profile', 'profileEnd', 'table',
			'time', 'timeEnd', 'timeStamp', 'trace', 'warn'
		];
		var length = methods.length;
		var console = window.console = {};

		while (length--)
		{
			console[methods[length]] = noop;
		}

	}());
}
