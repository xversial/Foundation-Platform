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
	/**
	 * Platform Global Object
	 * @type {[type]}
	 */
	 var Platform = Platform || {};
	 Platform.Cache = Platform.Cache || {};
	 Platform.Main = Platform.Main || {};

	/**
	 * Cache our common selectors
	 */
	 Platform.Cache.$win = $(window);
	 Platform.Cache.$body = $(document.body);
	 Platform.Cache.$sidebar = Platform.Cache.$body.find('.sidebar');
	 Platform.Cache.$page = Platform.Cache.$body.find('.page');
	 Platform.Cache.$console = Platform.Cache.$body.find('.console');
	 Platform.Cache.$sysNav = Platform.Cache.$body.find('.console__navigation a');
	 Platform.Cache.$tip = Platform.Cache.$body.find('.tip');

	/**
	 * Sidebar Sizes
	 * @type {Object}
	 */
	 Platform.Cache.sizes = {
	 	closed: 80,
	 	open: 200
	 };

	/**
	 * Media Query Break Points
	 * @type {Number}
	 */
	 Platform.Cache.breakPointTablet = 768;
	 Platform.Cache.breakPointDesktop = 1200;

	 Platform.Main.init = function(){

	 	Platform.Main.checkSidebar();

	 	Platform.Main.addListeners();

	 	Platform.Cache.$sysNav.each(function(){
	 		$(this).tooltip({
	 			title: $(this).find('span').text(),
	 			placement: 'bottom'
	 		});
	 	});

	 	Platform.Cache.$tip.tooltip();

	 };

	 Platform.Main.addListeners = function(){

	 	Platform.Cache.$win.on('resize', Platform.Main.onWindowResize);

	 	Platform.Cache.$win.on('breakPointChanged', Platform.Main.breakPointChanged);

	 	Platform.Cache.$body.on('click', '.sidebar__toggle', Platform.Main.toggleSidebar);

	 };

	 Platform.Main.checkSidebar = function(){

	 	if( typeof localStorage.getItem('sidebar') === 'string' && localStorage.getItem('sidebar') === 'closed'){

	 		Platform.Cache.$body.addClass('collapsed');
	 		localStorage.setItem('sidebar', 'closed');

	 	}

	 };

	 Platform.Main.toggleSidebar = function(event){

	 	if( ! Platform.Cache.$body.hasClass('collapsed')){

	 		Platform.Cache.$body.addClass('collapsed');
	 		localStorage.setItem('sidebar', 'closed');

	 	}else{


	 		Platform.Cache.$body.removeClass('collapsed');
	 		localStorage.setItem('sidebar', 'open');

	 	}

	 	event.preventDefault();

	 };

	 Platform.Main.onWindowResize = function(){

	 	var w = Platform.Cache.$win.width();

	 	if( w > Platform.Cache.breakPointTablet){

	 		Platform.Cache.newMode = Platform.Cache.breakPointTablet;

	 	}else{

	 		Platform.Cache.newMode = Platform.Cache.breakPointDesktop;

	 	}

	 	if( Platform.Cache.currentMode !== Platform.Cache.newMode){

	 		Platform.Cache.$win.trigger('breakPointChanged');

	 	}

	 	Platform.Cache.currentMode = Platform.Cache.newMode;

	 };

	 Platform.Main.breakPointChanged = function(){

	 	if( Platform.Cache.currentMode === Platform.Cache.breakPointTablet){

	 		Platform.Cache.$body.addClass('collapsed');
	 		localStorage.setItem('sidebar', 'closed');

	 	}

	 	if( Platform.Cache.currentMode === Platform.Cache.breakPointDesktop){

	 		Platform.Cache.$body.removeClass('collapsed');
	 		localStorage.setItem('sidebar', 'open');

	 	}
	 };

	Platform.Main.shorten = function(num){
		if (num >= 1e6){
			num = (num / 1e6).toFixed(1) + "M"
		} else if (num >= 1e3){
			num = (num / 1e3).toFixed(1) + "k"
		}else{
			num = num;
		}
		return num;
	};

	Platform.Main.init();

	})(window, document, jQuery);
