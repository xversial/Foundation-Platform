<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst Software Licence.
 *
 * @package    Cartalyst Media
 * @version    1.0.0
 * @author     Cartalyst LLC
 * @license    Cartalyst Software Licence - http://www.getplatform.com/licence
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Platform\Media\Widgets;

use API;
use Config;
use Lang;
use Platform;
use Theme;

class Media
{

	/**
	 * Stores whether chooser has been called before.
	 * If so, we don't load JS and all that junk twice.
	 *
	 * @var bool
	 */
	protected static $chooser_loaded = false;

	/**
	 * Presents a media chooser. 
	 * 
	 * Default usage:
	 * 
	 * <code>
	 * 		@widget('platform/media::media.chooser', 'my-chooser-instance')
	 * </code>
	 * 
	 * To use a callback function to retrieve media items, call the $.mediaChooser() 
	 * in conjuction with widget.
	 *
	 *	<code>
	 *		@widget('platform/media::media.chooser', 'my-chooser-instance', array('js'=>false))
	 *		@section('scripts')
	 *			<script>
	 *				(function($) {
	 *					$('#my-chooser-instance').mediaChooser({
	 * 
	 *						choose : {
	 *      					callback: function(items, mediaChooser) {
	 *           
	 *           					// Do something with array of items
	 *							    // chosen. Each item matches up with
	 *							    // the platform\Media\Media model instance.
	 * 							}
	 *      					
	 *						}
	 *					});
	 *				})(jQuery);
	 *			</script>
	 *		@endsection
	 *	</code>
	 *
	 * The second @widget() parameter is the intance name of the
	 * chooser. This is required and must be unique among
	 * page requests. This is used to uniquely identify
	 * each chooser instance should there be more on the
	 * one page.
	 *
	 * The third parameter is an array of configuration options for
	 * each chooser instance. Options are visible in the defaults below.
	 *
	 * @param   string  $instance
	 * @param   array   $options
	 * @return  string
	 */
	public function chooser($extension, array $options = array())
	{
		$parts = Platform::parse_extension_string($extension);
		$vendor     = $parts['vendor'];
		$extension  = $parts['extension'];
		$identifier = $parts['path'];

		// Some parts are required.
		//
		if ( ! $extension or ! $identifier)
		{
			return '';
		}

		// Grab the datatable for uploaded media
		// items.
		//
		$datatable = API::get('media/datatable');

		$default_extensions = Config::get('platform/media::media.validation.mimes');
		$default_mimes      = array();

		foreach ($default_extensions as $extension)
		{
			if ($mimes = Config::get('mimes.'.$extension))
			{
				if (is_array($mimes))
				{
					foreach ($mimes as $mime)
					{
						$default_mimes[] = $mime;
					}
				}
				else
				{
					$default_mimes[] = $mimes;
				}
			}
		}

		// Array of default widget options.
		//
		$default_options = array(

			// Whether the widget generates the
			// required JS or not.
			'js' => true,

			// Limit of file(s) to choose.
			//
			'limit' => 0,

			// Allowed file extensions
			'extensions' => $default_extensions,
			'mimes'      => $default_mimes,

			// Link specfic options. If link is
			// set to FALSE, a link does not show up.
			//
			'link' => array(
				'title'      => Lang::line('platform/media::chooser.link.title')->get(),
				'attributes' => array(
					'class' => 'btn',
					'id'    => 'media-chooser-link-'.$identifier,
				),
			),

			// Default choose method
			'default' => 'upload',

			// Upload specific options. If upload is
			// set to FALSE, uploading is not enabled.
			//
			'upload' => array(),

			// Library specific options. If library is
			// set to FALSE, library is not enabled.
			//
			'library' => array(),
		);

		// Recursively overwrite the options
		//
		$options = array_replace_recursive($default_options, $options);

		// Check we have at least one way of uploading
		if ($options['upload'] === false and $options['library'] === false)
		{
			return '';
		}

		// Now, based on the options provided,
		// let's build some useful data to go to
		// our view.
		//
		$data = array(
			'vendor'     => $vendor,
			'extension'  => $extension,
			'identifier' => $identifier,

			// Automatic JS
			//
			'js' => $options['js'],

			// Limit
			//
			'limit' => (int) $options['limit'],

			// Extensions
			//
			'extensions' => $options['extensions'],

			// Mimes
			//
			'mimes' => $options['mimes'],

			// Link data
			//
			'link'    => $options['link'],

			// Upload data
			'upload'  => $options['upload'],

			// Library data
			'library' => ($options['library'] !== false)
				? array_replace($options['library'], array(
					'columns' => $datatable['columns'],
				))
				: false,
		);

		// If we have an invalid default choose method
		if ( ! isset($options[$options['default']]) or ($options[$options['default']] === false))
		{
			if ($options['upload'])
			{
				$data['default'] = 'upload';
			}
			elseif ($options['library'])
			{
				$data['default'] = 'library';
			}
		}

		// Else, we have a valid default
		else
		{
			$data['default'] = $options['default'];
		}

		// echo '<pre>';
		// print_r($data);
		// die();

		$view = Theme::make('platform.media::widgets.media.chooser', $data);

		static::$chooser_loaded === false and static::$chooser_loaded = true;

		return $view;
	}

	/**
	 * Outputs media by the given ID. If the ID doesn't
	 * match an item, FALSE is returned. If the item is
	 * a valid URL, the URL is returend. Maybe in the future,
	 * we can cache this item from the URL or something. Not
	 * for now though.
	 *
	 * @param  mixed  $media
	 * @return string
	 */
	public function url($media)
	{
		// If the media is a valid URL, return it
		if (filter_var($media, FILTER_VALIDATE_URL) !== false)
		{
			return $media;
		}

		try
		{
			// Grab the media item
			$media = API::get('media/'.$media);
		}
		catch (APINotFoundException $e)
		{
			return false;
		}

		return $media['url'];
	}

}
