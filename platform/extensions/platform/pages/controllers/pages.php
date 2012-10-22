<?php

use Platform\Pages\Helper;

class Pages_Pages_Controller extends Public_Controller
{
	public function get_page($slug = false)
	{
		$slug = ($slug) ?: Platform::get('pages.default.page');

		$page = API::get('pages/'.$slug);
		$content = $page['content'];

		$pattern = "/@content\('([\w-_]+?)'\)/";

		$content = preg_replace_callback($pattern, 'Platform\Pages\Helper::content', $content);

		return Theme::make('pages::templates.'.$page['template'])
			->with('name', $page['name'])
			->with('content', $content);
	}
}