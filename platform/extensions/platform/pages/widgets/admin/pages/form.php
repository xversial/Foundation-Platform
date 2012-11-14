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

namespace Platform\Pages\Widgets;

use API;
use APIClientException;
use Platform;
use Platform\Pages\Helper;
use Theme;

class Admin_Pages_Form
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
		// default template
		//
		$template = Platform::get('platform/pages::default.template');

		// retrieve templates
		//
		$templates = Helper::findTemplates();

		return Theme::make('platform/pages::widgets.pages.form.create')
			->with('status', $this->status)
			->with('template', $template)
			->with('templates', $templates);
	}

	/**
	 * Edit Content Form
	 *
	 * @return  View
	 */
	public function edit($id)
	{
		// find pages
		//
		try
		{
			$data['page'] = API::get('pages/'.$id);
		}
		catch(APIClientException $e)
		{
			\Platform::messages()->error($e->getMessage());
			return \Redirect::to_admin('pages');
		}

		// retrieve templates
		//
		$templates = Helper::findTemplates();

		return Theme::make('platform/pages::widgets.pages.form.edit', $data)
			->with('status', $this->status)
			->with('templates', $templates);
	}

	/**
	 * Copy Content Form
	 *
	 * @return  View
	 */
	public function copy($id)
	{
		// find pages
		//
		try
		{
			$data['page'] = API::get('pages/'.$id);
		}
		catch(APIClientException $e)
		{
			\Platform::messages()->error($e->getMessage());
			return \Redirect::to_admin('pages');
		}

		// retrieve templates
		//
		$templates = Helper::findTemplates();

		return Theme::make('platform/pages::widgets.pages.form.copy', $data)
			->with('status', $this->status)
			->with('templates', $templates);
	}

}
