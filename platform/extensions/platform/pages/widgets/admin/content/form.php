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
 * @version    1.1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Platform\Pages\Widgets;

use API;
use APIClientException;
use Theme;

class Admin_Content_Form
{
	// status'
	//
	public $status = array(
			1 => 'enabled',
			0 => 'disabled',
	);

	/**
	 * Create Content Form
	 *
	 * @return  View
	 */
	public function create()
	{
		return Theme::make('platform/pages::widgets.content.form.create')
			->with('status', $this->status);
	}

	/**
	 * Edit Content Form
	 *
	 * @return  View
	 */
	public function edit($id)
	{
		// find content
		//
		try
		{
			$content = API::get('pages/content/'.$id);
		}
		catch(APIClientException $e)
		{
			\Platform::messages()->error($e->getMessage());
			return \Redirect::to_admin('pages/content');
		}

		return Theme::make('platform/pages::widgets.content.form.edit')
			->with('status', $this->status)
			->with('content', $content);
	}

	/**
	 * Clone Content Form
	 *
	 * @return view
	 */
	public function copy($id)
	{
		// find content
		//
		try
		{
			$content = API::get('pages/content/'.$id);
		}
		catch(APIClientException $e)
		{
			\Platform::messages()->error($e->getMessage());
			return \Redirect::to_admin('pages/content');
		}

		return Theme::make('platform/pages::widgets.content.form.copy')
			->with('status', $this->status)
			->with('content', $content);
	}

}
