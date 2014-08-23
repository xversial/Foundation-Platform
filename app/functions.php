<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the license.txt file.
 *
 * @package    Platform
 * @version    2.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2014, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Platform\Menus\Models\Menu;
use Illuminate\Support\Facades\Response;

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| Here's a great place to register any custom functions for your
| application. We've included a couple to get you started.
|
*/

if ( ! function_exists('redirect'))
{
	/**
	 * Get an instance of the redirector.
	 *
	 * @param  string|null  $to
	 * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
	 */
	function redirect($to = null)
	{
		if ( ! is_null($to))
		{
			return app('redirect')->to($to);
		}
		else
		{
			return app('redirect');
		}
	}
}

if ( ! function_exists('request'))
{
	/**
	 * Get an instance of the http request.
	 *
	 * @return \Illuminate\Http\Request
	 */
	function request()
	{
		return app('request');
	}
}

if ( ! function_exists('response'))
{
	function response($message, $status = 200)
	{
		return Response::make($message, $status);
	}
}

if ( ! function_exists('view'))
{
	/**
	 * Get the evaluated view contents for the given view.
	 *
	 * @param  string  $view
	 * @param  array   $data
	 * @param  array   $mergeData
	 * @return \Illuminate\View\View
	 */
	function view($view, $data = array(), $mergeData = array())
	{
		return app('view')->make($view, $data, $mergeData);
	}
}

if ( ! function_exists('datagrid'))
{
	/**
	 * Get the evaluated datagrid response for the given data.
	 *
	 * @param  mixed  $data
	 * @param  array  $columns
	 * @param  array  $settings
	 * @return \Cartalyst\DataGrid\DataGrid
	 */
	function datagrid($data, $columns = [], $settings = [])
	{
		return app('datagrid')->make($data, $columns, $settings);
	}
}

if ( ! function_exists('set_menu_order'))
{
	/**
	 * Set the order of the provided menu's children according to
	 * the given array of slugs. This will not remove any menu
	 * items and it will skip non-existent items
	 * (they'll be shoved at the end of the menu).
	 *
	 * @param  string  $menuSlug
	 * @param  array   $slugs
	 * @return void
	 */
	function set_menu_order($menuSlug, array $slugs)
	{
		$previous = null;

		foreach ($slugs as $slug)
		{
			if ( ! $current = Menu::find($slug)) continue;

			// If we have a previous menu child, we're assigning
			// this child as it's next sibling
			if ($previous)
			{
				$previous->refresh();
				$current->makeNextSiblingOf($previous);
			}

			// Otherwise, we're on the first child in the
			// loop, at which point we want our child to
			// be the first child
			else
			{
				$admin = Menu::find($menuSlug);
				$current->makeFirstChildOf($admin);
			}

			$previous = $current;
		}
	}
}

if ( ! function_exists('show_error_page'))
{
	/**
	 * Show a production error page for the given status code.
	 *
	 * @param  int  $statsuCode
	 * @return Illuminate\Http\Response
	 */
	function show_error_page($statusCode)
	{
		try
		{
			// Firstly we'll try to make a view for the status code. The
			// default theme ships with these views, but just for safety
			// (in-case the theme system is what's causing the error)
			// we also include duplicated views under app/views.
			$string = View::make("errors/{$statusCode}");
		}
		catch (Exception $e)
		{
			// If we got an exception thrown in the process of loading the error
			// view and our status code is not 500, the view probably doesn't
			// exist. So we don't leave the users hanging, we'll attempt to
			// show a 500 error page.
			if ($statusCode != 500)
			{
				return show_error_page(500);
			}

			// However, if we got this far, we'll simply return a string
			// which lets the user know something's horribly wrong.
			// This is basically a worst-case scenario.
			$string = '500 Internal Server Error';
		}

		return Response::make($string, $statusCode);
	}
}
