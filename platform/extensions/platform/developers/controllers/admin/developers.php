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
 * @version    1.1.1
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

/**
 * --------------------------------------------------------------------------
 * Developers > Admin Class
 * --------------------------------------------------------------------------
 *
 * Developers management.
 *
 * @package    Platform
 * @author     Cartalyst LLC
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @license    BSD License (3-clause)
 * @link       http://cartalyst.com
 * @version    1.1
 */
class Platform_Developers_Admin_Developers_Controller extends Admin_Controller
{
	public function get_index()
	{
		// Coming soon is more developer tools. For now,
		// we'll just go straight to the module creator
		return Redirect::to_admin('developers/extension_creator');
	}

	public function get_extension_creator()
	{
		// Set the active menu item
		$this->active_menu('admin-developers-extension-creator');

		// Data
		$data = array(

			// Reserved vendors
			'reserved_vendors' => array(ExtensionsManager::CORE_VENDOR),

			// Default vendor
			'default_vendor' => ExtensionsManager::DEFAULT_VENDOR,

			// Existing extensions
			'extensions' => API::get('extensions'),
		);

		return Theme::make('platform/developers::extension.creator', $data);
	}

	public function post_extension_creator()
	{
		$zip = API::post('developers/create_extension', array(

			// Send through properties of the extension
			'name'         => Input::get('name'),
			'author'       => Input::get('author'),
			'description'  => Input::get('description'),
			'version'      => Input::get('version'),
			'vendor'       => Input::get('vendor'),
			'extension'    => Input::get('extension'),
			'dependencies' => array_map(function($dependency)
				{
					return trim($dependency);
				}, explode(PHP_EOL, Input::get('dependencies'))),
			'overrides' => array_map(function($override)
				{
					return trim($override);
				}, explode(PHP_EOL, Input::get('overrides'))),

			// Tell the API how we want our extension
			// returned to us. We can either base64 encode
			// or utf-8 encode the ZIP contents.
			'encoding'  => 'base64',
		));

		// Check we have valid contents
		if (($contents = base64_decode($zip)) === false)
		{
			Platform::message()->error(Lang::line('platform/developers::messages.creator.decode_fail'));

			return Redirect::to_admin('developers/create');
		}

/*
		// The name the ZIP should get
		$name = sprintf('%s-%s.zip', Input::get('vendor', 'vendor'), Input::get('extension', 'extension'));

		// Let's build some headers up to allow us to stream the file
		$headers = array(
			'Content-Description'       => 'File Transfer',
			'Content-Type'              => File::mime('zip'),
			'Content-Transfer-Encoding' => 'binary',
			'Expires'                   => 0,
			'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
			'Pragma'                    => 'public',
			'Content-Length'            => Str::length($contents),
		);

		// Once we create the response, we need to set the content disposition
		// header on the response based on the file's name. We'll pass this
		// off to the HttpFoundation and let it create the header text.
		$response = new Response($contents, 200, $headers);

		$d = $response->disposition($name);

		return $response->header('Content-Disposition', $d);
*/
	}

	public function get_theme_creator()
	{
		// Set the active menu item
		$this->active_menu('admin-developers-theme-creator');

		return Theme::make('platform/developers::theme.creator');
	}

	public function post_theme_creator()
	{
		$zip = API::post('developers/create_theme', array(

			// Send through properties of the extension
			'name'        => Input::get('name'),
			'author'      => Input::get('author'),
			'description' => Input::get('description'),
			'version'     => Input::get('version'),
			'area'        => Input::get('area'),

			// Tell the API how we want our extension
			// returned to us. We can either base64 encode
			// or utf-8 encode the ZIP contents.
			'encoding'  => 'base64',
		));

		// Check we have valid contents
		if (($contents = base64_decode($zip)) === false)
		{
			Platform::message()->error(Lang::line('platform/developers::messages.creator.decode_fail'));

			return Redirect::to_admin('developers/create');
		}

/*
		// The name the ZIP should get
		$name = sprintf('%s-%s.zip', Input::get('vendor', 'vendor'), Input::get('extension', 'extension'));

		// Let's build some headers up to allow us to stream the file
		$headers = array(
			'Content-Description'       => 'File Transfer',
			'Content-Type'              => File::mime('zip'),
			'Content-Transfer-Encoding' => 'binary',
			'Expires'                   => 0,
			'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
			'Pragma'                    => 'public',
			'Content-Length'            => Str::length($contents),
		);

		// Once we create the response, we need to set the content disposition
		// header on the response based on the file's name. We'll pass this
		// off to the HttpFoundation and let it create the header text.
		$response = new Response($contents, 200, $headers);

		$d = $response->disposition($name);

		return $response->header('Content-Disposition', $d);
*/
	}

}