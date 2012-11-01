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
		$this->active_menu('admin-developers-creator');

		return Theme::make('platform.developers::creator');
	}

	public function post_creator()
	{
		$zip = API::post('developers/create', array(
			'vendor'    => Input::get('vendor'),
			'extension' => Input::get('extension'),
			'encoding'  => 'base64',
		));

		return new Response(base64_decode($zip), 200, array(
			'Cache-Control'             => 'public',
			'Content-Description'       => 'File Transfer',
			'Content-Disposition'       => sprintf('attachment; filename=%s-%s.zip', Input::get('vendor'), Input::get('extension')),
			'Content-Type'              => 'application/x-zip',
			'Content-Transfer-Encoding' => 'binary',
		));
	}

}