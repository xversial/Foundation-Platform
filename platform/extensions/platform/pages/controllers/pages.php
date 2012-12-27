<?php

use Platform\Pages\Helper;

class Platform_Pages_Pages_Controller extends Public_Controller
{
	public function get_page($slug = false)
	{
		$slug = ($slug) ?: Platform::get('platform/pages::default.page');

		try
		{
			// find the request page if it is active
			$page = API::get('pages/'.$slug, array(
				'where' => array(
					array('status', '=', 1)
				)
			));

			// if the page doesn't exist, return 404
			if ( ! $page)
			{
				return Event::first('404');
			}

			// if user doesn't have visibility, return invalid permissions
			if (($page['visibility'] and ! Sentry::check()))
			{
				return Redirect::to('invalid_permissions');
			}

			// decode and convert groups to array
			$page['groups'] = (array) json_decode($page['groups']);

			// if groups is not empty, check to make sure the user is in one of the groups
			if ( ! empty($page['groups']))
			{
				$in_groups = false;
				foreach ($page['groups'] as $group)
				{
					if (Sentry::user()->in_group($group))
					{
						$in_groups = true;
						break;
					}
				}

				if ( ! $in_groups )
				{
					return Redirect::to('invalid_permissions');
				}
			}
		}
		catch(APIClientException $e)
		{
			return Event::first('404');
		}

		if ($page['type'] == 'file')
		{
			return Theme::make('pages.'.$page['template'])
        		->with('name', Input::get('name'))
        		->with('slug', Input::get('slug'));
		}

		$content = Helper::renderContent($page['value']);

		return Theme::make('templates.layouts.'.$page['template'])
			->with('name', $page['name'])
			->with('slug', $page['slug'])
			->with('content', $content);
	}

	public function get_invalid_permissions()
	{

		return Theme::make('templates.layouts.'.Platform::get('platform/pages::default.template'))
			->with('name', 'Invalid Permissions')
			->with('slug', 'invalid-permissions')
			->with('content', 'You do not have the proper permissions to view this page.');
	}
}
