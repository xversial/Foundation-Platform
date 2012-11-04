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
 * @version    1.0.3
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
		return Redirect::to_admin('developers/creator');
	}

	public function get_creator()
	{
		// Set the active menu item
		$this->active_menu('admin-developers-creator');

		// Data
		$data = array(

			// Reserved vendors
			'reserved_vendors' => array(ExtensionsManager::CORE_VENDOR),

			// Default vendor
			'default_vendor' => ExtensionsManager::DEFAULT_VENDOR,

			// Existing extensions
			'extensions' => API::get('extensions'),
		);

		return Theme::make('platform/developers::creator', $data);
	}

	public function post_creator()
	{
		$zip = API::post('developers/create', array(
			'vendor'    => Input::get('vendor'),
			'extension' => Input::get('extension'),
			'encoding'  => 'base64',
		));

		if (($contents = base64_decode($zip)) === false)
		{
			Platform::message()->error(Lang::line('platform/developers::messages.creator.decode_fail'));

			return Redirect::to_admin('developers/create');
		}

		// The name the ZIP should get
		$name = 'extension.zip';

		// Let's build some headers up
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
	}

}