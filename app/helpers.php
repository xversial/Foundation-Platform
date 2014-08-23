<?php

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
	function datagrid($data, $columns = [], $settings = [])
	{
		return app('datagrid')->make($data, $columns, $settings);
	}
}


function request()
{
	return app('request');
}

function response($message, $status = 200)
{
	return Illuminate\Support\Facades\Response::make($message, $status);
}
