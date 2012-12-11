<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst Software Licence.
 *
 * @package    Cartalyst Social
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst Software Licence - http://cartalyst.com/licence
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Platform\Social\Widgets;

use Theme;

class Form
{

	public function login()
	{
		// get providers listed in config
		$config_providers = \Config::get('sentrysocial::sentrysocial.providers');

		$providers = array();
		foreach ($config_providers as $provider => $val)
		{
			$providers[] = $provider;
		}

		return Theme::make('platform/social::widgets.login')->with('providers', $providers);
	}

}
