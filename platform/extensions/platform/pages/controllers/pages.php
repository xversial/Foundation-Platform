<?php

use Platform\Pages\Helper;

class Platform_Pages_Pages_Controller extends Public_Controller
{
	public function get_page($slug = false)
	{
		$slug = ($slug) ?: Platform::get('platform/pages::default.page');

		try
		{
			$page = API::get('pages/'.$slug, array(
				'where' => array(
					array('status', '=', 1)
				)
			));

			if ( ! $page)
			{
				return Event::first('404');
			}
		}
		catch(APIClientException $e)
		{
			return Event::first('404');
		}

		$content = Helper::renderContent($page['value']);

		return Theme::make('platform.pages::templates.'.$page['template'])
			->with('name', $page['name'])
			->with('slug', $page['slug'])
			->with('content', $content);
	}
}
