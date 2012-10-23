<?php

namespace Platform\Pages;

use API;
use APIClientException;
use Filesystem;
use Platform;

class Helper
{
	public static function content($slug = null)
	{
		if (is_array($slug))
		{
			$slug = $slug[1];
		}

		try
		{
			$content = API::get('pages/content/'.$slug);

			if ($content)
			{
				return static::renderContent($content['value']);
			}

			return Lang::line('pages::messages.content.not_found')->get();
		}
		catch(APIClientException $e)
		{
			return $e->getMessage();
		}
	}

	public static function renderContent($content)
	{
		$pattern = "/@content\('([\w-_]+?)'\)/";

		$content = preg_replace_callback($pattern, 'Platform\Pages\Helper::content', $content);

		return $content;
	}

	public static function findTemplates()
	{
		// Find current active and fallback themes for the frontend;
		//
		$themes['active'] = Platform::get('themes.theme.frontend');

		// Set the fallback if the theme is not on default
		//
		if ($themes['active'] != 'default')
		{
			$themes['fallback'] = 'default';
		}

		$templates = array();
		foreach ($themes as $theme => $name)
		{
			$path = path('public') . 'platform' . DS . 'themes' . DS . 'frontend'. DS . $name . DS . 'extensions' . DS . 'pages' . DS . 'templates';

			$files = glob($path.DS.'*.blade.php');

			foreach ($files as $file)
			{
				$file = str_replace('.blade.php', '', basename($file));
				$templates[$name][$file] = $file;
			}

		}

		return $templates;
	}
}
