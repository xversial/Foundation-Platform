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
			$content = API::get('pages/content/'.$slug, array(
				'where' => array(
					array('status', '=', 1)
				)
			));

			if ($content)
			{
				return static::renderContent($content['value']);
			}

			return Lang::line('platform/pages::messages.content.not_found')->get();
		}
		catch(APIClientException $e)
		{
			return null;
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
		$themes['active'] = Platform::get('platform/themes::theme.frontend');

		// Set the fallback if the theme is not on default
		//
		if ($themes['active'] != 'default')
		{
			$themes['fallback'] = 'default';
		}

		$templates = array();
		$templateNames = array();
		foreach ($themes as $theme => $name)
		{
			$path = path('public') . 'platform/themes/frontend/'.$name.'/templates/layouts';

			$files = glob($path.DS.'*.blade.php');

			foreach ($files as $file)
			{
				$file = str_replace('.blade.php', '', basename($file));

				// prevent duplicates because we use overriding
				if ( ! in_array($file, $templateNames))
				{
					$templates[$name][$file] = $file;
					$templateNames[] = $file;
				}
			}

		}

		return $templates;
	}

	public static function findPageFiles()
	{
		// Find current active and fallback themes for the frontend;
		//
		$themes['active'] = Platform::get('platform/themes::theme.frontend');

		// Set the fallback if the theme is not on default
		//
		if ($themes['active'] != 'default')
		{
			$themes['fallback'] = 'default';
		}

		$files = array();
		$fileNames = array();
		foreach ($themes as $theme => $name)
		{
			$path = path('public') . 'platform/themes/frontend/'.$name.'/extensions/platform/pages/files';

			$_files = glob($path.DS.'*.blade.php');

			foreach ($_files as $file)
			{
				$file = str_replace('.blade.php', '', basename($file));

				// prevent duplicates because we use overriding
				if ( ! in_array($file, $fileNames))
				{
					$files[$name][$file] = $file;
					$fileNames[] = $file;
				}
			}

		}

		return $files;
	}
}
