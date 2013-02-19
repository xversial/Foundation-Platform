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
 * @version    1.1.4
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
use Redirect;
use Theme;

class Admin_Pages_Form
{
	// status'
	//
	public $status = array(
			1 => 'enabled',
			0 => 'disabled',
	);

	// visiblity options
	//
	public $visibility_options = array(
		0 => 'Show Always',
		1 => 'Logged In',
	);

	// types
	//
	public $types = array(
		'db'   => 'Database',
		'file' => 'File',
	);

	public $groups = array();

	/**
	 * retrieve groups
	 */
	public function __construct()
	{
		try
		{
			$groups_result = API::get('users/groups');

			$groups = array();
			foreach ($groups_result as $group)
			{
				$groups[$group['name']] = $group['name'];
			}

			$this->groups = $groups;
		}
		catch(APIClientException $e)
		{
			Platform::messages()->error($e->getMessage());
		}
	}

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

		// retrieve page files
		//
		$files = Helper::findPageFiles();

		return Theme::make('platform/pages::widgets.pages.form.create')
			->with('status', $this->status)
			->with('visibility_options', $this->visibility_options)
			->with('groups', $this->groups)
			->with('template', $template)
			->with('templates', $templates)
			->with('types', $this->types)
			->with('files', $files);
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
			$page = API::get('pages/'.$id);

			$page['groups'] = (array) json_decode($page['groups']);
		}
		catch(APIClientException $e)
		{
			Platform::messages()->error($e->getMessage());
			return Redirect::to_admin('pages')->send();
		}

		// retrieve templates
		//
		$templates = Helper::findTemplates();

		// retrieve page files
		//
		$files = Helper::findPageFiles();

		return Theme::make('platform/pages::widgets.pages.form.edit')
			->with('page', $page)
			->with('status', $this->status)
			->with('visibility_options', $this->visibility_options)
			->with('groups', $this->groups)
			->with('templates', $templates)
			->with('types', $this->types)
			->with('files', $files);
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
			$page = API::get('pages/'.$id);

			$page['groups'] = (array) json_decode($page['groups']);
		}
		catch(APIClientException $e)
		{
			Platform::messages()->error($e->getMessage());
			return Redirect::to_admin('pages')->send();
		}

		if ($page['type'] == 'file')
		{
			Platform::messages()->error('Can not copy pages of type: file');
			return Redirect::to_admin('pages')->send();
		}

		// retrieve templates
		//
		$templates = Helper::findTemplates();

		return Theme::make('platform/pages::widgets.pages.form.copy')
			->with('page', $page)
			->with('status', $this->status)
			->with('visibility_options', $this->visibility_options)
			->with('groups', $this->groups)
			->with('templates', $templates)
			->with('types', $this->types);
	}

}
