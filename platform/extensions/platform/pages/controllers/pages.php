<?php

use Platform\Pages\Helper;

class Pages_Pages_Controller extends Public_Controller
{
	public function get_page($slug = false)
	{
		$slug = ($slug) ?: Platform::get('pages.default.page');

		try
		{
			$page = API::get('pages/'.$slug);

			if ( ! $page)
			{
				return Event::first('404');
			}
		}
		catch(APIClientException $e)
		{
			return Event::first('404');
		}

		$content = Helper::renderContent($page['content']);

		return Theme::make('pages::templates.'.$page['template'])
			->with('name', $page['name'])
			->with('slug', $page['slug'])
			->with('content', $content);
	}
}
