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

 ;(function(window, document, $, undefined){

 	'use strict';

 	var $win = $(window);
 	var $body = $(document.body);

 	var $siteWrap = $('#base');
 	var $sidebar = $siteWrap.find('.sidebar');
 	var $page = $siteWrap.find('.page');
 	var $systemNavigation = $('.system-navigation a');

 	var sizes = {
 		sidebar : {
 			open: 200,
 			closed: 80
 		}
 	};

 	init();


 	function init(){

		//SideBar
		checkSidebar();

		//Listeners
		addListeners();
	}


	function addListeners(){

		//Toggle Sidebar
		$body.on('click', '.sidebar-toggle', toggleSidebar);

		//Tooltip for system navigation
		$systemNavigation.each(function() {
			$(this).tooltip({
				title: $(this).find('span').text(),
				placement: 'bottom'
			});
		});

		$('.tip').tooltip();
	}


	function checkSidebar(){

		if ( typeof localStorage.getItem('sidebar') === 'string' && localStorage.getItem('sidebar') === 'closed'){

			$body.addClass('collapsed');
			$sidebar.css({ 'width' : sizes.sidebar.closed });
			$page.css({ 'marginLeft' : sizes.sidebar.closed });

		}

	}

	function toggleSidebar(e){
		e.preventDefault();

		if( ! $body.hasClass('collapsed')){

			$body.addClass('collapsed');
			$sidebar.animate({ 'width' : sizes.sidebar.closed });
			$page.animate({ 'marginLeft' : sizes.sidebar.closed });
			localStorage.setItem('sidebar', 'closed');


		}else{

			$sidebar.animate({ 'width' : sizes.sidebar.open }, function(){
				$body.removeClass('collapsed');
			});
			$page.animate({ 'marginLeft' : sizes.sidebar.open });
			localStorage.setItem('sidebar', 'open');

		}

	}

	// Avoid `console` errors in browsers that lack a console.
	(function() {
		var method;
		var noop = function () {};
		var methods = [
		'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
		'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
		'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
		'timeStamp', 'trace', 'warn'
		];
		var length = methods.length;
		var console = (window.console = window.console || {});

		while (length--) {
			method = methods[length];

	        // Only stub undefined methods.
	        if (!console[method]) {
	        	console[method] = noop;
	        }
	    }
	}());

})(window, document, jQuery);
