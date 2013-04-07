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

jQuery(document).ready(function($) {

	var $body = $(document.body);
	var $sidebar = $('#base').find('.sidebar');
	var $page = $('#base').find('.page');

	var sizes = {
		sidebar : {
			open: '15%',
			closed: 60
		},
		page : {
			open: '84%'
		}
	};

	if( typeof localStorage.getItem('sidebar') === 'string' && localStorage.getItem('sidebar') === 'closed' ){

		$body.addClass('collapsed');
		$sidebar.css({'width' : sizes.sidebar.closed });
		$page.css({ 'width' : $body.width() - (sizes.sidebar.closed + 10), 'marginLeft' : sizes.sidebar.closed });

	}

	$sidebar.on('click', '.close-sidebar', function(){

		$body.addClass('collapsed');
		$sidebar.animate({ 'width' : sizes.sidebar.closed });
		$page.animate({ 'width' : $body.width() - (sizes.sidebar.closed + 10), 'marginLeft' : sizes.sidebar.closed });
		localStorage.setItem('sidebar', 'closed');

	})
	.on('click', '.open-sidebar', function(){

		$sidebar.animate({ 'width' : sizes.sidebar.open }, function(){
			$body.removeClass('collapsed');
		});
		$page.animate({ 'width' : sizes.page.open, 'marginLeft' : sizes.sidebar.open });
		localStorage.setItem('sidebar', 'open');

	});

	// if( $sidebar.height() > $page.height() ){
	// 	$page.css({'height' : $sidebar.height() });
	// }

	// console.log( $sidebar.height() + ' | ' + $page.height() );

});
