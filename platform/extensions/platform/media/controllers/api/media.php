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

use Platform\Media\Media;
use Platform\Media\Processor;
use Platform\Media\ProcessorException;
use Platform\Media\ProcessorValidationException;

class Platform_Media_API_Media_Controller extends API_Controller
{

	/**
	 * Returns an array of media items or a single
	 * item.
	 *
	 *	<code>
	 *		$media = API::get('media');
	 *		$item  = API::get('media/1');
	 *	</code>
	 *
	 * @param   string  $slug
	 * @return  array
	 */
	public function get_index($id = false)
	{
		if ($id == false)
		{
			return Media::all();
		}

		$media = Media::find($id);

		if ($media === null)
		{
			return new Response(array(
				'message' => "Media item [$id] does not exist.",
			), API::STATUS_NOT_FOUND);
		}

		return $media;
	}

	/**
	 * Posts content to the media manager.
	 *
	 *	<code>
	 *		$media = API::post('media', array(
	 *			'content'    => base64_encode(File::get('path/to/file'))
	 *			'encoding'   => 'base64',
	 *			'name'       => 'some-file-name.png',
	 *			'validation' => 'image|max:100', // Laravel validation rules
	 *
	 *			// Placement rules to overwrite default config.
	 *			// structure is the same as in media config file.
	 *			'placement'  => array(),
	 *		));
	 *	</code>
	 *
	 * Note, we currently accept base64 and utf-8 as
	 * valid encoding for file contents.
	 *
	 * @return  Response
	 */
	public function post_index()
	{
		if ( ! $content = Input::get('content'))
		{
			return new Response(array(
				'message' => 'No file contents posted.',
			), API::STATUS_BAD_REQUEST);
		}

		// Decode the contents
		switch (Input::get('encoding'))
		{
			case 'utf-8':
				if (($content = utf8_decode($content)) === false)
				{
					return new Response(array(
						'message' => 'File failed to decode.',
					), API::STATUS_UNPROCESSABLE_ENTITY);
				}
				break;
			case 'base64':
				if (($content = base64_decode($content, true)) === false)
				{
					return new Response(array(
						'message' => 'File failed to decode.',
					), API::STATUS_UNPROCESSABLE_ENTITY);
				}
				break;
			default:
				return new Response(array(
					'message' => 'Invalid file encoding provided.',
				), API::STATUS_UNPROCESSABLE_ENTITY);
		}

		// Parse the name
		$name = Input::get('name');

		// Grab the filesystem
		$filesystem = Filesystem::make('native');

		// Full path to file
		$full_path = Processor::temporary_directory().DS.uniqid('', true).'.'.File::extension($name);

		try
		{
			// Silence PHP warnings
			if (@$filesystem->file()->make($full_path, $content))
			{
				goto passed_permissions;
			}

			goto failed_permissions;
		}
		catch (Exception $e)
		{
			goto failed_permissions;
		}

		// When permissions fail above, we throw an error here.
		// We use goto as to avoid repeaing code. DRY baby!
		//
		failed_permissions:

		return new Response(array(
				'message' => 'Failed to write temp media file. Possibly check permissions.',
			), API::STATUS_UNPROCESSABLE_ENTITY);

		passed_permissions:

		try
		{
			// Validate our upload
			Processor::validate($full_path, Input::get('validation'));
		}
		catch (ProcessorValidationException $e)
		{
			// Delete the file
			$filesystem->file()->delete($full_path);

			return new Response(array(
				'message' => $e->getMessage(),
				'errors'  => $e->errors() ?: array(),
			), API::STATUS_UNPROCESSABLE_ENTITY);
		}

		// The extension that owns the media
		$extension = Input::get('extension', DEFAULT_BUNDLE);
		$vendor = ($extension !== DEFAULT_BUNDLE) ? Input::get('vendor', ExtensionsManager::DEFAULT_VENDOR) : null;

		try
		{
			// Now, let's place our file in the
			// media folder structure. We merge in default
			// config with instance config for our placement
			// to occur.
			$result = Processor::place($full_path, array_merge(
				Config::get('platform/media::media.placement', array()),
				Input::get('placement', array()),
				array(
					'extension' => $extension,

					// Default the filename to the name of the uploaded file
					'filename'  => Input::get('name', pathinfo($full_path, PATHINFO_BASENAME)),
				)
			));
		}
		catch (ProcessorException $e)
		{
			// Delete the file
			$filesystem->file()->delete($full_path);

			return new Response(array(
				'message' => $e->getMessage(),
			), API::STATUS_UNPROCESSABLE_ENTITY);
		}

		// Now, create a model instance based on the result
		// we received
		$media = new Media(array(
			'vendor'         => $vendor,
			'extension'      => $extension,
			'name'           => $name,
			'file_path'      => array_get($result, 'file_path'),
			'file_name'      => array_get($result, 'file_name'),
			'file_extension' => array_get($result, 'file_extension'),
			'mime'           => array_get($result, 'mime'),
			'size'           => array_get($result, 'size'),
			'width'          => array_get($result, 'width'),
			'height'         => array_get($result, 'height'),
		));

		// Save the media
		if ($media->save())
		{
			return new Response(Media::find($media->id), API::STATUS_CREATED);
		}
		else
		{
			return new Response(array(
				'message' => Lang::line('platform/media::messages.update.error')->get(),
				'errors'  => ($media->validation()->errors->has()) ? $media->validation()->errors->all() : array(),
			), ($media->validation()->errors->has()) ? API::STATUS_BAD_REQUEST : API::STATUS_UNPROCESSABLE_ENTITY);
		}
	}

	/**
	 * Deletes a media item
	 *
	 * <code>
	 *		API::delete('media/1');
	 * </code>
	 *
	 * @param   int  $id
	 * @return  Response
	 */
	public function delete_index($id)
	{
		if (($media = Media::find($id)) === null)
		{
			return new Response(array(
				'message' => Lang::line('platform/media::media.delete.invalid_media_id')->get(),
			), API::STATUS_NOT_FOUND);
		}

		$media->delete();

		return new Response(null, API::STATUS_NO_CONTENT);
	}

	/**
	 * Returns fields required for a
	 * Platform.table
	 *
	 * @return  Response
	 */
	public function get_datatable()
	{
		$defaults = array(
			'select'   => array(
				'id'             => Lang::line('platform/media::media.general.id')->get(),
				'extension'      => Lang::line('platform/media::media.general.extension')->get(),
				'name'           => Lang::line('platform/media::media.general.name')->get(),
				'file_path'      => Lang::line('platform/media::media.general.file_path')->get(),
				'file_name'      => Lang::line('platform/media::media.general.file_name')->get(),
				'file_extension' => Lang::line('platform/media::media.general.file_extension')->get(),
				'mime'           => Lang::line('platform/media::media.general.mime')->get(),
				'size'           => Lang::line('platform/media::media.general.size')->get(),
				'width'          => Lang::line('platform/media::media.general.width')->get(),
				'height'         => Lang::line('platform/media::media.general.height')->get(),
				'created_at'     => Lang::line('platform/media::media.general.created_at')->get(),
			),
			'where'    => array(),
			'order_by' => array('id' => 'desc'),
		);

		// Lets get to total user count
		$count_total = Media::count();

		// Get the filtered count
		$count_filtered = Media::count(null, function($query) use ($defaults)
		{
			return Table::count($query, $defaults);
		});

		// Set paging
		$paging = Table::prep_paging($count_filtered, 20);

		$items = Media::all(function($query) use ($defaults, $paging)
		{
			list($query, $columns) = Table::query($query, $defaults, $paging);
			return $query;
		});

		$items = ($items) ?: array();

		return new Response(array(
			'columns'        => $defaults['select'],
			'rows'           => $items,
			'count'          => $count_total,
			'count_filtered' => $count_filtered,
			'paging'         => $paging,
		));
	}

}
