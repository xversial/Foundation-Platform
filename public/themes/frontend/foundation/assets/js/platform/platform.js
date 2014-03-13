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

var Platform;

;(function(window, document, $, undefined){

	'use strict';

	Platform = Platform || {
		Urls: {},
		Main: {},
		Cache: {}
	};

	/**
	 * Platform URLS
	 */
	Platform.Urls.base = $('meta[name="base_url"]').attr('content');

	/**
	 * Cache Our Common Selectors
	 */

	Platform.Cache.$win = $(window);
	Platform.Cache.$body = $(document.body);
	Platform.Cache.$alert = $('.alert');

	Platform.Main.init = function(){

		Platform.Main.addListeners();

	};

	Platform.Main.addListeners = function(){

		Platform.Cache.$alert.on('click', '.close', Platform.Main.closeAlert);

	};

	Platform.Main.closeAlert = function(event){

		$(event.delegateTarget).slideToggle(function(){
			$(this).remove();
		});

	};

	Platform.Main.init();

})(window, document, jQuery);
