<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst Software Licence.
 *
 * @package    Cartalyst Media
 * @version    1.1.4
 * @author     Cartalyst LLC
 * @license    Cartalyst Software Licence - http://www.getplatform.com/licence
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

Autoloader::namespaces(array(
	'Platform\\Media\\Widgets' => __DIR__.DS.'widgets',
	'Platform\\Media'          => __DIR__.DS.'models',
));

// Add a @media() shortcut which outputs a media
// item. Media is an alias for @widget('cartalyst.media::media.url', :id)
Blade::extend(function($view)
{
	$pattern = Blade::matcher('media');

	return preg_replace($pattern, '<?php echo Platform::widget(\'platform/media::media.url\', $2); ?>', $view);
});
