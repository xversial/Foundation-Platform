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

class Platform_Social_Social_Controller extends SentrySocial_Auth_Controller
{
	/**
	 * This function is called before the action is executed.
	 *
	 * @return  void
	 */
	public function before()
	{
		Theme::active('frontend'.DS.Platform::get('platform/themes::theme.frontend'));
		Theme::fallback('frontend'.DS.'default');
	}

	public function get_register()
	{
		return Theme::make('platform/social::register');
	}

	public function get_login()
	{
		return Theme::make('platform/social::login');
	}
}
